<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ensure the user is a customer
        if (!$user->customer) {
            abort(403, 'Access denied. Customer profile not found.');
        }
        
        $customer = $user->customer;
        
        return view('customer.profile.index', compact('user', 'customer'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer;

        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'address' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        // Update user details
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        // Update customer details
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->address = $request->address;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($customer->avatar) {
                Storage::disk('public')->delete($customer->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $customer->avatar = $avatarPath;
        }

        $customer->save();

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Password updated successfully.');
    }
}
