<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LayananDokter;
use App\Models\Dokter;
use App\Models\JadwalDokter;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.layanan', [
            'userRole' => Auth::user()->role,
            'layananStatistik' => $this->getLayananStatistik(),
            'layananData' => LayananDokter::orderBy('id_layanan')->get(),
            'jadwalDokterData' => $this->getFilteredJadwalDokter($request),
            'op' => 'create',
            'layanantoEdit' => null,
            'error' => session('error', ''),
            'sukses' => session('sukses', ''),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'biaya_layanan' => 'required|numeric',
        ]);

        try {
            LayananDokter::create([
                'nama_layanan' => $request->nama_layanan,
                'biaya_layanan' => $request->biaya_layanan,
                'status' => 'Aktif',
            ]);

            return redirect()->route('admin.layanan.index')->with('sukses', 'Berhasil menambahkan layanan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $layanantoEdit = LayananDokter::find($id);
        if (!$layanantoEdit) {
            return redirect()->route('admin.layanan.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.layanan', [
            'userRole' => Auth::user()->role,
            'layananStatistik' => $this->getLayananStatistik(),
            'layananData' => LayananDokter::orderBy('id_layanan')->get(),
            'jadwalDokterData' => $this->getFilteredJadwalDokter(new Request()),
            'layanantoEdit' => $layanantoEdit,
            'op' => 'edit',
            'error' => '',
            'sukses' => '',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'biaya_layanan' => 'required|numeric',
        ]);

        try {
            $layanan = LayananDokter::findOrFail($id);
            $layanan->update([
                'nama_layanan' => $request->nama_layanan,
                'biaya_layanan' => $request->biaya_layanan,
            ]);

            return redirect()->route('admin.layanan.index')->with('sukses', 'Berhasil mengupdate layanan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Dokter::where('id_layanan', $id)->update(['id_layanan' => null]);
            LayananDokter::destroy($id);

            return redirect()->route('admin.layanan.index')->with('sukses', 'Berhasil menghapus layanan.');
        } catch (\Exception $e) {
            return redirect()->route('admin.layanan.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $layanan = LayananDokter::findOrFail($id);
            $layanan->status = $layanan->status === 'Aktif' ? 'Nonaktif' : 'Aktif';
            $layanan->save();

            return redirect()->route('admin.layanan.index')->with('sukses', 'Status layanan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('admin.layanan.index')->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    protected function getLayananStatistik()
    {
        return LayananDokter::withCount(['dokters' => function ($query) {
            $query->whereHas('layananDokter', fn($q) => $q->where('status', 'Aktif'));
        }])->orderBy('id_layanan')->get();
    }

    protected function getFilteredJadwalDokter(Request $request)
    {
        $query = JadwalDokter::with(['dokter.layananDokter'])
            ->whereHas('dokter.layananDokter', fn($q) => $q->where('status', 'Aktif'));

        if ($request->filled('searchInput')) {
            $search = $request->input('searchInput');
            $query->whereHas('dokter', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('filter')) {
            $query->where('hari', $request->input('filter'));
        }

        return $query->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")->get();
    }
}
