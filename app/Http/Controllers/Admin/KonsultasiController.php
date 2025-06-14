<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konsultasi; 
use App\Models\Dokter;     
use App\Models\Pasien;     

class KonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $userRole = Auth::user()->role;

        $jumlah_konsultasiSelesai = Konsultasi::where('status', 'Sudah Selesai')->count();
        $jumlah_konsultasiSedangKonsultasi = Konsultasi::where('status', 'Sedang Konsultasi')->count();
        $jumlah_konsultasiBelum = Konsultasi::where('status', 'Belum')->count();

        $query = Konsultasi::with(['dokter', 'pasien', 'dokter.layanan']); 

        if ($request->filled('searchInput')) {
            $searchInput = $request->input('searchInput');
            $query->whereHas('dokter', function ($q) use ($searchInput) {
                $q->where('nama_lengkap', 'LIKE', '%' . $searchInput . '%');
            })->orWhereHas('pasien', function ($q) use ($searchInput) {
                $q->where('nama_lengkap', 'LIKE', '%' . $searchInput . '%');
            });
        }

        if ($request->filled('filter')) {
            $filter = $request->input('filter');
            $query->where('status', $filter);
        } else {
            $query->orderByRaw("FIELD(status, 'Sedang Konsultasi', 'Belum', 'Sudah Selesai')")
                  ->orderBy('tanggal_konsultasi', 'DESC');
        }

        $konsultasiData = $query->get(); 

        return view('admin.konsultasi', compact(
            'jumlah_konsultasiSelesai',
            'jumlah_konsultasiSedangKonsultasi',
            'jumlah_konsultasiBelum',
            'konsultasiData',
            'userRole'
        ));
    }
}