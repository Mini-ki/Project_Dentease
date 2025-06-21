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
    // Folder tempat menyimpan gambar di dalam disk 'public' (storage/app/public/)
    private $uploadPath = 'img/uploads/feed'; 

    public function __construct()
    {
        // Pastikan direktori ada di dalam storage/app/public
        // Storage::disk('public')->makeDirectory($this->uploadPath); // Ini lebih Laravel-way
        // Anda sudah punya logika File::makeDirectory, bisa dipertahankan jika Anda suka
        if (!Storage::disk('public')->exists($this->uploadPath)) {
            Storage::disk('public')->makeDirectory($this->uploadPath);
        }
    }

    public function index()
    {
        $user = Auth::user();
        $role = $user->sub_role; 
        $feeds = Feed::with('admin')->orderBy('created_at', 'desc')->get();
        return view('admin.feed.index', compact('feeds', 'role'));
    }

    public function create()
    {
        $user = Auth::user();
        $role = $user->sub_role; 
        return view('admin.feed.create', compact('role'));
    }

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
    
        $imagePath = null; // Default null jika tidak ada gambar
    
        if ($request->hasFile('image')) {
            // Menggunakan Storage Facade untuk menyimpan file
            // Ini akan menyimpan file ke storage/app/public/img/uploads/feed/
            // dan mengembalikan path relatif dari storage/app/public/
            $imagePath = $request->file('image')->store($this->uploadPath, 'public');
        }
    
        Feed::create([
            'judul_feed' => $request->judul_feed,
            'deskripsi' => $request->deskripsi,
            'image' => $imagePath, // Path akan tersimpan di database (contoh: img/uploads/feed/namafileunik.jpg)
            'id_admin' => $adminId, 
            // 'created_at' dan 'updated_at' akan otomatis diisi oleh Eloquent jika ada di model
            // 'created_at' => now(), // Tidak perlu jika timestamps true di model
            // 'update_at' => now(),  // Tidak perlu jika timestamps true di model
        ]);
    
        return redirect()->route('admin.feed.index')->with('success', 'Berhasil memasukkan data baru');
    }
    
    public function edit(Feed $feed)
    {
        $user = Auth::user();
        $role = $user->sub_role; 
        return view('admin.feed.edit', compact('feed', 'role'));
    }
    
    public function update(Request $request, Feed $feed)
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
        
        $imagePath = $feed->image; // Ambil path gambar lama
    
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada dan memang berbeda dari default placeholder
            if ($feed->image && Storage::disk('public')->exists($feed->image)) {
                Storage::disk('public')->delete($feed->image);
            }
            // Simpan gambar baru
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
        return redirect()->route('admin.feed.index')->with('success', 'Berhasil hapus data');
    }
}