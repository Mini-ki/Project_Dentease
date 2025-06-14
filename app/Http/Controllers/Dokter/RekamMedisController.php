<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar pasien yang terhubung dengan dokter yang sedang login.
     * Mirip dengan konten utama dari pasien.php.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }

        $id_dokter = Auth::id(); // Mengambil ID dokter dari user yang sedang login

        $pasien = DB::table('konsultasi as k')
                    ->join('pasien as p', 'k.id_pasien', '=', 'p.id_pasien')
                    // Asumsi id_dokter di tabel konsultasi mereferensikan id di tabel users
                    ->where('k.id_dokter', $id_dokter)
                    ->distinct()
                    ->select('p.id_pasien', 'p.nama_panggilan', 'p.nama_lengkap', 'p.umur', 'p.alamat', 'p.noHp')
                    ->orderBy('p.id_pasien', 'asc')
                    ->get();

        return view('dokter.pasien.index', compact('pasien'));
    }

    /**
     * Memperbarui data pasien.
     * Dari logika update di pasien.php.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }

        // Validasi input
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
            'nama_panggilan' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'alamat' => 'required|string|max:255',
            'noHp' => 'required|string|max:20',
        ]);

        $id_pasien = $request->id_pasien;
        $id_dokter = Auth::id(); // ID dokter yang sedang login

        // Pastikan pasien ini terhubung dengan dokter yang sedang login
        $is_associated = DB::table('konsultasi')
                            ->where('id_pasien', $id_pasien)
                            ->where('id_dokter', $id_dokter)
                            ->exists();

        if (!$is_associated) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengedit pasien ini.');
        }

        $updated = DB::table('pasien')
                    ->where('id_pasien', $id_pasien)
                    ->update([
                        'nama_panggilan' => $request->nama_panggilan,
                        'nama_lengkap' => $request->nama_lengkap,
                        'umur' => $request->umur,
                        'alamat' => $request->alamat,
                        'noHp' => $request->noHp,
                        'updated_at' => now(), // Kolom updated_at
                    ]);

        if ($updated) {
            return redirect()->route('dokter.rekam_medis')->with('success', 'Data pasien berhasil diperbarui!');
        } else {
            return redirect()->route('dokter.rekam_medis')->with('error', 'Gagal memperbarui data pasien atau tidak ada perubahan.');
        }
    }

    /**
     * Menghapus data pasien.
     * Dari logika delete di pasien.php.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }

        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
        ]);

        $id_pasien = $request->id_pasien;
        $id_dokter = Auth::id(); // ID dokter yang sedang login

        // Pastikan pasien ini terhubung dengan dokter yang sedang login
        $is_associated = DB::table('konsultasi')
                            ->where('id_pasien', $id_pasien)
                            ->where('id_dokter', $id_dokter)
                            ->exists();

        if (!$is_associated) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus pasien ini.');
        }

        try {
            // Sebelum menghapus pasien, pertimbangkan FOREIGN KEY CONSTRAINTS.
            // Anda mungkin perlu menghapus terlebih dahulu data terkait di tabel
            // `konsultasi` dan `rekam_medis` yang terkait dengan pasien ini.
            // Atau atur ON DELETE CASCADE di database.
            // Untuk sementara, kita akan mencoba hapus langsung.
            $deleted = DB::table('pasien')->where('id_pasien', $id_pasien)->delete();

            if ($deleted) {
                return redirect()->route('dokter.rekam_medis')->with('success', 'Data pasien berhasil dihapus!');
            } else {
                return redirect()->route('dokter.rekam_medis')->with('error', 'Gagal menghapus data pasien.');
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada foreign key constraint
            return redirect()->route('dokter.rekam_medis')->with('error', 'Gagal menghapus pasien. Mungkin ada data konsultasi atau rekam medis terkait yang harus dihapus terlebih dahulu.');
        }
    }

    /**
     * Menampilkan detail rekam medis untuk pasien tertentu.
     * Dari konten rekammedis.php.
     *
     * @param  int  $id_pasien
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showRekamMedis($id_pasien)
    {
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }

        $id_dokter = Auth::id();

        $pasien_data = DB::table('pasien')->where('id_pasien', $id_pasien)->first();

        if (!$pasien_data) {
            return redirect()->route('dokter.rekam_medis')->with('error', 'Pasien tidak ditemukan.');
        }

        $rekam_medis_list = DB::table('rekam_medis as r')
                            ->join('konsultasi as k', 'r.id_konsultasi', '=', 'k.id_konsultasi')
                            ->join('dokter as d', 'k.id_dokter', '=', 'd.id_dokter') 
                            ->join('pasien as p', 'k.id_pasien', '=', 'p.id_pasien') 
                            ->where('k.id_dokter', $id_dokter)
                            ->where('k.id_pasien', $id_pasien)
                            ->select('r.*', 'd.nama_lengkap as nama_dokter', 'p.nama_lengkap as nama_pasien')
                            ->orderBy('r.tanggal', 'desc')
                            ->get();

        return view('dokter.pasien.rekammedis_detail', compact('pasien_data', 'rekam_medis_list'));
    }

    /**
     * Menambah atau memperbarui rekam medis.
     * Dari logika POST di rekammedis.php.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_pasien
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeOrUpdateRekamMedis(Request $request, $id_pasien)
    {
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }

        $id_dokter = Auth::id();

        $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'obat' => 'required|string',
            'id_rekam_medis' => 'nullable|exists:rekam_medis,id_rekam_medis',
        ]);

        $konsultasi = DB::table('konsultasi')
                        ->where('id_dokter', $id_dokter)
                        ->where('id_pasien', $id_pasien)
                        ->orderBy('tanggal_konsultasi', 'desc')
                        ->first();

        if (!$konsultasi) {
            return back()->with('error', 'Tidak ada riwayat konsultasi yang ditemukan untuk pasien ini. Tidak bisa menambahkan rekam medis.');
        }

        $id_konsultasi = $konsultasi->id_konsultasi;

        if ($request->filled('id_rekam_medis')) {
            $updated = DB::table('rekam_medis')
                        ->where('id_rekam_medis', $request->id_rekam_medis)
                        ->update([
                            'diagnosa' => $request->diagnosa,
                            'tindakan' => $request->tindakan,
                            'obat' => $request->obat,
                            'updated_at' => now(),
                        ]);
            $message = 'Rekam medis berhasil diperbarui!';
            $error_message = 'Gagal memperbarui rekam medis.';
        } else {
            $inserted = DB::table('rekam_medis')->insert([
                'id_konsultasi' => $id_konsultasi,
                'diagnose' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'obat' => $request->obat,
                'tanggal' => now(), 
            ]);
            $message = 'Rekam medis berhasil ditambahkan!';
            $error_message = 'Gagal menambahkan rekam medis.';
            $updated = $inserted; // Gunakan $inserted untuk konsistensi di if ($updated)
        }

        if ($updated) {
            return redirect()->route('rekam_medis.detail', $id_pasien)->with('success', $message);
        } else {
            return back()->with('error', $error_message);
        }
    }

    /**
     * Menghapus rekam medis.
     * Dari logika GET hapus di rekammedis.php.
     *
     * @param  int  $id_pasien
     * @param  int  $id_rekam_medis
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRekamMedis($id_pasien, $id_rekam_medis)
    {
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }

        $id_dokter = Auth::id();

        $can_delete = DB::table('rekam_medis as r')
                        ->join('konsultasi as k', 'r.id_konsultasi', '=', 'k.id_konsultasi')
                        ->where('r.id_rekam_medis', $id_rekam_medis)
                        ->where('k.id_pasien', $id_pasien)
                        ->where('k.id_dokter', $id_dokter)
                        ->exists();

        if (!$can_delete) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus rekam medis ini.');
        }

        $deleted = DB::table('rekam_medis')->where('id_rekam_medis', $id_rekam_medis)->delete();

        if ($deleted) {
            return redirect()->route('dokter.rekam_medis.detail', $id_pasien)->with('success', 'Rekam medis berhasil dihapus!');
        } else {
            return back()->with('error', 'Gagal menghapus rekam medis.');
        }
    }
}