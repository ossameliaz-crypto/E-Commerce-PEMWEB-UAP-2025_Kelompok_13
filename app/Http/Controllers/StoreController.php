<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage; 
use Illuminate\Validation\ValidationException; 

class StoreController extends Controller
{
    public function create()
    {
        if (Auth::user()->role === 'seller' || Store::where('user_id', Auth::id())->exists()) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda sudah memiliki toko.'); 
        }
        
        return view('seller.register'); 
    }

    public function store(Request $request)
    {
        // 1. Validasi Data
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:stores,name', 
                'about' => 'nullable|string',
                'phone' => 'nullable|string',
                'city' => 'nullable|string',
                'address' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction(); 
        $logoPath = null; 

        try {
            $user = Auth::user();
            
            if (Store::where('user_id', $user->id)->exists()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Anda hanya diizinkan memiliki satu toko.');
            }

            // 2. Upload File & Update Profile Picture (DUAL UPDATE)
            if ($request->hasFile('logo')) { 
                // Simpan file ke storage
                $logoPath = $request->file('logo')->store('stores/logos', 'public');

                // Opsional: Hapus foto profil lama
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $user->update(['profile_picture' => $logoPath]);
            }
            
            // 3. Insert Data ke Tabel 'stores'
            Store::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'about' => $request->about,
                'logo' => $logoPath, 
                'phone' => $request->phone,
                'address_id' => null,
                'city' => $request->city,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'is_verified' => false,
            ]);

            // 4. Update Role User
            $user->update(['role' => 'seller']); 
            
            DB::commit(); 

            return redirect()->route('seller.dashboard')->with('success', 'Toko berhasil didaftarkan! Logo toko telah disinkronkan ke foto profil.');

        } catch (\Exception $e) {
            DB::rollBack(); 
            
            if ($logoPath) { Storage::disk('public')->delete($logoPath); }
            
            return redirect()->back()->with('error', 'Gagal memproses pendaftaran toko. Silakan coba lagi. Error DB: ' . $e->getMessage()); 
        }
    }
}