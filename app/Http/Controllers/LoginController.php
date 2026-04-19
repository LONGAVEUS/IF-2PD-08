<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function LoginPage() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 2. Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status !== 'aktif') {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun Anda tidak aktif.']);
            }

            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/dashboard_admin');
                case 'dosen':
                    return redirect()->intended('/dashboard_dosen');
                case 'mahasiswa':
                    return redirect()->intended('/dashboard_mahasiswa');
                default:
                    return redirect('/');
            }
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
