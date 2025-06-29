<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Konsultasi;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $pasienData = $this->getFilteredPasien($request);
        return view('admin.pasien', [
            'userRole' => Auth::user()->role,
            'pasienData' => $pasienData,
            'pasien' => null,
            'op' => 'create',
            'error' => session('error', ''),
            'sukses' => session('sukses', ''),
        ]);
    }

    // public function create()
    // {
    //     return redirect()->route('admin.pasien.index');
    // }

    public function store(Request $request)
    {
        $this->validatePasien($request);

        try {
            DB::beginTransaction();

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

            $user->pasien()->create([
                'id_pasien' => $user->id_user,
                'nama_panggilan' => $request->nama_panggilan,
                'nama_lengkap' => $request->nama_lengkap,
                'umur' => $request->umur,
                'alamat' => $request->alamat,
                'noHp' => $request->noHp,
                'foto_profil' => null,
            ]);

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('sukses', 'Berhasil memasukkan data pasien baru.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pasien = $this->getPasienById($id);
        if (!$pasien) {
            return redirect()->route('admin.pasien.index')->with('error', 'Data pasien tidak ditemukan.');
        }

        return view('admin.pasien', [
            'userRole' => Auth::user()->role,
            'pasienData' => $this->getFilteredPasien(new Request()),
            'pasien' => $pasien,
            'op' => 'edit',
            'error' => '',
            'sukses' => '',
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validatePasien($request, true);

        try {
            DB::beginTransaction();

            $pasien = Pasien::findOrFail($id);
            $pasien->update($request->only(['nama_panggilan', 'nama_lengkap', 'umur', 'alamat', 'noHp']));

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('sukses', 'Data pasien berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            Konsultasi::where('id_pasien', $id)->delete();
            Pasien::findOrFail($id)->delete();
            User::destroy($id);

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('sukses', 'Berhasil hapus data pasien dan user terkait.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pasien.index')->with('error', 'Gagal melakukan delete data: ' . $e->getMessage());
        }
    }

    protected function validatePasien(Request $request, $isUpdate = false)
    {
        $rules = [
            'nama_panggilan' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'alamat' => 'required|string',
            'noHp' => 'required|string|max:20',
        ];

        if (!$isUpdate) {
            $rules['username'] = 'required|string|max:255|unique:users,username';
            $rules['email'] = 'required|string|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);
    }

    protected function getPasienById($id)
    {
        return Pasien::with('user')->find($id);
    }

    protected function getFilteredPasien(Request $request)
    {
        $query = Pasien::with(['user', 'latestKonsultasi']);

        if ($request->filled('searchInput')) {
            $search = $request->searchInput;
            $query->where(function($q) use ($search) {
                $q->where('nama_panggilan', 'like', "%$search%")
                  ->orWhere('nama_lengkap', 'like', "%$search%");
            });
        }

        if ($request->filled('filter')) {
            if ($request->filter === 'Ada') {
                $query->whereHas('latestKonsultasi', fn($q) => $q->whereIn('status', ['Sedang Konsultasi', 'Belum']));
            } else {
                $query->whereDoesntHave('latestKonsultasi')
                      ->orWhereHas('latestKonsultasi', fn($q) => $q->where('status', 'Sudah Selesai'));
            }
        }

        return $query->orderBy('id_pasien')->get();
    }
}
