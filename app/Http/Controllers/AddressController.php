<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        return view('addresses', compact('addresses'));
    }

    public function create()
    {
        return view('add-address');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_type' => 'required|string',
            'custom_type' => 'required_if:address_type,other|string|nullable',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:50',
            'instructions' => 'nullable|string|max:500',
        ]);

        // If this is the first address or user wants it as default, make it default
        $isDefault = $request->has('default_address') || Auth::user()->addresses()->count() === 0;

        // If setting as default, remove default from other addresses
        if ($isDefault) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Address::create([
            'user_id' => Auth::id(),
            'address_type' => $request->address_type,
            'custom_type' => $request->custom_type,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'pickup_address' => $request->has('pickup_address'),
            'delivery_address' => $request->has('delivery_address'),
            'is_default' => $isDefault,
            'instructions' => $request->instructions,
        ]);

        return redirect()->route('addresses')->with('success', 'Address added successfully!');
    }

    public function destroy(Address $address)
    {
        // Check if user owns this address
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        // If deleted address was default, make the first remaining address default
        if ($address->is_default) {
            $firstAddress = Auth::user()->addresses()->first();
            if ($firstAddress) {
                $firstAddress->update(['is_default' => true]);
            }
        }

        return redirect()->route('addresses')->with('success', 'Address deleted successfully!');
    }

    public function setDefault(Address $address)
    {
        // Check if user owns this address
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Remove default from all user's addresses
        Auth::user()->addresses()->update(['is_default' => false]);

        // Set this address as default
        $address->update(['is_default' => true]);

        return redirect()->route('addresses')->with('success', 'Default address updated successfully!');
    }
}