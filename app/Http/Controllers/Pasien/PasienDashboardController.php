<?php

namespace App\Http\Controllers\Pasien;

use App\Models\LayananDokter; 
use App\Models\Feed;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;


class PasienDashboardController extends Controller
{
    /**
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'pasien') {
            return redirect()->route('login')->with('error', 'Akses tidak sah. Anda harus login sebagai pasien.');
        }

        $layananData = LayananDokter::with('dokter')->get();
        
        $artikel = Feed::select(
                'id_feed',
                'judul_feed',
                'image',
                'update_at',
                'created_at',
                'deskripsi',
                DB::raw('TRIM(SUBSTRING_INDEX(deskripsi, " ", 20)) AS summary')
            )
            ->orderBy('update_at', 'desc')
            ->limit(3)
            ->get();

        return view('pasien.homepage', compact('layananData', 'artikel'));
    }
}