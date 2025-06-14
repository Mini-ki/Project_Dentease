<?php

namespace App\Http\Controllers\Pasien;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;
use Carbon\Carbon; 
use App\Models\Dokter; 
use App\Models\Konsultasi; 

class JanjiController extends Controller
{
    /**
     * Menampilkan formulir untuk membuat janji temu.
     * Hanya bisa diakses oleh pengguna dengan peran 'pasien'.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'pasien') {
            return redirect()->route('login')->with('error', 'Akses tidak sah. Anda harus login sebagai pasien.');
        }

        $dokterList = Dokter::with('layananDokter')
                            ->select('id_dokter', 'nama_lengkap', 'id_layanan')
                            ->get();

        return view('pasien.janji', compact('dokterList'));
    }

    /**
     * Menyimpan janji temu baru ke database.
     * Hanya bisa diakses oleh pengguna dengan peran 'pasien'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'pasien') {
            return redirect()->route('login')->with('error', 'Akses tidak sah. Anda harus login sebagai pasien.');
        }

        $request->validate([
            'id_dokter' => 'required|exists:dokter,id_dokter',
            'keluhan' => 'nullable|string|max:1000',
            'tanggalJanji' => 'required|date|after_or_equal:' . Carbon::now()->addDays(2)->toDateString(),
        ]);

        $id_pasien_login = Auth::id(); 
        
        try {
            Konsultasi::create([
                'id_dokter' => $request->id_dokter,
                'id_pasien' => $id_pasien_login, 
                'keluhan' => $request->keluhan,
                'tanggal_konsultasi' => $request->tanggalJanji,
                'status' => 'Belum', 
                'status_pembayaran' => 'Belum', 
            ]);
            
            return redirect()->route('pasien.janji')->with('success', 'Janji temu berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat janji temu: ' . $e->getMessage());
        }
    }
}