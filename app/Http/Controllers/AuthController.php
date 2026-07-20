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
        \Log::info('[LOGIN-DEBUG] Step 1: Request received', [
            'login' => $request->input('login'),
            'role'  => $request->input('role'),
            'has_password' => !empty($request->input('password')),
        ]);

        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|string|in:pustakawan,anggota',
        ]);

        \Log::info('[LOGIN-DEBUG] Step 2: Validation passed');

        $role = $credentials['role'];
        if ($role === 'anggota') {
            \Log::info('[LOGIN-DEBUG] Blocked: role is anggota');
            return back()->withErrors([
                'login' => 'Login Anggota belum bisa dilakukan. Akun Anda harus diurus terlebih dahulu ke pihak perpustakaan.',
            ])->withInput($request->only('login', 'role'));
        }

        $loginInput = $credentials['login'];
        $password   = $credentials['password'];

        // Cari user berdasarkan username ATAU email
        $user = User::where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        \Log::info('[LOGIN-DEBUG] Step 3: User lookup', [
            'input'     => $loginInput,
            'found'     => $user ? 'YES' : 'NO',
            'user_role' => $user?->role,
            'username'  => $user?->username,
        ]);

        if (!$user) {
            \Log::warning('[LOGIN-DEBUG] FAIL: User not found for input: ' . $loginInput);
            return back()->withErrors([
                'login' => 'Username/email atau password yang Anda masukkan salah.',
            ])->withInput($request->only('login', 'role'));
        }

        // === PASSWORD VERIFICATION ===
        $storedPassword = $user->getAttributes()['password']; // ambil raw, tanpa cast
        $passwordValid  = false;

        \Log::info('[LOGIN-DEBUG] Step 4: Password check', [
            'stored_prefix' => substr($storedPassword, 0, 7),
            'is_bcrypt'     => str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$2a$'),
        ]);

        if (str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$2a$') || str_starts_with($storedPassword, '$argon2')) {
            $passwordValid = Hash::check($password, $storedPassword);
            \Log::info('[LOGIN-DEBUG] Bcrypt check result: ' . ($passwordValid ? 'MATCH' : 'FAIL'));
        } else {
            if ($storedPassword === md5($password)) {
                $passwordValid = true;
                \Log::info('[LOGIN-DEBUG] MD5 match');
            } elseif ($storedPassword === sha1($password)) {
                $passwordValid = true;
                \Log::info('[LOGIN-DEBUG] SHA1 match');
            } elseif ($storedPassword === $password) {
                $passwordValid = true;
                \Log::info('[LOGIN-DEBUG] Plaintext match');
            } else {
                \Log::warning('[LOGIN-DEBUG] FAIL: No legacy format matched');
            }

            if ($passwordValid) {
                $user->forceFill(['password' => Hash::make($password)])->save();
                \Log::info('[LOGIN-DEBUG] Password rehashed to bcrypt');
            }
        }

        if (!$passwordValid) {
            \Log::warning('[LOGIN-DEBUG] FAIL: Password invalid');
            return back()->withErrors([
                'login' => 'Username/email atau password yang Anda masukkan salah.',
            ])->withInput($request->only('login', 'role'));
        }

        \Log::info('[LOGIN-DEBUG] Step 5: Password OK, checking role', [
            'user_role'      => $user->role,
            'requested_role' => $role,
            'match'          => $user->role === $role,
        ]);

        // Validate role
        if ($user->role !== $role) {
            $roleName = $role === 'pustakawan' ? 'Pustakawan' : 'Anggota';
            \Log::warning('[LOGIN-DEBUG] FAIL: Role mismatch');
            return back()->withErrors([
                'login' => "Akun Anda tidak terdaftar sebagai {$roleName}.",
            ])->withInput($request->only('login', 'role'));
        }

        // Login manual
        \Log::info('[LOGIN-DEBUG] Step 6: Calling Auth::login...');
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        $request->session()->save(); // Force write session to DB before redirect
        \Log::info('[LOGIN-DEBUG] Step 7: Auth::login done. auth()->check() = ' . (auth()->check() ? 'true' : 'false'));

        // Store credentials in cookies if remember is checked
        if ($request->boolean('remember')) {
            Cookie::queue('saved_login',    $loginInput, 60 * 24 * 30);
            Cookie::queue('saved_password', $password,   60 * 24 * 30);
            Cookie::queue('remember_role',  $role,       60 * 24 * 30);
            Cookie::queue('remember_checked', 'true',    60 * 24 * 30);
        } else {
            Cookie::queue(Cookie::forget('saved_login'));
            Cookie::queue(Cookie::forget('saved_password'));
            Cookie::queue(Cookie::forget('remember_role'));
            Cookie::queue(Cookie::forget('remember_checked'));
        }

        $roleText      = $role === 'pustakawan' ? 'Pustakawan' : 'Anggota';
        $redirectRoute = $role === 'pustakawan' ? 'admin.index' : 'home';

        \Log::info('[LOGIN-DEBUG] Step 8: Redirecting to ' . $redirectRoute);
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
