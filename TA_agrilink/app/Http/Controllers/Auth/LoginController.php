<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Memeriksa kredensial dengan Auth::attempt().
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Cegah session fixation.
            $request->session()->regenerate();

            // Kembali ke halaman yang semula dituju; jika tidak ada -> daftar laporan.
            return redirect()->intended(route('agrilink.index'))
                ->with('sukses', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah. Periksa kembali data Anda.'])
            ->onlyInput('email');
    }

    /**
     * Keluar: hapus status login, matikan session, buat token CSRF baru.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sukses', 'Anda telah berhasil logout.');
    }
}
