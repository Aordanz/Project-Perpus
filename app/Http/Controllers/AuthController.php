<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form/page.
     */
    public function showLogin(Request $request)
    {
        // If already logged in, redirect to home
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $selectedRole = $request->query('role'); // can be 'pustakawan' or 'anggota'
        return view('login', compact('selectedRole'));
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|string|in:pustakawan,anggota',
        ]);

        $role = $credentials['role'];
        if ($role === 'anggota') {
            return back()->withErrors([
                'email' => 'Login Anggota belum bisa dilakukan. Akun Anda harus diurus terlebih dahulu ke pihak perpustakaan.',
            ])->withInput($request->only('email', 'role'));
        }
        unset($credentials['role']);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Validate if user has the correct role
            if ($user->role !== $role) {
                Auth::logout();
                $roleName = $role === 'pustakawan' ? 'Pustakawan' : 'Anggota';
                return back()->withErrors([
                    'email' => "Akun Anda tidak terdaftar sebagai {$roleName}.",
                ])->withInput($request->only('email', 'role'));
            }

            $request->session()->regenerate();

            // Store credentials in cookies for form auto-fill if remember is checked
            if ($request->boolean('remember')) {
                Cookie::queue('saved_email', $credentials['email'], 60 * 24 * 30); // 30 days
                Cookie::queue('saved_password', $credentials['password'], 60 * 24 * 30);
                Cookie::queue('remember_role', $role, 60 * 24 * 30);
                Cookie::queue('remember_checked', 'true', 60 * 24 * 30);
            } else {
                Cookie::queue(Cookie::forget('saved_email'));
                Cookie::queue(Cookie::forget('saved_password'));
                Cookie::queue(Cookie::forget('remember_role'));
                Cookie::queue(Cookie::forget('remember_checked'));
            }

            $roleText = $role === 'pustakawan' ? 'Pustakawan' : 'Anggota';
            $redirectRoute = $role === 'pustakawan' ? 'admin.index' : 'home';
            return redirect()->route($redirectRoute)->with('success', "Selamat datang kembali, {$user->name}! Anda masuk sebagai {$roleText}.");
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email', 'role'));
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
