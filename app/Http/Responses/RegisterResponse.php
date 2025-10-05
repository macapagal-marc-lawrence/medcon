<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Don't log the user in automatically
        // Instead, redirect to landing page with success message
        
        if ($request->wantsJson()) {
            return new JsonResponse([
                'message' => 'Registration successful. Please check your email to verify your account and access your dashboard.',
                'redirect' => route('landing')
            ], 201);
        }

        return redirect()->route('landing')->with('success', 'Registration successful! Please check your email to verify your account and access your dashboard.');
    }
}
