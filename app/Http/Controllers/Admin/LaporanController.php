<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananDokter;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;

        $tahun = $request->input('tahun', date('Y'));

        $layananList = LayananDokter::select('nama_layanan')
            ->orderBy('id_layanan')
            ->pluck('nama_layanan')
            ->toArray();

        $bulanList = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulanList[] = sprintf("%s-%02d", $tahun, $m);
        }

        $rawDataQuery = Konsultasi::select(
                DB::raw("DATE_FORMAT(konsultasi.tanggal_konsultasi, '%Y-%m') AS bulan"),
                'layanan_dokter.nama_layanan AS layanan',
                DB::raw('COUNT(*) AS total')
            )
            ->join('dokter', 'dokter.id_dokter', '=', 'konsultasi.id_dokter')
            ->join('layanan_dokter', 'layanan_dokter.id_layanan', '=', 'dokter.id_layanan')
            ->whereYear('konsultasi.tanggal_konsultasi', $tahun)
            ->where('layanan_dokter.status', 'Aktif')
            ->groupBy('bulan', 'layanan')
            ->orderBy('bulan')
            ->orderBy('layanan')
            ->get();

        $data = [];
        foreach ($rawDataQuery as $row) {
            $data[$row->bulan][$row->layanan] = (int)$row->total;
        }

        foreach ($layananList as $l) {
            foreach ($bulanList as $bln) {
                $data[$bln][$l] = $data[$bln][$l] ?? 0;
            }
        }

        $availableYears = Konsultasi::select(DB::raw('YEAR(tanggal_konsultasi) AS year'))
            ->distinct()
            ->orderBy('year')
            ->pluck('year')
            ->toArray();

        return view('admin.laporan', compact('role', 'tahun', 'layananList', 'bulanList', 'data', 'availableYears'));
    }

    public function printReport(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $layananList = LayananDokter::select('nama_layanan')
            ->orderBy('id_layanan')
            ->pluck('nama_layanan')
            ->toArray();

        $tableData = DB::table('layanan_dokter AS l')
            ->select(
                'l.nama_layanan AS layanan',
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 1 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Jan"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 2 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Feb"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 3 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Mar"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 4 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Apr"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 5 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Mei"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 6 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Jun"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 7 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Jul"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 8 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Agu"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 9 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Sep"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 10 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Okt"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 11 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Nov"),
                DB::raw("SUM(MONTH(k.tanggal_konsultasi) = 12 AND YEAR(k.tanggal_konsultasi) = {$tahun}) AS Des")
            )
            ->leftJoin('dokter AS d', 'l.id_layanan', '=', 'd.id_layanan')
            ->leftJoin('konsultasi AS k', 'k.id_dokter', '=', 'd.id_dokter')
            ->groupBy('l.nama_layanan')
            ->get();


        $bulanList = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulanList[] = sprintf("%s-%02d", $tahun, $m);
        }

        $chartRawDataQuery = Konsultasi::select(
                DB::raw("DATE_FORMAT(konsultasi.tanggal_konsultasi, '%Y-%m') AS bulan"),
                'layanan_dokter.nama_layanan AS layanan',
                DB::raw('COUNT(*) AS total')
            )
            ->join('dokter', 'dokter.id_dokter', '=', 'konsultasi.id_dokter')
            ->join('layanan_dokter', 'layanan_dokter.id_layanan', '=', 'dokter.id_layanan')
            ->whereYear('konsultasi.tanggal_konsultasi', $tahun)
            ->where('layanan_dokter.status', 'Aktif')
            ->groupBy('bulan', 'layanan')
            ->orderBy('bulan')
            ->orderBy('layanan')
            ->get();

        $chartData = [];
        foreach ($chartRawDataQuery as $row) {
            $chartData[$row->bulan][$row->layanan] = (int)$row->total;
        }

        foreach ($layananList as $l) {
            foreach ($bulanList as $bln) {
                $chartData[$bln][$l] = $chartData[$bln][$l] ?? 0;
            }
        }

        return view('admin.cetakLaporan', compact('tahun', 'layananList', 'bulanList', 'tableData', 'chartData'));
    }
}
