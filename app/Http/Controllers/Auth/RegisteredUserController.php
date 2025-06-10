<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nrp' => ['required', 'string', 'max:50', 'unique:users'], // NRP wajib diisi dan unik
            'no_telp' => ['nullable', 'string', 'max:15'], // Nomor telepon boleh kosong
            'satuan_kerja' => ['nullable', 'string', 'max:255'], // Satuan kerja boleh kosong
            'role' => ['required', 'in:operator,admin_bnn'], // Role wajib dan hanya bisa operator atau admin_bnn
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

         $user = User::create([
            'name' => $request->name,
            'nrp' => $request->nrp, // Simpan NRP
            'no_telp' => $request->no_telp, // Simpan No Telp
            'satuan_kerja' => $request->satuan_kerja, // Simpan Satuan Kerja
            'role' => $request->role, // Simpan Role
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
