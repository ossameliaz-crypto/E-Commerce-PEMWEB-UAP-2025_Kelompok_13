<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user sesuai dengan pintu yang mau dimasuki
        if (Auth::user()->role !== $role) {
            return redirect('/dashboard')->with('error', 'Anda tidak punya akses ke halaman tersebut!');
        }

        // 3. Khusus Seller: Harus punya toko 
        if ($role == 'seller' && $request->user()->role == 'member') {
        }

        return $next($request);
    }
}