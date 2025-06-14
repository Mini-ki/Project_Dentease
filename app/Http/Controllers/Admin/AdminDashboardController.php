<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter; 
use App\Models\Pasien; 
use App\Models\Konsultasi; 
use Illuminate\Support\Facades\Auth; 

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;

        $jumlahDokter = Dokter::count();
        $jumlahPasien = Pasien::count();
        $jumlahKonsultasi = Konsultasi::count();

        return view('admin.dashboard', compact('role', 'jumlahDokter', 'jumlahPasien', 'jumlahKonsultasi'));
    }
}