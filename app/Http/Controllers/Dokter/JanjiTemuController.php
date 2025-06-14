<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konsultasi; 

class JanjiTemuController extends Controller
{
    /**
     * Menampilkan daftar janji temu/konsultasi yang belum atau sedang berjalan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $id_dokter_login = Auth::id(); 

        $konsultasi = Konsultasi::with('pasien') 
                                ->where('id_dokter', $id_dokter_login) 
                                ->whereIn('status', ['Belum', 'Sedang Konsultasi']) 
                                ->orderBy('tanggal_konsultasi', 'asc') 
                                ->get(); 

        return view('dokter.janjitemu', compact('konsultasi'));
    }

    /**
     * Memperbarui status konsultasi menjadi 'Sudah Selesai'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selesaikan(Request $request)
    {
        $request->validate([
            'id_konsultasi' => 'required|numeric|exists:konsultasi,id_konsultasi',
        ]);

        $id_dokter_login = Auth::id();

        $konsultasi = Konsultasi::where('id_konsultasi', $request->id_konsultasi)
                                ->where('id_dokter', $id_dokter_login)
                                ->first(); 

        if ($konsultasi) {
            $konsultasi->status = 'Sudah Selesai';
            $konsultasi->save();

            return redirect()->route('dokter.janjitemu')->with('success', 'Konsultasi berhasil diselesaikan!');
        } else {
            return redirect()->route('dokter.janjitemu')->with('error', 'Gagal menyelesaikan konsultasi atau konsultasi tidak ditemukan atau bukan milik Anda.');
        }
    }
}