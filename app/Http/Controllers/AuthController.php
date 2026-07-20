<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form/page.
     */
    public function showLogin(Request $request)
    {
        $selectedRole = $request->query('role'); // can be 'pustakawan' or 'anggota'
        return view('login', compact('selectedRole'));
    }

    /**
     * Handle the login request.
     * Mendukung login via USERNAME atau EMAIL + password rehashing otomatis.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',       // bisa username atau email
            'password' => 'required|string',
            'role' => 'required|string|in:pustakawan,anggota',
        ]);

        $role = $credentials['role'];
        if ($role === 'anggota') {
            return back()->withErrors([
                'login' => 'Login Anggota belum bisa dilakukan. Akun Anda harus diurus terlebih dahulu ke pihak perpustakaan.',
            ])->withInput($request->only('login', 'role'));
        }

        $loginInput = $credentials['login'];
        $password = $credentials['password'];

        // Cari user berdasarkan username ATAU email
        $user = User::where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'login' => 'Username/email atau password yang Anda masukkan salah.',
            ])->withInput($request->only('login', 'role'));
        }

        // === PASSWORD VERIFICATION ===
        // Cek apakah password di database sudah dalam format Bcrypt/modern
        $storedPassword = $user->getAttributes()['password']; // ambil raw, tanpa cast
        $passwordValid = false;

        if (str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$2a$') || str_starts_with($storedPassword, '$argon2')) {
            // Password sudah dalam format modern (Bcrypt/Argon2)
            $passwordValid = Hash::check($password, $storedPassword);
        } else {
            // Password lama (kemungkinan MD5, SHA1, atau plain text)
            // Coba cocokkan dengan format lama yang umum digunakan OPAC
            if ($storedPassword === md5($password)) {
                $passwordValid = true;
            } elseif ($storedPassword === sha1($password)) {
                $passwordValid = true;
            } elseif ($storedPassword === $password) {
                // Plain text (sangat tidak aman, tapi mungkin ada di DB lama)
                $passwordValid = true;
            }

            // Jika cocok, REHASH ke Bcrypt agar aman ke depannya
            if ($passwordValid) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        }

        if (!$passwordValid) {
            return back()->withErrors([
                'login' => 'Username/email atau password yang Anda masukkan salah.',
            ])->withInput($request->only('login', 'role'));
        }

        // Validate role
        if ($user->role !== $role) {
            $roleName = $role === 'pustakawan' ? 'Pustakawan' : 'Anggota';
            return back()->withErrors([
                'login' => "Akun Anda tidak terdaftar sebagai {$roleName}.",
            ])->withInput($request->only('login', 'role'));
        }

        // Login manual (karena kita tidak bisa pakai Auth::attempt untuk password legacy)
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Store credentials in cookies for form auto-fill if remember is checked
        if ($request->boolean('remember')) {
            Cookie::queue('saved_login', $loginInput, 60 * 24 * 30); // 30 days
            Cookie::queue('saved_password', $password, 60 * 24 * 30);
            Cookie::queue('remember_role', $role, 60 * 24 * 30);
            Cookie::queue('remember_checked', 'true', 60 * 24 * 30);
        } else {
            Cookie::queue(Cookie::forget('saved_login'));
            Cookie::queue(Cookie::forget('saved_password'));
            Cookie::queue(Cookie::forget('remember_role'));
            Cookie::queue(Cookie::forget('remember_checked'));
        }

        $roleText = $role === 'pustakawan' ? 'Pustakawan' : 'Anggota';
        $redirectRoute = $role === 'pustakawan' ? 'admin.index' : 'home';
        return redirect()->route($redirectRoute)->with('success', "Selamat datang kembali, {$user->name}! Anda masuk sebagai {$roleText}.");
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        $userRole = Auth::check() ? Auth::user()->role : null;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($userRole === 'pustakawan') {
            return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem administrasi.');
        }

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
