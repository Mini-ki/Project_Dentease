<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User; 

class AdminController extends Controller
{
    /**
     * Menampilkan daftar admin (kecuali super_admin).
     * Hanya bisa diakses oleh super_admin.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah. Hanya Super Admin yang dapat melihat data admin.');
        }

        $admins = Admin::where('role', '!=', 'super_admin')->get();

        return view('admin.admin', compact('admins'));
    }

    /**
     * Menampilkan formulir untuk menambah admin baru.
     * Hanya bisa diakses oleh super_admin.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah. Hanya Super Admin yang dapat menambah admin.');
        }

        return view('admin.admin_form', ['op' => 'create']);
    }

    /**
     * Menyimpan data admin baru ke database.
     * Hanya bisa diakses oleh super_admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah. Hanya Super Admin yang dapat menambah admin.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'nama_admin' => 'required|string|max:255',
            'noHp' => 'required|string|max:15',
            'role_admin' => 'required|in:admin,operator', 
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role_admin, 
            ]);

            Admin::create([
                'id_admin' => $user->id, 
                'nama_admin' => $request->nama_admin,
                'noHp' => $request->noHp,
                'role' => $request->role_admin, 
            ]);

            DB::commit();
            return redirect()->route('admin.admin_index')->with('success', 'Admin berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan admin: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan formulir untuk mengedit data admin.
     * Hanya bisa diakses oleh super_admin.
     *
     * @param  int  $id_admin
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id_admin)
    {
        if (!Auth::check() || Auth::user()->role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah. Hanya Super Admin yang dapat mengedit admin.');
        }

        $admin = Admin::where('id_admin', $id_admin)->first();

        if (!$admin) {
            return redirect()->route('admin.admin_index')->with('error', 'Data admin tidak ditemukan.');
        }

        $user = User::find($id_admin); 

        return view('admin.admin_form', compact('admin', 'user', 'id_admin', 'op'))->with('op', 'edit');
    }

    /**
     * Memperbarui data admin di database.
     * Hanya bisa diakses oleh super_admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id_admin)
    {
        if (!Auth::check() || Auth::user()->role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah. Hanya Super Admin yang dapat mengedit admin.');
        }

        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'noHp' => 'required|string|max:15',
            'role_admin' => 'required|in:admin,operator',
        ]);

        DB::beginTransaction();
        try {
            $admin = Admin::where('id_admin', $id_admin)->first();
            if ($admin) {
                $admin->update([
                    'nama_admin' => $request->nama_admin,
                    'noHp' => $request->noHp,
                    'role' => $request->role_admin,
                ]);
            } else {
                throw new \Exception("Admin data not found.");
            }

            $user = User::find($id_admin);
            if ($user) {
                $user->update([
                    'role' => $request->role_admin,
                ]);
            } else {
                 throw new \Exception("User data not found for admin.");
            }

            DB::commit();
            return redirect()->route('admin.admin_index')->with('success', 'Data admin berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui admin: ' . $e->getMessage());
        }
    }

    /**
     * Di siin pake hapus data admin dari database.
     * Cuma bisa diakses oleh super_admin, makanya ada role jele itu.
     *
     * @param  int  $id_admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id_admin)
    {
        if (!Auth::check() || Auth::user()->role !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses tidak sah. Hanya Super Admin yang dapat menghapus admin.');
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
            return redirect()->route('admin.admin_index')->with('success', 'Admin berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus admin: ' . $e->getMessage());
        }
    }
}