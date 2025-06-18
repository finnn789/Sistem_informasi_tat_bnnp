<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the profile settings page
     */
    

    /**
     * Update profile information - FIXED VERSION
     */
    public function updateProfile(Request $request)
    {
        // SOLUSI 1: Ambil user ke variabel dulu (RECOMMENDED)
        $user = User::find(Auth::id());
        
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nrp' => ['nullable', 'string', 'max:50', 'unique:users,nrp,' . $user->id],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'satuan_kerja' => ['nullable', 'string', 'max:255'],
        ]);

        // Update dengan data yang sudah divalidasi
        $user->update($validatedData);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    
    /**
     * Update password - FIXED VERSION
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.letters' => 'Password harus mengandung huruf.',
            'password.numbers' => 'Password harus mengandung angka.',
        ]);

        // FIXED: Ambil user dan update password
        $user = User::find(Auth::id());
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Update profile photo - FIXED VERSION
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ], [
            'profile_photo.required' => 'Pilih foto terlebih dahulu.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format foto harus: JPEG, PNG, JPG, GIF, atau WebP.',
            'profile_photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // FIXED: Ambil user dengan benar
        $user = User::find(Auth::id());
        
        // Delete old photo
        if ($user->profile_photo) {
            Storage::delete($user->profile_photo);
        }

        // Store new photo
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $request->profile_photo->extension();
        $path = $request->profile_photo->storeAs('profile_photos', $filename, 'public');

        // Update user record
        $user->update(['profile_photo' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Delete profile photo - FIXED VERSION
     */
    public function deletePhoto()
    {
        $user = User::find(Auth::id());
        
        if ($user->profile_photo) {
            // Delete file from storage
            Storage::delete($user->profile_photo);
            
            // Update database
            $user->update(['profile_photo' => null]);
            
            return back()->with('success', 'Foto profil berhasil dihapus!');
        }

        return back()->with('error', 'Tidak ada foto profil untuk dihapus.');
    }
}