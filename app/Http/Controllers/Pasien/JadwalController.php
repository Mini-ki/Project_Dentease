<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;   

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal dokter beserta layanan.
     * Halaman ini hanya bisa diakses oleh pengguna dengan peran 'pasien'.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'pasien') {
            return redirect()->route('login')->with('error', 'Akses tidak sah. Anda harus login sebagai pasien.');
        }

        $dokters = DB::table('dokter')
            ->leftJoin('jadwal_dokter', 'dokter.id_dokter', '=', 'jadwal_dokter.id_dokter')
            ->leftJoin('layanan_dokter', 'dokter.id_layanan', '=', 'layanan_dokter.id_layanan')
            ->select(
                'dokter.id_dokter',
                'dokter.nama_panggilan',
                'layanan_dokter.nama_layanan',
                'jadwal_dokter.hari',
                'jadwal_dokter.jam_mulai',
                'jadwal_dokter.jam_selesai'
            )
            ->orderBy('dokter.nama_panggilan')
            ->get();

        $jadwalPerDokter = [];

        foreach ($dokters as $row) {
            $id = $row->id_dokter;
            $hari = $row->hari;
            $jam = $hari ? \Carbon\Carbon::parse($row->jam_mulai)->format('H:i') . '-' . \Carbon\Carbon::parse($row->jam_selesai)->format('H:i') : '-';

            if (!isset($jadwalPerDokter[$id])) {
                $jadwalPerDokter[$id] = [
                    'nama' => $row->nama_panggilan,
                    'layanan' => $row->nama_layanan ?? '-', 
                    'jadwal' => []
                ];
            }
            $jadwalPerDokter[$id]['jadwal'][$hari] = $jam;
        }

        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat']; 
        
        return view('pasien.jadwal', compact('jadwalPerDokter', 'hariList'));
    }
}