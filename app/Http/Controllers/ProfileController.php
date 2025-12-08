<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash; 
use App\Models\Store; 
use App\Models\User; 


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (Termasuk Nomor Telepon).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // $request->validated() mencakup 'name', 'email', dan 'phone_number'.
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::back()->with('status', 'profile-updated'); // Menggunakan Redirect::back()
    }

    // ===============================================
    // METODE KRITIS: UPDATE PASSWORD (Dengan Logout Paksa)
    // ===============================================
    /**
     * Update the user's password.
     */
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // 1. Hash password baru
        $hashedPassword = Hash::make($request->password);
        
        // 2. Simpan password baru secara paksa (mengatasi fillable issue)
        $user->forceFill([
            'password' => $hashedPassword, 
        ])->save();

        // 3. LOGOUT PAKSA DAN BERSIHKAN SESI
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama (login), bukan ke halaman profil.
        return Redirect::to('/')->with('status', 'password-updated'); 
    }
    // ===============================================

    // ===============================================
    // METODE: UPDATE FOTO PROFIL (profile_picture & SINKRONISASI LOGO TOKO)
    // ===============================================
    /**
     * Update foto profil (menggunakan kolom profile_picture tunggal).
     */
    public function updateImage(Request $request): RedirectResponse
    {
        $user = Auth::user();
        DB::beginTransaction(); 

        // 1. VALIDASI
        try {
            $request->validate([
                'image_file' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Gagal validasi gambar: ' . $e->getMessage()); // Menggunakan Redirect::back()
        }

        $column_name = 'profile_picture'; 
        // Folder penyimpanan: stores/logos untuk seller, profiles untuk member
        $directory = ($user->role === 'seller') ? 'stores/logos' : 'profiles'; 

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $oldPath = $user->$column_name; // Path lama di users.profile_picture
            $path = null; // Inisialisasi path baru

            try {
                // 2. PENYIMPANAN GAMBAR BARU
                $path = $file->store($directory, 'public'); 
                
                // 3. PEMBARUAN DATABASE (users.profile_picture)
                $user->forceFill([
                    $column_name => $path, 
                ])->save();

                if ($user->role === 'seller') {
                    $store = Store::where('user_id', $user->id)->first();
                    if ($store) {
                        // Update kolom 'logo' di tabel 'stores'
                        $store->update(['logo' => $path]);
                    }
                }

                // 4. HAPUS GAMBAR LAMA (Hanya jika transaksi berhasil)
                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }

                DB::commit(); 

                return Redirect::back()->with('status', 'image-updated'); // Menggunakan Redirect::back()
                
            } catch (\Exception $e) {
                DB::rollBack(); 
                
                // Hapus file yang baru diupload jika terjadi error DB
                if (isset($path)) {
                    Storage::disk('public')->delete($path);
                }
                return Redirect::back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage()); // Menggunakan Redirect::back()
            }
        }

        return Redirect::back()->with('error', 'Tidak ada file gambar yang terdeteksi.'); // Menggunakan Redirect::back()
    }
    // ===============================================
    
    // ===============================================
    // METODE: DELETE AKUN
    // ===============================================
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // 1. Hapus Foto/Logo dari Storage
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // 2. Hapus logo toko jika user adalah seller dan memiliki relasi toko
        if ($user->role === 'seller' && $user->store) {
            // Cek apakah logo toko berbeda dengan profile_picture sebelum dihapus ganda
            if ($user->store->logo && $user->store->logo !== $user->profile_picture) {
                Storage::disk('public')->delete($user->store->logo);
            }
        }

        // 3. Logout dan Hapus Akun
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}