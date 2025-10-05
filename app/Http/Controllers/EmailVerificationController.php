<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EmailVerificationController extends Controller
{
    /**
     * Handle email verification with auto-login
     */
    public function verify(Request $request)
    {
        $userId = $request->query('id');
        $hash = $request->query('hash');
        $expires = $request->query('expires');
        $signature = $request->query('signature');
        
        // Verify the signature
        if (!hash_equals((string) $signature, 
            hash_hmac('sha256', $userId . $hash . $expires, config('app.key')))) {
            return redirect()->route('landing')->withErrors(['error' => 'Invalid verification link.']);
        }
        
        // Check if link has expired
        if (time() > $expires) {
            return redirect()->route('landing')->withErrors(['error' => 'Verification link has expired.']);
        }
        
        // Find the user
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('landing')->withErrors(['error' => 'User not found.']);
        }
        
        // Mark email as verified
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        
        // Auto-login the user
        Auth::login($user);
        
        // Redirect to appropriate dashboard based on user type
        if ($user->usertype === 'customer') {
            return redirect()->route('home')->with('success', 'Email verified successfully! Welcome to your dashboard.');
        } elseif ($user->usertype === 'drugstore') {
            return redirect()->route('drugstore.dashboard')->with('success', 'Email verified successfully! Welcome to your dashboard.');
        } elseif ($user->usertype === 'admin') {
            return redirect()->route('home')->with('success', 'Email verified successfully! Welcome to your dashboard.');
        }
        
        // Fallback to landing page
        return redirect()->route('landing')->with('success', 'Email verified successfully! You are now logged in.');
    }
    
    /**
     * Resend verification email
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('landing')->with('info', 'Email already verified.');
        }
        
        $request->user()->sendEmailVerificationNotification();
        
        return redirect()->route('landing')->with('success', 'Verification email sent!');
    }
}
