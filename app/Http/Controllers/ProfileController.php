<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\File; 
use Illuminate\Validation\Rule; 

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
     * Update the user's profile information (Termasuk phone_number).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile picture or shop logo.
     */
    public function updateImage(Request $request): RedirectResponse
    {
        // 1. Validasi file gambar
        $request->validate([
            // Menggunakan nama input yang umum: 'profile_image' atau 'logo_file'
            // Asumsi di form Anda menggunakan 'image_file'
            'image_file' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $user = $request->user();
        
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file');
            
            // Membuat nama unik (timestamp + ID user + ekstensi)
            $imageName = time() . '_' . $user->id . '.' . $image->extension();
            
            // 2. Hapus gambar lama (Hanya hapus jika path yang tersimpan di DB tidak NULL)
            if ($user->profile_picture) { 
                $oldImagePath = public_path($user->profile_picture);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            
            // 3. Simpan gambar di direktori 'public/profile-images'
            $image->move(public_path('profile-images'), $imageName);
            
            // 4. Simpan path relatif baru ke database
            $user->profile_picture = 'profile-images/' . $imageName;
            
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'image-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->profile_picture) {
            $imagePath = public_path($user->profile_picture);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}