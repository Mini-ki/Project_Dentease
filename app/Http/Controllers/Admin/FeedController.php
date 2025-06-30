<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // Untuk File::delete jika perlu
use Illuminate\Support\Facades\Storage; // Penting: Impor Storage Facade

class FeedController extends Controller
{
    private $uploadPath = 'img/uploads/feed';

    public function __construct()
    {
        if (!Storage::disk('public')->exists($this->uploadPath)) {
            Storage::disk('public')->makeDirectory($this->uploadPath);
        }
    }

    public function index()
    {
        $user = Auth::user();
        $role = $user->sub_role;
        $feeds = Feed::with('admin')->orderBy('created_at', 'desc')->get();
        return view('admin.feed', compact('feeds', 'role'));
    }

    // public function create()
    // {
    //     $user = Auth::user();
    //     $role = $user->sub_role;
    //     return view('admin.feed.create', compact('role'));
    // }

    public function store(Request $request)
    {
        $request->validate([
            'judul_feed' => 'required',
            'deskripsi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nama input 'image'
        ]);

        $user = Auth::user();
        $adminId = null;

        if ($user && $user->adminDetail) {
            $adminId = $user->adminDetail->id_admin;
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store($this->uploadPath, 'public');
        }

        Feed::create([
            'judul_feed' => $request->judul_feed,
            'deskripsi' => $request->deskripsi,
            'image' => $imagePath,
            'id_admin' => $adminId,
        ]);

        return redirect()->route('admin.feed.index')->with('success', 'Berhasil memasukkan data baru');
    }

    public function edit($id_feed)
    {

        $user = Auth::user();
        $role = $user->sub_role;
        $op = 'edit';

        $feedtoEdit = Feed::where('id_feed', $id_feed)->first();
        if (!$feedtoEdit) {
            return redirect()->route('admin.feed')->with('error', 'Data admin tidak ditemukan.');
        }

        $feeds = Feed::with('admin')->orderBy('created_at', 'desc')->get();
        return view('admin.feed', compact('feedtoEdit', 'feeds', 'role', 'op'));
    }

    public function update(Request $request, $id_feed)
    {
        $feed = Feed::where('id_feed', $id_feed)->first();
        $request->validate([
            'judul_feed' => 'required',
            'deskripsi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nama input 'image'
        ]);

        $user = Auth::user();
        $adminId = null;

        if ($user && $user->adminDetail) {
            $adminId = $user->adminDetail->id_admin;
        }

        $imagePath = $feed->image; // Ambil path gambar lama

        if ($request->hasFile('image')) {
            if ($feed->image && Storage::disk('public')->exists($feed->image)) {
                Storage::disk('public')->delete($feed->image);
            }
            $imagePath = $request->file('image')->store($this->uploadPath, 'public');
        }

        $feed->update([
            'judul_feed' => $request->judul_feed,
            'deskripsi' => $request->deskripsi,
            'image' => $imagePath, // Simpan path baru atau path lama
            'id_admin' => $adminId,
            // 'updated_at' akan otomatis diisi oleh Eloquent jika ada di model
        ]);

        return redirect()->route('admin.feed.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Feed $feed)
    {
        // Hapus gambar dari storage fisik
        if ($feed->image && Storage::disk('public')->exists($feed->image)) {
            Storage::disk('public')->delete($feed->image);
        }

        $feed->delete();
        return redirect()->route('admin.feed')->with('success', 'Berhasil hapus data');
    }
}
