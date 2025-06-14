<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;   

class BiayaController extends Controller
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

        $dokterList = DB::table('dokter')
            ->select('id_dokter', 'nama_panggilan', 'spesialis')
            ->orderBy('nama_panggilan')
            ->get();

        $layananList = DB::table('dokter')
            ->join('layanan_dokter', 'dokter.id_layanan', '=', 'layanan_dokter.id_layanan')
            ->select('dokter.nama_lengkap', 'layanan_dokter.nama_layanan', 'layanan_dokter.biaya_layanan')
            ->orderBy('dokter.nama_lengkap')
            ->get();

        return view('pasien.biaya', compact('dokterList', 'layananList'));
    }
}