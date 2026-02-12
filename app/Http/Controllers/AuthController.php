<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Menampilkan form login
    public function login()
    {
        return view('login');
    }

    // Proses login
    public function authenticate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        Log::info($credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->role) {
                case 'super_admin':
                    return redirect()->route('super_admin.extension');
                case 'admin':
                    return redirect()->route('admin.extension');
                case 'humas':
                    return redirect()->route('humas.extension');
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'name' => 'nama salah',
                        'password' => 'password salah',
                        'role' => 'Role salah',
                    ]);
            }
        }

        return back()->withErrors([
            'name' => 'nama salah',
            'password' => 'password salah',
            'role' => 'Role salah',
        ]);
    }

    // Fungsi logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home'); // Redirect ke halaman home
    }
}
