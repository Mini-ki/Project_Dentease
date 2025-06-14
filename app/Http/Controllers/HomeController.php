<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'dokter') {
            return redirect()->route('dokter.dashboard');
        } elseif ($user->role === 'pasien') {
            return redirect()->route('pasien.homepage');
        }

        return redirect()->route('welcome');
    }
}
?>