<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman daftar.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran user baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            
            // 🚀 PERBAIKAN KRUSIAL 1: Tambahkan validasi phone_number
            'phone_number' => ['required', 'string', 'max:15'], 
            
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
            // 🚀 PERBAIKAN KRUSIAL 2: Simpan phone_number ke database
            'phone_number' => $request->phone_number, 
            
            'role' => 'member', // Default jadi member biasa
        ]);

        event(new Registered($user));

        Auth::login($user);

        // [FIX] ALUR BENAR: Setelah daftar, langsung masuk Dashboard
        return redirect(route('dashboard', absolute: false));
    }
}