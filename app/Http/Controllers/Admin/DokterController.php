<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\LayananDokter; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Pkae eloquent tapi tetep perlu ini buat transaksi database
use App\Models\Konsultasi; 

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        $dokters = Dokter::query();
        $layanans = LayananDokter::orderBy('id_layanan')->get(); 

        if ($request->has('searchInput') && !empty($request->searchInput)) {
            $searchInput = $request->searchInput;
            $dokters->where('nama_panggilan', 'LIKE', '%' . $searchInput . '%')
                    ->orWhere('nama_lengkap', 'LIKE', '%' . $searchInput . '%');
        }

        if ($request->has('filter') && !empty($request->filter)) {
            $filter = $request->filter;
            $dokters->where('spesialis', $filter);
        }

        $dokters = $dokters->orderBy('id_dokter')->get(); 

        
        $distinctSpesialis = Dokter::distinct()->pluck('spesialis');

        return view('admin.dokter', compact('dokters', 'role', 'layanans', 'distinctSpesialis'));
    }

    public function create()
    {
        $user = Auth::user();
        $userRole = $user->role; 
        if (!$user || !in_array($userRole, ['super_admin', 'admin'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $layanans = LayananDokter::all();
        return view('admin.dokter_form', compact('userRole', 'layanans'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $userRole = $user->role; 
        if (!$user || !in_array($userRole, ['super_admin', 'admin'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'nama_panggilan' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'required|integer',
            'spesialis' => 'required|string|max:255',
            'layanan' => 'required|string|exists:layanan_dokter,nama_layanan', // Validasi nama_layanan
            'alamat' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $layanan = LayananDokter::where('nama_layanan', $request->layanan)->firstOrFail();
            $id_layanan = $layanan->id_layanan;

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter', 
            ]);

            Dokter::create([
                'id_dokter' => $user->id, 
                'nama_panggilan' => $request->nama_panggilan,
                'nama_lengkap' => $request->nama_lengkap,
                'umur' => $request->umur,
                'spesialis' => $request->spesialis,
                'id_layanan' => $id_layanan,
                'alamat' => $request->alamat,
                'rating' => 0 // Rating awal
            ]);

            DB::commit();
            return redirect()->route('admin.dokter')->with('sukses', 'Berhasil memasukkan data baru');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memasukkan data: ' . $e->getMessage());
        }
    }

    public function edit($id_dokter)
    {
        $user = Auth::user();
        $userRole = $user->role; 
        if (!$user || !in_array($userRole, ['super_admin', 'admin'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $dokter = Dokter::where('id_dokter', $id_dokter)->first();

        if (!$dokter) {
            return redirect()->route('admin.dokter')->with('error', 'Data dokter tidak ditemukan.');
        }

        $layanans = LayananDokter::all();

        return view('admin.dokter_form', compact('dokter', 'userRole', 'layanans'));
    }

    public function update(Request $request, $id_dokter)
    {
        $user = Auth::user();
        $userRole = $user->role; 
        if (!$user || !in_array($userRole, ['super_admin', 'admin'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $request->validate([
            'nama_panggilan' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'required|integer',
            'spesialis' => 'required|string|max:255',
            'layanan' => 'required|string|exists:layanan_dokter,nama_layanan',
            'alamat' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $dokter = Dokter::where('id_dokter', $id_dokter)->firstOrFail();
            $layanan = LayananDokter::where('nama_layanan', $request->layanan)->firstOrFail();
            $id_layanan = $layanan->id_layanan;

            $dokter->update([
                'nama_panggilan' => $request->nama_panggilan,
                'nama_lengkap' => $request->nama_lengkap,
                'umur' => $request->umur,
                'spesialis' => $request->spesialis,
                'id_layanan' => $id_layanan,
                'alamat' => $request->alamat,
            ]);

            DB::commit();
            return redirect()->route('admin.dokter')->with('sukses', 'Data berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    public function destroy($id_dokter)
    {
        $user = Auth::user();
        $userRole = $user->role; 
        if (!$user || !in_array($userRole, ['super_admin', 'admin'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        try {
            DB::beginTransaction();

            // Hapus data konsultasi yang terkait
            Konsultasi::where('id_dokter', $id_dokter)->delete();

            // Hapus data dokter
            Dokter::where('id_dokter', $id_dokter)->delete();

            // Hapus user yang terkait
            User::where('id_user', $id_dokter)->delete(); 
            
            DB::commit();
            return redirect()->route('admin.dokter')->with('sukses', 'Berhasil hapus data');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.dokter')->with('error', 'Gagal melakukan delete data: ' . $e->getMessage());
        }
    }
}