<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function LoginPage() {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status !== 'aktif') {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun Anda tidak aktif.']);
            }

            switch ($user->role) {
                case 'admin':

                    return redirect()->route('dashboard_admin')->with('success', 'Berhasil Login! Selamat datang Admin.');

                case 'dosen':

                    return redirect()->route('dashboard_dosen')->with('success', 'Berhasil Login! Selamat datang Dosen.');
                case 'mahasiswa':

                    return redirect()->route('dashboard_mahasiswa')->with('success', 'Berhasil Login! Selamat datang Mahasiswa.');

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
