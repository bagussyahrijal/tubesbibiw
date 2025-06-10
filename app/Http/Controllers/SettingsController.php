<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Account information updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'notifications_email' => $request->has('order_status'),
            'promotions_enabled' => $request->has('promotions'),
            'notifications_sms' => $request->has('service_reminders'),
        ]);

        return back()->with('success', 'Notification preferences updated successfully!');
    }

    public function exportData()
    {
        $user = Auth::user();
        
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'member_since' => $user->created_at->format('Y-m-d'),
            'membership_type' => $user->membership_type,
            'addresses' => $user->addresses()->get()->toArray(),
            'notification_preferences' => [
                'email_notifications' => $user->notifications_email,
                'promotions' => $user->promotions_enabled,
                'sms_notifications' => $user->notifications_sms,
            ],
            'exported_at' => now()->format('Y-m-d H:i:s'),
        ];

        $fileName = 'user_data_' . $user->id . '_' . now()->format('Y_m_d') . '.json';
        
        return response()
            ->json($userData, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }

        // In a real application, you might want to:
        // 1. Cancel active orders
        // 2. Delete associated data
        // 3. Send confirmation email
        // 4. Log the deletion for compliance

        // For now, we'll just log out and redirect
        Auth::logout();
        $user->delete();

        return redirect()->route('home')->with('success', 'Your account has been successfully deleted. We\'re sorry to see you go!');
    }
}