<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        
            Log::info('Checking role for user: ' . auth()->user()->id);
            if (!Auth::check()) {
                return redirect('/login')->with('error', 'You need to log in first.');
            }
        
             // Jika pengguna tidak memiliki salah satu dari role yang diizinkan
         // Log informasi hanya jika pengguna login
    Log::info('Checking role for user: ' . auth()->user()->id);

    // Jika pengguna tidak memiliki salah satu role yang diizinkan
   
        // Redirect berdasarkan role
        // if ($request->path() === 'admin/dashboard' && Auth::user()->role === 'admin') {
        //     abort(403, 'You do not have access to this page.');
        // }

        // if ($request->path() === 'admin/dashboard' && Auth::user()->role === 'master_admin') {
        //     abort(403, 'You do not have access to this page.');
        // }
    //     if (!in_array(Auth::user()->role, $roles)) {
    //     if (Auth::user()->role === 'admin') {
    //         return redirect('/admin/dashboard')->with('error', 'You do not have access to this page.');
        
    //     }
    //     elseif(Auth::user()->role === 'master_admin') {
    //         return redirect('/dashboard')->with('error', 'You do not have access to this page.');
    //     }
    //     else {
    //         return redirect('/halaman-user')->with('error', 'You do not have access to this page.');
    //     }
    // }
    if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
        abort(403, 'Unauthorized');
    }
   

    // Lanjutkan ke request berikutnya
    return $next($request);
        
    }
}
