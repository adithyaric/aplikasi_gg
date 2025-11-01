<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Halaman login
    public function index()
    {
        return view('auth.index');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'nrp' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'nrp' => $request->nrp,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('toast_success', 'Login berhasil!');
        }

        return back()->withErrors([
            'nrp' => 'NRP atau Password salah.',
        ])->onlyInput('nrp');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'))->with('toast_success', 'Anda telah logout.');
    }
}
