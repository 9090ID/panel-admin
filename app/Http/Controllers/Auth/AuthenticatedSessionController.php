<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // if (Auth::attempt($request->only('email', 'password', 'role'))) {
        //     // \Log::info('User Logged In: ' . auth()->user()->email);
        //     // \Log::info('User Role: ' . auth()->user()->role); // Tambahkan ini
        //     return redirect()->intended('/admin/dashboard');
        // }
    
        // return back()->withErrors(['email' => 'Invalid credentials.']);
        if (Auth::attempt($request->only('email', 'password'))) {
            // Get the authenticated user
            $user = Auth::user();
    
            // Redirect based on user role
            if ($user->role === 'admin' || $user->role === 'master_admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'user') {
                return redirect()->intended('/halaman-user');
            } else {
                // Handle other roles or default case
                return redirect()->intended('/home'); // or any default route
            }
        }
    
        return back()->withErrors(['email' => 'Invalid credentials.']);
    
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
