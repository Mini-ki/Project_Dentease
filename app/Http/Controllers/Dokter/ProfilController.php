<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;   

class ProfilController extends Controller
{
    /**
     * Display the doctor's profile.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $id_dokter = Auth::id(); 

        $dokter = DB::table('dokter')->where('id_dokter', $id_dokter)->first();

        if (!$dokter) {
            return redirect()->route('dokter.dashboard')->with('error', 'Dokter profile not found.');
        }

        if (empty($dokter->foto_profil)) {
            $dokter->foto_profil = 'default.jpg'; 

        return view('dokter.profil', compact('dokter'));
        }
    }

    /**
     * Update the doctor's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $id_dokter = Auth::id();

        $data_to_update = [
            'nama_lengkap' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'spesialis' => $request->spesialis,
            'alamat' => $request->alamat,
            'umur' => $request->umur, 
        ];

        if ($request->hasFile('foto_profil')) {
            $image = $request->file('foto_profil');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/image'), $imageName);
            $data_to_update['foto_profil'] = $imageName;

            $old_dokter = DB::table('dokter')->where('id_dokter', $id_dokter)->first();
            if ($old_dokter && $old_dokter->foto_profil && $old_dokter->foto_profil !== 'default.jpg' && file_exists(public_path('assets/image/' . $old_dokter->foto_profil))) {
                unlink(public_path('assets/image/' . $old_dokter->foto_profil));
            }
        }

        $updated = DB::table('dokter')->where('id_dokter', $id_dokter)->update($data_to_update);

        if ($updated) {
            return redirect()->route('dokter.profil')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->route('dokter.profil')->with('error', 'Gagal memperbarui profil atau tidak ada perubahan data.');
        }
    }
}