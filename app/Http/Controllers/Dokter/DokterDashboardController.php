<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DokterDashboardController extends Controller
{
    /**
     * Menampilkan dashboard dokter.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $id_dokter = Auth::id();

        $jumlah_pasien = DB::table('pasien')->count();

        $jumlah_konsultasi = DB::table('konsultasi')->count();

        $jumlah_selesai = DB::table('konsultasi')
                            ->where('status', 'sudah selesai')
                            ->count();

        $jumlah_belum = DB::table('konsultasi')
                        ->whereIn('status', ['belum', 'sedang konsultasi'])
                        ->count();

        $dokter = DB::table('dokter')->where('id_dokter', $id_dokter)->first();

        return view('dokter.dashboard', compact('jumlah_pasien', 'jumlah_konsultasi', 'jumlah_selesai', 'jumlah_belum', 'dokter'));
    }
}
