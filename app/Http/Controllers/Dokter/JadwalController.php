<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;   

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal dokter.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        $id_dokter = Auth::id(); 
        $dokter = DB::table('dokter')->where('id_dokter', $id_dokter)->first();
        $jadwals = DB::table('jadwal_dokter')
                      ->where('id_dokter', $id_dokter)
                      ->get(); 

        return view('dokter.jadwal', compact('jadwals', 'dokter'));
    }

    /**
     * Menyimpan jadwal baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $id_dokter = Auth::id();

        DB::table('jadwal_dokter')->insert([
            'id_dokter' => $id_dokter,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('dokter.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Memperbarui jadwal yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_dokter,id_jadwal',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $id_dokter = Auth::id();

        DB::table('jadwal_dokter')
            ->where('id_jadwal', $request->id_jadwal)
            ->where('id_dokter', $id_dokter) 
            ->update([
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'updated_at' => now(),
            ]);

        return redirect()->route('dokter.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Menghapus jadwal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_dokter,id_jadwal',
        ]);

        $id_dokter = Auth::id();

        DB::table('jadwal_dokter')
            ->where('id_jadwal', $request->id_jadwal)
            ->where('id_dokter', $id_dokter) 
            ->delete();

        return redirect()->route('dokter.jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}