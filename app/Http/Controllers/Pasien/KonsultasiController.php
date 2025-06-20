<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konsultasi; 
use App\Models\UlasanDokter; 

class KonsultasiController extends Controller
{
    /**
     * Menampilkan daftar riwayat konsultasi pasien yang sedang login.
     * Halaman ini hanya bisa diakses oleh pengguna dengan peran 'pasien'.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $pasienId = Auth::id(); 
        
        $konsultasiList = Konsultasi::with([
                'dokter' => function($query) {
                    $query->select('id_dokter', 'nama_panggilan', 'id_layanan');
                },
                'dokter.layananDokter' => function($query) { 
                    $query->select('id_layanan', 'nama_layanan');
                },
                'rekamMedis',
                'ulasanDokter' => function($query) {
                    $query->select('id_konsultasi', 'id_dokter', 'rating', 'ulasan');
                }
            ])
            ->where('id_pasien', $pasienId)
            ->orderBy('tanggal_konsultasi', 'desc')
            ->get();

        $konsultasiList->each(function ($konsultasi) {
            $konsultasi->nama_panggilan = $konsultasi->dokter->nama_panggilan ?? 'N/A';
            $konsultasi->nama_layanan = $konsultasi->dokter->layananDokter->nama_layanan ?? 'N/A';
            $konsultasi->rating = $konsultasi->ulasanDokter->rating ?? null;
            $konsultasi->ulasan = $konsultasi->ulasanDokter->ulasan ?? 'Anda belum memberikan ulasan untuk konsultasi ini.';
        });

        return view('pasien.konsultasi', compact('konsultasiList'));
    }

    /**
     * Menyimpan atau memperbarui rating/ulasan untuk konsultasi tertentu.
     * Hanya bisa diakses oleh pengguna dengan peran 'pasien'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRating(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'pasien') {
            return redirect()->route('login')->with('error', 'Akses tidak sah. Anda harus login sebagai pasien.');
        }

        $request->validate([
            'id_konsultasi' => 'required|exists:konsultasi,id_konsultasi',
            'rating' => 'required|numeric|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        $id_konsultasi = $request->id_konsultasi;
        $id_pasien_auth = Auth::id();

        $konsultasi = Konsultasi::where('id_konsultasi', $id_konsultasi)
                                ->where('id_pasien', $id_pasien_auth)
                                ->first();

        if (!$konsultasi) {
            return back()->with('error', 'Konsultasi tidak ditemukan atau Anda tidak memiliki akses.');
        }

        try {
            UlasanDokter::updateOrCreate(
                ['id_konsultasi' => $id_konsultasi], 
                [
                    'id_dokter' => $konsultasi->id_dokter, 
                    'rating' => $request->rating,
                    'ulasan' => $request->ulasan,
                ]
            );

            return back()->with('success', 'Rating berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan rating: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus rating/ulasan yang sudah ada.
     * Hanya bisa diakses oleh pengguna dengan peran 'pasien'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRating(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'pasien') {
            return redirect()->route('login')->with('error', 'Akses tidak sah. Anda harus login sebagai pasien.');
        }

        $request->validate([
            'id_konsultasi' => 'required|exists:ulasan_dokter,id_konsultasi', 
        ]);

        $id_konsultasi = $request->id_konsultasi;
        $id_pasien_auth = Auth::id();

        try {
            $ulasan = UlasanDokter::where('id_konsultasi', $id_konsultasi)->first();

            if (!$ulasan) {
                return back()->with('error', 'Ulasan tidak ditemukan.');
            }

            if ($ulasan->konsultasi && $ulasan->konsultasi->id_pasien == $id_pasien_auth) {
                $ulasan->delete();
                return back()->with('success', 'Rating berhasil dihapus!');
            } else {
                return back()->with('error', 'Anda tidak memiliki izin untuk menghapus ulasan ini.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus rating: ' . $e->getMessage());
        }
    }
}