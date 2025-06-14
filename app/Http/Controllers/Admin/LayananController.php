<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LayananDokter; 
use App\Models\Dokter;         
use App\Models\JadwalDokter;   

class LayananController extends Controller
{
    
    /**
     * Menampilkan daftar layanan dan menangani operasi CRUD (add, edit, delete, status).
     * Juga menampilkan statistik layanan dan jadwal dokter.
     */
    public function index(Request $request)
    {
        
        $userRole = Auth::user()->role; 
        
        $nama_layanan = "";
        $biaya = "";
        $error = "";
        $sukses = "";

        $op = $request->input('op', 'add');
        $id_layanan = $request->input('id_layanan'); 

        if ($request->has('op')) {
            $op = $request->input('op');

            switch ($op) {
                case 'delete':
                    try {
                        Dokter::where('id_layanan', $id_layanan)->update(['id_layanan' => null]);

                        LayananDokter::destroy($id_layanan);
                        $sukses = "Berhasil hapus data.";
                    } catch (\Exception $e) {
                        $error = "Gagal melakukan delete data: " . $e->getMessage();
                    }
                    return redirect()->route('admin.layanan')->with(['sukses' => $sukses, 'error' => $error]);

                case 'edit':
                    $layanan = LayananDokter::find($id_layanan);
                    if ($layanan) {
                        $nama_layanan = $layanan->nama_layanan;
                        $biaya = $layanan->biaya_layanan;
                    } else {
                        $error = "Data tidak ditemukan.";
                        return redirect()->route('admin.layanan')->with('error', $error);
                    }
                    break;

                case 'status':
                    try {
                        $layanan = LayananDokter::find($id_layanan);
                        if ($layanan) {
                            $layanan->status = ($layanan->status == "Aktif") ? "Nonaktif" : "Aktif";
                            $layanan->save();
                            $sukses = "Status layanan berhasil diperbarui.";
                        } else {
                            $error = "Layanan tidak ditemukan.";
                        }
                    } catch (\Exception $e) {
                        $error = "Gagal memperbarui status: " . $e->getMessage();
                    }
                    return redirect()->route('admin.layanan')->with(['sukses' => $sukses, 'error' => $error]);
            }
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'nama_layanan' => 'required',
                'biaya_layanan' => 'required|numeric',
            ]);

            $nama_layanan = $request->input('nama_layanan');
            $biaya = $request->input('biaya_layanan');

            if ($request->has('id_layanan_edit')) { 
                $id_layanan = $request->input('id_layanan_edit');
                $layanan = LayananDokter::find($id_layanan);
                if ($layanan) {
                    $layanan->nama_layanan = $nama_layanan;
                    $layanan->biaya_layanan = $biaya;
                    $layanan->save();
                    $sukses = "Data berhasil diupdate.";
                } else {
                    $error = "Data gagal diupdate.";
                }
            } else { 
                LayananDokter::create([
                    'nama_layanan' => $nama_layanan,
                    'biaya_layanan' => $biaya,
                    'status' => 'Aktif', 
                ]);
                $sukses = "Berhasil memasukkan data baru.";
            }

            return redirect()->route('admin.layanan')->with(['sukses' => $sukses, 'error' => $error]);
        }

        $layananStatistik = LayananDokter::withCount(['dokters' => function($query) {
                                $query->whereHas('layanan', function($q) {
                                    $q->where('status', 'Aktif');
                                });
                            }])
                            ->orderBy('id_layanan')
                            ->get();

        $layananData = LayananDokter::orderBy('id_layanan')->get();

        $jadwalDokterQuery = JadwalDokter::with(['dokter.layanan'])
                                        ->whereHas('dokter.layanan', function ($query) {
                                            $query->where('status', 'Aktif');
                                        });

        if ($request->filled('searchInput')) {
            $searchInput = $request->input('searchInput');
            $jadwalDokterQuery->whereHas('dokter', function ($q) use ($searchInput) {
                $q->where('nama_lengkap', 'LIKE', '%' . $searchInput . '%');
            });
        }

        if ($request->filled('filter')) {
            $filterHari = $request->input('filter');
            $jadwalDokterQuery->where('hari', $filterHari);
        }

        $hariOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jadwalDokterQuery->orderByRaw("FIELD(hari, '" . implode("','", $hariOrder) . "')");

        $jadwalDokterData = $jadwalDokterQuery->get();

        $sukses = session('sukses', $sukses);
        $error = session('error', $error);

        return view('admin.layanan', compact(
            'userRole',
            'nama_layanan',
            'biaya',
            'error',
            'sukses',
            'layananStatistik',
            'layananData',
            'jadwalDokterData',
            'id_layanan',
            'op' 
        ));
    }
}