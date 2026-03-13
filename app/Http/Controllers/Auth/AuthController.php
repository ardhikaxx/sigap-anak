<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OrangtuaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Akun Anda tidak aktif.'],
            ]);
        }

        Auth::login($user, $request->filled('remember'));

        $user->update(['last_login' => now()]);

        if ($user->isNakes()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('mobile.home');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|digits:16|unique:orangtua_profile,nik',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ], [
            'nik.required' => 'NIK harus diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'orangtua',
        ]);

        OrangtuaProfile::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        Auth::login($user);

        return redirect()->route('mobile.home')->with('success', 'Registrasi berhasil! Selamat datang di SIGAP Anak.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
