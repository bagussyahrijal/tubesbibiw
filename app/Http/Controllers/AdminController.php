<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Factory;
use DateTime;

class AdminController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase/firebase_credentials.json'));
        $this->firestore = $factory->createFirestore()->database();
    }

    public function index()
    {
        $ordersRef = $this->firestore->collection('orders');
        $ordersSnap = $ordersRef->orderBy('created_at', 'DESC')->limit(10)->documents();
        $orders = [];
        $recentOrders = [];
        foreach ($ordersSnap as $order) {
            $orders[] = array_merge(['id' => $order->id()], $order->data());
        }

        $totalOrders = $ordersRef->documents()->size();
        $totalFinishedCost = 0;
        foreach ($ordersRef->documents() as $order) {
            $data = $order->data();
            if (($data['status'] ?? '') === 'Finished') {
                $totalFinishedCost += $data['totalCost'] ?? 0;
            }
        }
        $userSnap = $this->firestore->collection('users')->where('role', '=', 'user')->documents();
        $totalUsers = $userSnap->size();

        $statusCounts = [
            'Payment' => $ordersRef->where('status', '=', 'Payment')->documents()->size(),
            'Pending to Process' => $ordersRef->where('status', '=', 'Pending to Process')->documents()->size(),
            'Processed' => $ordersRef->where('status', '=', 'Processed')->documents()->size(),
            'Finished' => $ordersRef->where('status', '=', 'Finished')->documents()->size(),
        ];

        $dailyRevenue = [];
        $now = new DateTime();

        $docs = $ordersRef->where('status', '=', 'Finished')->documents();

        for ($i = 6; $i >= 0; $i--) {
            $date = clone $now;
            $date->modify("-{$i} days");
            $dateStr = $date->format('Y-m-d');
            $revenue = 0;

            foreach ($docs as $doc) {
                $data = $doc->data();
                if (isset($data['createdAt'])) {
                    $createdAtDate = date('Y-m-d', strtotime($data['createdAt']));
                    if ($createdAtDate === $dateStr) {
                        $revenue += $data['totalCost'] ?? 0;
                    }
                }
            }

            $dailyRevenue[] = ['date' => $dateStr, 'total' => $revenue];
        }
        foreach ($ordersRef->documents() as $order) {
            $data = $order->data();
            if (isset($data['userId'])) {
                $userDoc = $this->firestore->collection('users')->document($data['userId'])->snapshot();
                $data['customerName'] = $userDoc->exists() ? $userDoc->data()['name'] : '-';
                $data['phone'] = $userDoc->exists() ? $userDoc->data()['phone'] : '-';
                $data['address'] = $userDoc->exists() ? $userDoc->data()['address'] : '-';
            }
            $recentOrders[] = $data;
        }


        return view('admin-dashboard', compact('totalUsers', 'orders', 'statusCounts', 'dailyRevenue', 'totalOrders', 'totalFinishedCost', 'recentOrders'));
    }

    public function manageUsers(Request $request)
    {
        $usersRef = $this->firestore->collection('users');

        $searchQuery = $request->query('search');

        $currentQuery = $usersRef->where('role', '=', 'user')->orderBy('name', 'ASC');

        $usersSnap = $currentQuery->documents();
        $allUsers = [];
        foreach ($usersSnap as $userDoc) {
            $allUsers[] = array_merge(['id' => $userDoc->id()], $userDoc->data());
        }

        if ($searchQuery) {
            $searchTermLower = strtolower($searchQuery);
            $filteredUsers = array_filter($allUsers, function ($user) use ($searchTermLower) {
                $name = strtolower($user['name'] ?? '');
                $email = strtolower($user['email'] ?? '');
                $phone = strtolower($user['phone'] ?? '');

                return str_contains($name, $searchTermLower) ||
                    str_contains($email, $searchTermLower) ||
                    str_contains($phone, $searchTermLower);
            });
            $finalUsers = array_values($filteredUsers);
        } else {
            $finalUsers = $allUsers;
        }

        $users = [];
        foreach ($finalUsers as $user) {
            if (isset($user['createdAt']) && $user['createdAt']) {
                $user['joinedDate'] = $user['createdAt']->get()->format('Y-m-d H:i');
            } else if (isset($user['createdAt'])) {
                try {
                    $user['joinedDate'] = (new DateTime($user['createdAt']))->format('Y-m-d H:i');
                } catch (\Exception $e) {
                    $user['joinedDate'] = '-';
                }
            } else {
                $user['joinedDate'] = '-';
            }
            $user['address'] = $user['address'] ?? '-';
            $users[] = $user;
        }

        return view('manage-users', compact(
            'users',
            'searchQuery'
        ));
    }

    public function edit($id)
    {
        $userDoc = $this->firestore->collection('users')->document($id)->snapshot();
        if (!$userDoc->exists()) {
            abort(404);
        }

        $user = array_merge(['id' => $userDoc->id()], $userDoc->data());
        $user['address'] = $user['address'] ?? '-';

        $nameParts = explode(' ', $user['name'] ?? '', 2);
        $user['firstName'] = $nameParts[0] ?? '';
        $user['lastName'] = $nameParts[1] ?? '';

        return view('edit-user', compact('user'));
    }

    public function manageOrders(Request $request)
    {
        $ordersRef = $this->firestore->collection('orders');
        $recentOrders = [];

        $searchQuery = $request->query('search');
        $statusFilter = $request->query('status');
        $dateStartFilter = $request->query('date_start');
        $dateEndFilter = $request->query('date_end');

        $currentQuery = $ordersRef->orderBy('createdAt', 'DESC');

        if (!empty($statusFilter)) {
            $currentQuery = $currentQuery->where('status', '=', $statusFilter);
        }

        if (!empty($dateStartFilter)) {
            try {
                $startDate = new DateTime($dateStartFilter . ' 00:00:00');
                $currentQuery = $currentQuery->where('createdAt', '>=', $startDate->getTimestamp());
            } catch (\Exception $e) {
            }
        }
        if (!empty($dateEndFilter)) {
            try {
                $endDate = new DateTime($dateEndFilter . ' 23:59:59'); // Akhir hari
                $currentQuery = $currentQuery->where('createdAt', '<=', $endDate->getTimestamp());
            } catch (\Exception $e) {
            }
        }


        $ordersSnap = $currentQuery->documents();
        $tempOrders = [];

        foreach ($ordersSnap as $orderDoc) {
            $data = $orderDoc->data();
            $data['id'] = $orderDoc->id();

            if (isset($data['userId'])) {
                $userDoc = $this->firestore->collection('users')->document($data['userId'])->snapshot();
                $data['customerName'] = $userDoc->exists() ? ($userDoc->data()['name'] ?? '-') : '-';
                $data['phone'] = $userDoc->exists() ? ($userDoc->data()['phone'] ?? '-') : '-';
                $data['address'] = $userDoc->exists() ? ($userDoc->data()['address'] ?? '-') : '-';
            } else {
                $data['customerName'] = '-';
                $data['phone'] = '-';
                $data['address'] = '-';
            }

            $paymentMethod = '-';
            $paymentQuery = $this->firestore
                ->collection('payments')
                ->where('orderId', '=', $orderDoc->id())
                ->documents();
            foreach ($paymentQuery as $paymentDoc) {
                if ($paymentDoc->exists()) {
                    $paymentMethod = $paymentDoc->data()['paymentMethod'] ?? '-';
                    break;
                }
            }
            $data['paymentMethod'] = $paymentMethod;

            if (isset($data['createdAt']) && $data['createdAt']) {
                $data['createdAt'] = $data['createdAt']->get()->format('d M Y, H:i');
            } else {
                $data['createdAt'] = $data['createdAt'] ?? '-';
            }

            $tempOrders[] = $data;
        }

        if ($searchQuery) {
            $searchTermLower = strtolower($searchQuery);
            $filteredOrders = array_filter($tempOrders, function ($order) use ($searchTermLower) {
                $customerName = strtolower($order['customerName'] ?? '');

                return str_contains($customerName, $searchTermLower);
            });
            $processedOrders = array_values($filteredOrders);
        } else {
            $processedOrders = $tempOrders;
        }

        $recentOrders = $processedOrders;

        return view('manage-orders', compact(
            'recentOrders',
            'searchQuery',
            'statusFilter',
            'dateStartFilter',
            'dateEndFilter'
        ));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $orderRef = $this->firestore->collection('orders')->document($id);
        $orderRef->update([
            ['path' => 'status', 'value' => $status]
        ]);
        return back()->with('success', 'Status updated!');
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string|max:255',
        ]);

        $fullName = $request->first_name . ' ' . $request->last_name;
        $currentDateTime = new DateTime();

        $this->firestore->collection('users')->add([
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'avatar' => null,
            'address' => $request->address ?: null,
            'createdAt' => $currentDateTime,
        ]);

        return redirect()->route('admin.users')->with('success', 'Registration successful!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $updateData = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address ?: null,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $this->firestore->collection('users')->document($id)->set($updateData, ['merge' => true]);

        return redirect()->route('admin.users')->with('success', 'User updated!');
    }

    public function destroy($id)
    {
        try {

            $userDoc = $this->firestore->collection('users')->document($id)->snapshot();
            if (!$userDoc->exists()) {
                return redirect()->route('admin.users')->with('error', 'User not found!');
            }

            $ordersRef = $this->firestore->collection('orders')->where('userId', '=', $id)->documents();
            foreach ($ordersRef as $orderDoc) {
                $paymentsRef = $this->firestore->collection('payments')->where('orderId', '=', $orderDoc->id())->documents();
                foreach ($paymentsRef as $paymentDoc) {
                    $paymentDoc->reference()->delete();
                }
                $orderDoc->reference()->delete();
            }

            $this->firestore->collection('users')->document($id)->delete();

            return redirect()->route('admin.users')->with('success', 'User, orders, and payments deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->with('error', 'Failed to delete user and related data: ' . $e->getMessage());
        }
    }
}
