<?php
namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PasienProfileController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $user = User::find($userId);

        $pasien = Pasien::where('id_pasien', $userId)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Data profil pasien Anda belum lengkap. Silakan hubungi admin atau lengkapi data Anda.');
        }

        return view('pasien.pasien_profile', compact('pasien', 'user'));
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $pasien = Pasien::where('id_pasien', $userId)->firstOrFail();

        $userPrimaryKeyColumn = 'id_user';
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'alamat' => 'required|string|max:255',
            'noHp' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId . ',' . $userPrimaryKeyColumn,
            'username' => 'nullable|string|max:255|unique:users,username,' . $userId . ',' . $userPrimaryKeyColumn,
            'password' => 'nullable|string|min:8|confirmed',
        ];

        $messages = [
            'email.unique' => 'Email ini sudah digunakan.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];

        $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            if ($user) {
                $user->email = $request->email;
                if ($request->filled('username')) {
                    $user->username = $request->username;
                }
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();
            }

            if ($request->hasFile('foto_profil')) {
                if ($pasien->foto_profil && $pasien->foto_profil !== 'default.jpg') {
                    Storage::disk('public')->delete('public/img/uploads/' . $pasien->foto_profil);
                }

                $imageName = time() . '.' . $request->foto_profil->extension();
                $imagePath = $request->foto_profil->storeAs('/img/uploads/fotoprofil_pasien', $imageName, 'public');
                $pasien->foto_profil = $imagePath;
            }

            $pasien->nama_lengkap = $request->nama_lengkap;
            $pasien->nama_panggilan = $request->nama_panggilan;
            $pasien->umur = $request->umur;
            $pasien->alamat = $request->alamat;
            $pasien->noHp = $request->noHp;
            $pasien->save();

            DB::commit();
            return redirect()->route('profile')->with('success', 'Profil berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal update profil: ' . $e->getMessage());
        }
    }
}
?>
