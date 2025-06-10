<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $faqItems = $this->getFaqItems();
        
        return view('support', compact('user', 'faqItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $user = Auth::user();
        
        // In a real application, you would save this to a database
        // and/or send an email to support team
        
        $supportData = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => now(),
        ];
        
        // Log the support request for now
        \Log::info('Support Request Submitted', $supportData);
        
        // In production, you might send an email:
        // Mail::to('support@blazandry.com')->send(new SupportRequestMail($supportData));
        
        return back()->with('success', 'Thank you! Your support request has been submitted. We will respond within 2 hours.');
    }

    private function getFaqItems()
    {
        return [
            [
                'question' => 'How do I schedule a laundry pickup?',
                'answer' => 'To schedule a pickup, go to the Schedule Pickup page in your dashboard, select your preferred date and time window, choose your services, and confirm your order. Our team will arrive during your selected time window.'
            ],
            [
                'question' => 'What are your operating hours?',
                'answer' => 'We offer pickup and delivery services from 8AM to 8PM, Monday through Saturday. Our cleaning facility operates 24/7 to ensure quick turnaround times.'
            ],
            [
                'question' => 'How long does laundry take to be returned?',
                'answer' => 'Standard service takes 24-48 hours from pickup to delivery. Express service (available for an additional fee) can return your laundry within 12 hours.'
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept all major credit cards (Visa, Mastercard, American Express), PayPal, and Apple Pay. You can manage your payment methods in the Payment section of your account.'
            ],
            [
                'question' => 'What if I need to cancel or reschedule my pickup?',
                'answer' => 'You can cancel or reschedule your pickup up to 2 hours before your scheduled time through your Orders page. For immediate assistance, contact our support team.'
            ],
            [
                'question' => 'Do you handle special care items?',
                'answer' => 'Yes! We offer specialized cleaning for delicate fabrics, dry cleaning, and stain treatment. Please specify any special care instructions when scheduling your pickup.'
            ],
            [
                'question' => 'What happens if an item is damaged?',
                'answer' => 'We take full responsibility for any items damaged during our care. Contact our support team immediately, and we will arrange for repair or replacement at no cost to you.'
            ],
            [
                'question' => 'How do I track my order?',
                'answer' => 'You can track your order status in real-time through your Orders page. You will also receive SMS/email notifications at each stage of the process.'
            ]
        ];
    }
}