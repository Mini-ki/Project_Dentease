<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; // Pastikan model Admin diimpor
use App\Models\User;  // Pastikan model User diimpor

class AdminController extends Controller
{
    // Method untuk menampilkan semua admin (termasuk form tambah/edit jika diakses melalui link)
    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->sub_role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah.');
        }

        $admins = Admin::get();
        $op = 'index';

        $adminToEdit = new Admin();
        $userToEdit = new User();

        return view('admin.admin', compact('admins', 'op', 'adminToEdit', 'userToEdit'));
    }


    // public function create()
    // {
    //     $user = Auth::user();
    //     if (!$user || $user->sub_role !== 'super_admin') {
    //         return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah.');
    //     }

    //     $admins = Admin::get();
    //     $op = 'create';

    //     $adminToEdit = new Admin();
    //     $userToEdit = new User();

    //     return view('admin.admin', compact('admins', 'op', 'adminToEdit', 'userToEdit'));
    // }


    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->sub_role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Pastikan ada password_confirmation
            'nama_admin' => 'required|string|max:255',
            'noHP' => 'required|string|max:15',
            'role_admin' => 'required|in:admin,operator',
        ]);

        DB::beginTransaction();
        try {
            $newUser = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
            ]);

            Admin::create([
                'id_admin' => $newUser->id_user,
                'nama_admin' => $request->nama_admin,
                'noHP' => $request->noHP,
                'role' => $request->role_admin,
            ]);

            DB::commit();
            return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan admin: ' . $e->getMessage());
        }
    }

    public function edit($id_admin)
    {
        $user = Auth::user();
        if (!$user || $user->sub_role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah.');
        }

        $adminToEdit = Admin::where('id_admin', $id_admin)->first();
        if (!$adminToEdit) {
            return redirect()->route('admin.admin.index')->with('error', 'Data admin tidak ditemukan.');
        }

        $userToEdit = User::find($id_admin);
        if (!$userToEdit) {
            return redirect()->route('admin.admin.index')->with('error', 'Data user tidak ditemukan untuk admin ini.');
        }

        $admins = Admin::get();
        $op = 'edit'; // Menunjukkan bahwa ini adalah tampilan form edit

        return view('admin.admin', compact('admins', 'op', 'adminToEdit', 'userToEdit'));
    }

    public function update(Request $request, $id_admin)
    {
        $user = Auth::user();
        if (!$user || $user->sub_role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah.');
        }

        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'noHP' => 'required|string|max:15',
            'role_admin' => 'required|in:admin,operator',
            'password' => 'nullable|string|min:8|confirmed', // Konfirmasi password hanya jika diisi
        ]);

        DB::beginTransaction();
        try {
            $admin = Admin::where('id_admin', $id_admin)->first();
            if ($admin) {
                $admin->update([
                    'nama_admin' => $request->nama_admin,
                    'noHP' => $request->noHP,
                    'role' => $request->role_admin,
                ]);
            } else {
                throw new \Exception("Admin data not found.");
            }

            $user = User::find($id_admin);
            if ($user) {
                $userDataToUpdate = ['role' => 'admin']; // Tetap set role user ke 'admin'
                if ($request->filled('password')) { // Hanya update password jika diisi
                    $userDataToUpdate['password'] = Hash::make($request->password);
                }
                $user->update($userDataToUpdate);
            } else {
                throw new \Exception("User data not found for admin.");
            }

            DB::commit();
            return redirect()->route('admin.admin.index')->with('success', 'Data admin berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui admin: ' . $e->getMessage());
        }
    }

    public function destroy($id_admin)
    {
        $user = Auth::user();
        if (!$user || $user->sub_role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah.');
        }

        DB::beginTransaction();
        try {
            $admin = Admin::where('id_admin', $id_admin)->first();
            if ($admin) {
                $admin->delete();
            }

            $user = User::find($id_admin);
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus admin: ' . $e->getMessage());
        }
    }
}
