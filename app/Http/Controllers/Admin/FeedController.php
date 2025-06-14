<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class FeedController extends Controller
{
    private $uploadDir = 'public/img/uploads/feed/'; 

    public function __construct()
    {
        if (!File::isDirectory(storage_path('app/' . $this->uploadDir))) {
            File::makeDirectory(storage_path('app/' . $this->uploadDir), 0755, true, true);
        }
    }

    /**
     * Menampilkan list resource (khusus feed routenya resourse)
     */
    public function index()
    {
        $role = Auth::guard('admin')->user()->role;
        $feeds = Feed::with('admin')->orderBy('created_at', 'desc')->get();
        return view('admin.feed.index', compact('feeds', 'role'));
    }

    /**
     * Menampilkan form
     */
    public function create()
    {
        $role = Auth::guard('admin')->user()->role; 
        return view('admin.feed.create', compact('role'));
    }

    /**
     * Menyimpan resource baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_feed' => 'required',
            'deskripsi' => 'required',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $adminId = Auth::guard('admin')->id();
        $newFeedName = null;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $latestFeed = Feed::where('id_admin', $adminId)
                               ->where('image', 'like', $adminId . '_' . $fileNameWithoutExt . '_%')
                               ->orderByDesc('created_at') 
                               ->first();

            $nomorTerakhir = 0;
            if ($latestFeed && $latestFeed->image) {
                $feedFileName = pathinfo($latestFeed->image, PATHINFO_FILENAME);
                $pos = strrpos($feedFileName, '_');
                if ($pos !== false) {
                    $angkaStr = substr($feedFileName, $pos + 1);
                    if (is_numeric($angkaStr)) {
                        $nomorTerakhir = (int)$angkaStr;
                    }
                }
            }
            $nomorBaru = $nomorTerakhir + 1;
            $newFeedName = $adminId . '_' . $fileNameWithoutExt . '_' . $nomorBaru . '.' . $extension;

            $file->storeAs($this->uploadDir, $newFeedName);
        }

        Feed::create([
            'judul_feed' => $request->judul_feed,
            'deskripsi' => $request->deskripsi,
            'image' => $newFeedName,
            'id_admin' => $adminId,
        ]);

        return redirect()->route('admin.feed.index')->with('success', 'Berhasil memasukkan data baru');
    }

    /**
     * Menampilkan formr edit
     */
    public function edit(Feed $feed)
    {
        $role = Auth::guard('admin')->user()->role; 
        return view('admin.feed.edit', compact('feed', 'role'));
    }

    /**
     * Memperbarui resource yang ada
     */
    public function update(Request $request, Feed $feed)
    {
        $request->validate([
            'judul_feed' => 'required',
            'deskripsi' => 'required',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $adminId = Auth::guard('admin')->id();
        $newFeedName = $feed->image; 

        if ($request->hasFile('image_file')) {
            if ($feed->image && File::exists(storage_path('app/' . $this->uploadDir . $feed->image))) {
                File::delete(storage_path('app/' . $this->uploadDir . $feed->image));
            }

            $file = $request->file('image_file');
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $latestFeed = Feed::where('id_admin', $adminId)
                               ->where('image', 'like', $adminId . '_' . $fileNameWithoutExt . '_%')
                               ->orderByDesc('created_at')
                               ->first();

            $nomorTerakhir = 0;
            if ($latestFeed && $latestFeed->image) {
                $feedFileName = pathinfo($latestFeed->image, PATHINFO_FILENAME);
                $pos = strrpos($feedFileName, '_');
                if ($pos !== false) {
                    $angkaStr = substr($feedFileName, $pos + 1);
                    if (is_numeric($angkaStr)) {
                        $nomorTerakhir = (int)$angkaStr;
                    }
                }
            }
            $nomorBaru = $nomorTerakhir + 1;
            $newFeedName = $adminId . '_' . $fileNameWithoutExt . '_' . $nomorBaru . '.' . $extension;

            $file->storeAs($this->uploadDir, $newFeedName);
        }

        $feed->update([
            'judul_feed' => $request->judul_feed,
            'deskripsi' => $request->deskripsi,
            'image' => $newFeedName,
            'id_admin' => $adminId, 
        ]);

        return redirect()->route('admin.feed.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Menghapus resource yang ada
     * @param  Feed  $feed
     */
    public function destroy(Feed $feed)
    {
        if ($feed->image && File::exists(storage_path('app/' . $this->uploadDir . $feed->image))) {
            File::delete(storage_path('app/' . $this->uploadDir . $feed->image));
        }
        $feed->delete();
        return redirect()->route('admin.feed.index')->with('success', 'Berhasil hapus data');
    }
}