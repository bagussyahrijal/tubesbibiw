<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');
        
        // Use real data from database
        $query = Order::forUser($user->id)
                     ->with('items')
                     ->orderBy('created_at', 'desc');
        
        if ($status !== 'all') {
            $query->byStatus($status);
        }
        
        $orders = $query->paginate(10);
        
        return view('orders', compact('orders', 'status', 'user'));
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                     ->forUser(Auth::id())
                     ->with('items')
                     ->firstOrFail();
        
        return view('order-tracker', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time_slot' => 'required|string',
            'pickup_address' => 'required|string|max:500',
            'services' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        
        try {
            // Calculate totals
            $subtotal = $this->calculateSubtotal($request->services);
            $taxAmount = $subtotal * 0.08; // 8% tax
            $deliveryFee = 2.99; // Flat rate
            $totalAmount = $subtotal + $taxAmount + $deliveryFee;

            // Create the order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'status' => 'pickup_scheduled',
                'pickup_date' => $request->pickup_date,
                'pickup_time_slot' => $request->pickup_time_slot,
                'pickup_address' => $request->pickup_address,
                'pickup_instructions' => $request->pickup_instructions,
                'delivery_address' => $request->delivery_address ?? $request->pickup_address,
                'delivery_instructions' => $request->delivery_instructions,
                'services' => $request->services,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $totalAmount,
                'special_instructions' => $request->special_instructions,
                'estimated_items_count' => $this->countTotalItems($request->services),
                'scheduled_at' => now(),
            ]);

            // Create order items
            foreach ($request->services as $service) {
                if (isset($service['items'])) {
                    foreach ($service['items'] as $item) {
                        $unitPrice = $this->getItemPrice($service['type'], $item['type']);
                        $totalPrice = $unitPrice * $item['quantity'];
                        
                        OrderItem::create([
                            'order_id' => $order->id,
                            'service_type' => $service['type'],
                            'item_type' => $item['type'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $unitPrice,
                            'total_price' => $totalPrice,
                            'special_instructions' => $item['instructions'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
                'redirect_url' => route('orders.show', $order->order_number)
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'pickup_scheduled'])) {
            return back()->withErrors(['message' => 'This order cannot be cancelled.']);
        }

        $order->updateStatus('cancelled');

        return back()->with('success', 'Order cancelled successfully.');
    }

    private function calculateSubtotal($services)
    {
        $subtotal = 0;
        
        foreach ($services as $service) {
            if (isset($service['items'])) {
                foreach ($service['items'] as $item) {
                    $unitPrice = $this->getItemPrice($service['type'], $item['type']);
                    $subtotal += $unitPrice * $item['quantity'];
                }
            }
        }
        
        return $subtotal;
    }

    private function getItemPrice($serviceType, $itemType)
    {
        // Define your pricing structure here
        $pricing = [
            'wash_fold' => [
                'shirt' => 2.50,
                'pants' => 3.00,
                'dress' => 4.00,
                'jacket' => 5.00,
                'underwear' => 1.50,
                'socks' => 1.00,
                'sweater' => 3.50,
                'jeans' => 3.50,
                'shorts' => 2.00,
                'skirt' => 2.50,
            ],
            'dry_cleaning' => [
                'suit' => 15.00,
                'dress' => 12.00,
                'coat' => 18.00,
                'shirt' => 8.00,
                'pants' => 10.00,
                'jacket' => 12.00,
                'blazer' => 12.00,
                'tie' => 5.00,
                'sweater' => 8.00,
            ],
            'ironing' => [
                'shirt' => 3.00,
                'pants' => 4.00,
                'dress' => 5.00,
                'jacket' => 6.00,
                'blouse' => 3.50,
                'skirt' => 3.00,
                'shorts' => 2.50,
            ]
        ];

        return $pricing[$serviceType][$itemType] ?? 0;
    }

    private function countTotalItems($services)
    {
        $total = 0;
        foreach ($services as $service) {
            if (isset($service['items'])) {
                foreach ($service['items'] as $item) {
                    $total += $item['quantity'];
                }
            }
        }
        return $total;
    }

    // Additional helper methods for order management
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,pickup_scheduled,picked_up,processing,ready,out_for_delivery,delivered,cancelled'
        ]);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->updateStatus($request->status);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'new_status' => $order->status_label
        ]);
    }

    public function reorder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Redirect to schedule page with order data
        return redirect()->route('schedule.create', [
            'reorder' => $order->order_number,
            'pickup_address' => $order->pickup_address,
            'services' => $order->services
        ]);
    }

    public function getOrderHistory(Request $request)
    {
        $user = Auth::user();
        $orders = Order::forUser($user->id)
                      ->with('items')
                      ->orderBy('created_at', 'desc')
                      ->paginate(20);

        return response()->json([
            'orders' => $orders->items(),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total()
            ]
        ]);
    }
}