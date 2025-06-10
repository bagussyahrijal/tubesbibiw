<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;

class ScheduleController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        
        // Get addresses that can be used for pickup and delivery
        $pickupAddresses = Address::where('user_id', $user->id)
                                 ->where('pickup_address', true)
                                 ->get();
        
        $deliveryAddresses = Address::where('user_id', $user->id)
                                   ->where('delivery_address', true)
                                   ->get();
        
        // If no specific pickup/delivery addresses, use all addresses
        if ($pickupAddresses->isEmpty()) {
            $pickupAddresses = Address::where('user_id', $user->id)->get();
        }
        
        if ($deliveryAddresses->isEmpty()) {
            $deliveryAddresses = Address::where('user_id', $user->id)->get();
        }
        
        // Check if user is reordering
        $reorderData = null;
        if ($request->has('reorder')) {
            $reorderOrder = Order::where('order_number', $request->get('reorder'))
                                ->where('user_id', $user->id)
                                ->first();
            if ($reorderOrder) {
                $reorderData = [
                    'pickup_address' => $request->get('pickup_address', $reorderOrder->pickup_address),
                    'services' => $request->get('services', $reorderOrder->services),
                ];
            }
        }
        
        return view('schedule', compact('user', 'pickupAddresses', 'deliveryAddresses', 'reorderData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_address_id' => 'required|exists:addresses,id',
            'pickup_date' => 'required|date|after_or_equal:tomorrow',
            'pickup_time' => 'required|string',
            'delivery_address_id' => 'required|exists:addresses,id',
            'delivery_date' => 'required|date|after:pickup_date',
            'delivery_time' => 'required|string',
            'services' => 'required|array|min:1',
        ]);

        // Get addresses
        $pickupAddress = Address::findOrFail($request->pickup_address_id);
        $deliveryAddress = Address::findOrFail($request->delivery_address_id);
        
        // Verify addresses belong to user
        if ($pickupAddress->user_id !== Auth::id() || $deliveryAddress->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to addresses');
        }

        // Transform the data for OrderController
        $orderData = [
            'pickup_date' => $request->pickup_date,
            'pickup_time_slot' => $request->pickup_time,
            'pickup_address' => $pickupAddress->full_address,
            'pickup_instructions' => $request->special_instructions,
            'delivery_date' => $request->delivery_date,
            'delivery_time_slot' => $request->delivery_time,
            'delivery_address' => $deliveryAddress->full_address,
            'delivery_instructions' => $request->delivery_instructions,
            'services' => $this->formatServices($request->services, $request->detergent, $request->fabric_softener),
            'special_instructions' => $request->special_instructions,
        ];

        // Create new request with transformed data
        $newRequest = new Request($orderData);
        $newRequest->setMethod('POST');

        // Delegate to OrderController for actual order creation
        $orderController = new OrderController();
        return $orderController->store($newRequest);
    }

    private function formatServices($services, $detergent = 'standard', $fabricSoftener = 'none')
    {
        return [
            [
                'type' => 'laundry_service',
                'services' => $services,
                'detergent' => $detergent,
                'fabric_softener' => $fabricSoftener,
                'items' => $this->generateServiceItems($services)
            ]
        ];
    }

    private function generateServiceItems($services)
    {
        $items = [];
        
        // Generate estimated items based on selected services
        foreach ($services as $service) {
            switch ($service) {
                case 'wash-fold':
                    $items[] = ['type' => 'mixed_items', 'quantity' => 10];
                    break;
                case 'dry-clean':
                    $items[] = ['type' => 'dry_clean_items', 'quantity' => 3];
                    break;
                case 'ironing':
                    $items[] = ['type' => 'iron_items', 'quantity' => 5];
                    break;
                case 'stain-removal':
                    $items[] = ['type' => 'stain_items', 'quantity' => 2];
                    break;
                case 'delicates':
                    $items[] = ['type' => 'delicate_items', 'quantity' => 4];
                    break;
                case 'bulky-items':
                    $items[] = ['type' => 'bulky_items', 'quantity' => 1];
                    break;
            }
        }
        
        return $items;
    }

    // Additional helper methods for schedule management
    public function getAvailableTimeSlots(Request $request)
    {
        $date = $request->get('date');
        $type = $request->get('type', 'pickup'); // pickup or delivery
        
        // Define available time slots
        $timeSlots = [
            '08:00-10:00' => '8:00 AM - 10:00 AM',
            '10:00-12:00' => '10:00 AM - 12:00 PM',
            '12:00-14:00' => '12:00 PM - 2:00 PM',
            '14:00-16:00' => '2:00 PM - 4:00 PM',
            '16:00-18:00' => '4:00 PM - 6:00 PM',
            '18:00-20:00' => '6:00 PM - 8:00 PM',
        ];
        
        // For delivery, exclude early morning slots
        if ($type === 'delivery') {
            unset($timeSlots['08:00-10:00']);
        }
        
        // Here you could add logic to check availability against existing orders
        // For now, return all slots as available
        
        return response()->json([
            'date' => $date,
            'type' => $type,
            'available_slots' => $timeSlots
        ]);
    }

    public function calculateEstimate(Request $request)
    {
        $services = $request->get('services', []);
        $detergent = $request->get('detergent', 'standard');
        $fabricSoftener = $request->get('fabric_softener', 'none');
        
        $subtotal = $this->calculateSubtotal($services, $detergent, $fabricSoftener);
        $taxAmount = $subtotal * 0.08; // 8% tax
        $deliveryFee = 2.99; // Flat rate
        $totalAmount = $subtotal + $taxAmount + $deliveryFee;
        
        return response()->json([
            'subtotal' => number_format($subtotal, 2),
            'tax_amount' => number_format($taxAmount, 2),
            'delivery_fee' => number_format($deliveryFee, 2),
            'total_amount' => number_format($totalAmount, 2),
            'estimated_items' => $this->estimateItemCount($services),
        ]);
    }

    private function calculateSubtotal($services, $detergent = 'standard', $fabricSoftener = 'none')
    {
        $subtotal = 0;
        
        // Base service pricing
        $pricing = [
            'wash-fold' => 25.00,      // Base price for wash & fold
            'dry-clean' => 40.00,      // Base price for dry cleaning
            'ironing' => 15.00,        // Base price for ironing
            'stain-removal' => 10.00,  // Base price for stain removal
            'delicates' => 20.00,      // Base price for delicates
            'bulky-items' => 35.00,    // Base price for bulky items
        ];
        
        foreach ($services as $service) {
            $subtotal += $pricing[$service] ?? 0;
        }
        
        // Add detergent cost
        $detergentPricing = [
            'standard' => 0,
            'hypoallergenic' => 2.00,
            'eco-friendly' => 3.00,
            'scent-free' => 1.50,
        ];
        $subtotal += $detergentPricing[$detergent] ?? 0;
        
        // Add fabric softener cost
        $fabricSoftenerPricing = [
            'none' => 0,
            'standard' => 1.00,
            'scent-free' => 1.50,
        ];
        $subtotal += $fabricSoftenerPricing[$fabricSoftener] ?? 0;
        
        return $subtotal;
    }

    private function estimateItemCount($services)
    {
        // Estimate item count based on selected services
        $estimates = [
            'wash-fold' => 12,
            'dry-clean' => 3,
            'ironing' => 5,
            'stain-removal' => 2,
            'delicates' => 4,
            'bulky-items' => 1,
        ];
        
        $totalItems = 0;
        foreach ($services as $service) {
            $totalItems += $estimates[$service] ?? 0;
        }
        
        return max($totalItems, 1); // At least 1 item
    }

    public function cancel($scheduleId)
    {
        // Find the order by schedule ID (assuming schedule ID is order ID)
        $order = Order::where('id', $scheduleId)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'pickup_scheduled'])) {
            return back()->withErrors(['message' => 'This schedule cannot be cancelled.']);
        }

        $order->updateStatus('cancelled');

        return redirect()->route('orders')->with('success', 'Schedule cancelled successfully.');
    }

    public function reschedule(Request $request, $scheduleId)
    {
        $request->validate([
            'pickup_date' => 'required|date|after_or_equal:tomorrow',
            'pickup_time' => 'required|string',
            'delivery_date' => 'required|date|after:pickup_date',
            'delivery_time' => 'required|string',
        ]);

        $order = Order::where('id', $scheduleId)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        // Check if order can be rescheduled
        if (!in_array($order->status, ['pending', 'pickup_scheduled'])) {
            return back()->withErrors(['message' => 'This schedule cannot be modified.']);
        }

        $order->update([
            'pickup_date' => $request->pickup_date,
            'pickup_time_slot' => $request->pickup_time,
            'delivery_date' => $request->delivery_date,
            'delivery_time_slot' => $request->delivery_time,
        ]);

        return redirect()->route('orders.show', $order->order_number)
                        ->with('success', 'Schedule updated successfully.');
    }
}