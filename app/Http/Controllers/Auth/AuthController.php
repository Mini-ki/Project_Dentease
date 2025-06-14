<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                Auth::guard('admin')->login($user);  
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'dokter') {
                Auth::guard('dokter')->login($user);  
                return redirect()->route('dokter.dashboard');
            } elseif ($user->role === 'pasien') {
                Auth::guard('pasien')->login($user);  
                return redirect()->route('pasien.homepage');
            } else {
                return redirect('/');  
            }
        }

        return back()->withErrors(['username' => 'Invalid credentials.'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();  

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
