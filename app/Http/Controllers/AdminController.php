<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;


class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->limit(10)->get();
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalAmount = Order::sum('total_amount');

        $statusCounts = [
            'Pending' => Order::where('payment_status', 'pending')->count(),
            'Paid' => Order::where('payment_status', 'paid')->count(),
            'Failed' => Order::where('payment_status', 'failed')->count(),
            'Refunded' => Order::where('payment_status', 'refunded')->count(),
        ];

        // Agregasi revenue 7 hari terakhir
        $dailyRevenue = Order::where('status', 'Finished')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin-dashboard', compact('totalUsers', 'orders', 'statusCounts', 'dailyRevenue', 'totalOrders', 'totalAmount'));
    }
    public function manageUsers()
    {
        $users = User::where('role', 'user')->get();
        return view('manage-users', compact('users'));
    }

    public function manageOrders()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->limit(10)->get();
        return view('manage-orders', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'avatar' => null,
            'role' => 'user',
        ]);


        return redirect()->route('admin.users')->with('success', 'Registration successful!');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted!');
    }
}
