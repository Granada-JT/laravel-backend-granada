<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            // If authentication fails, return a 401 Unauthorized response
            return response()->json([
                'message' => 'Invalid credentials, please try again.',
            ], 401); // 401 for Unauthorized
        }
    
        // If authentication is successful, regenerate the session token
        $request->session()->regenerate();
    
        // Return a JSON response with a success message and the redirect URL
        return response()->json([
            'message' => 'Login successful!',
            // 'redirect_url' => route('dashboard'),
        ], 200); // 200 for OK
    }
    
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        // Send a custom JSON response
        return response()->json([
            'message' => 'Logout successful!',
            // 'redirect_url' => '/',
        ], 200); // 200 is the HTTP status code
    }
}
