<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB;   // Untuk transaksi manual jika diperlukan, atau Eloquent transactions
use App\Models\User;   
use App\Models\Pasien; 
use App\Models\Konsultasi; 

class PasienController extends Controller
{
    /**
     * Menampilkan daftar pasien dan menangani operasi CRUD.
     */
    public function index(Request $request)
    {
        $userRole = Auth::user()->role;

        $pasien = null; 
        $id_pasien = null;
        $error = "";
        $sukses = "";

        $id_pasien = $request->input('id_pasien');

        if ($request->has('op')) {
            $op = $request->input('op');

            switch ($op) {
                case 'delete':
                    try {
                        DB::beginTransaction();  

                        $pasienToDelete = Pasien::find($id_pasien);

                        if ($pasienToDelete) {
                            Konsultasi::where('id_pasien', $id_pasien)->delete();

                            $pasienToDelete->delete();

                            User::destroy($id_pasien); 

                            DB::commit();
                            $sukses = "Berhasil hapus data pasien dan user terkait.";
                        } else {
                            $error = "Data pasien tidak ditemukan.";
                        }
                    } catch (\Exception $e) {
                        DB::rollBack(); 
                        $error = "Gagal melakukan delete data: " . $e->getMessage();
                    }
                    return redirect()->route('admin.pasien')->with(['sukses' => $sukses, 'error' => $error]);

                case 'edit':
                    $pasien = Pasien::with('user')->find($id_pasien);
                    if (!$pasien) {
                        $error = "Data tidak ditemukan.";
                        return redirect()->route('admin.pasien')->with('error', $error);
                    }
                    break;
            }
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'nama_panggilan' => 'required|string|max:255',
                'nama_lengkap' => 'required|string|max:255',
                'umur' => 'required|integer|min:0',
                'alamat' => 'required|string',
                'noHp' => 'required|string|max:20',
                'username' => ($request->has('id_pasien_edit')) ? 'nullable' : 'required|string|max:255|unique:users,username',
                'email' => ($request->has('id_pasien_edit')) ? 'nullable' : 'required|string|email|max:255|unique:users,email',
                'password' => ($request->has('id_pasien_edit')) ? 'nullable' : 'required|string|min:8|confirmed',
            ]);

            $id_pasien_to_edit = $request->input('id_pasien_edit');

            try {
                DB::beginTransaction(); 

                if ($id_pasien_to_edit) { 
                    $pasien = Pasien::find($id_pasien_to_edit);
                    if ($pasien) {
                        $pasien->update($request->only(['nama_panggilan', 'nama_lengkap', 'umur', 'alamat', 'noHp']));
                        $sukses = "Data pasien berhasil diupdate.";
                    } else {
                        $error = "Data pasien gagal diupdate.";
                    }
                } else { 
                    $user = User::create([
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'role' => 'pasien', 
                    ]);

                    Pasien::create([
                        'id_pasien' => $user->id, // Menggunakan ID user sebagai id_pasien
                        'nama_panggilan' => $request->nama_panggilan,
                        'nama_lengkap' => $request->nama_lengkap,
                        'umur' => $request->umur,
                        'alamat' => $request->alamat,
                        'noHp' => $request->noHp,
                        'foto_profil' => null, 
                    ]);
                    $sukses = "Berhasil memasukkan data pasien baru.";
                }
                DB::commit();  
            } catch (\Exception $e) {
                DB::rollBack();  
                $error = "Gagal memproses data: " . $e->getMessage();
            }

            return redirect()->route('admin.pasien')->with(['sukses' => $sukses, 'error' => $error]);
        }
 
        $pasienQuery = Pasien::with(['user', 'latestKonsultasi']); 
        
        if ($request->filled('searchInput')) {
            $searchInput = $request->input('searchInput');
            $pasienQuery->where('nama_panggilan', 'LIKE', '%' . $searchInput . '%')
                        ->orWhere('nama_lengkap', 'LIKE', '%' . $searchInput . '%');
        }

         
        if ($request->filled('filter')) {
            $filter = $request->input('filter');
            if ($filter === 'Ada') {
                $pasienQuery->whereHas('latestKonsultasi', function ($q) {
                    $q->whereIn('status', ['Sedang Konsultasi', 'Belum']);
                });
            } else {  
                $pasienQuery->whereDoesntHave('latestKonsultasi')  
                            ->orWhereHas('latestKonsultasi', function ($q) {
                                $q->where('status', 'Sudah Selesai'); 
                            });
            }
        }

        $pasienData = $pasienQuery->orderBy('id_pasien', 'desc')->get(); 
        
        $sukses = session('sukses', $sukses);
        $error = session('error', $error);

        return view('admin.pasien.index', compact('userRole', 'pasien', 'error', 'sukses', 'pasienData'));
    }
}