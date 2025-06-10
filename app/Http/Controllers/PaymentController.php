<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        // Show payment methods page
        return view('payment');
    }

    public function checkout()
    {
        // Show checkout/payment page
        return view('payment-page');
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_holder_name' => 'required|string|max:255',
            'card_number' => 'required|string|max:19',
            'expiry_date' => 'required|string|max:5',
            'cvv' => 'required|string|max:4',
            'payment_type' => 'required|string|in:credit_card,debit_card,paypal',
        ]);

        // In a real application, you would save the payment method
        // For security reasons, never store actual card details
        
        return redirect()->route('payment.methods')->with('success', 'Payment method added successfully!');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'order_total' => 'required|numeric|min:0',
        ]);

        // In a real application, you would process the payment here
        // This would integrate with payment gateways like Stripe, PayPal, etc.
        
        return redirect()->route('orders')->with('success', 'Payment processed successfully! Your order has been confirmed.');
    }

    public function pricing()
    {
        // Show pricing page
        return view('pricing');
    }
}