<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;   

class UlasanController extends Controller
{
    /**
     * Display a listing of the doctor's reviews (ulasan).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        
        if (!Auth::check() || Auth::user()->role !== 'dokter') {
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }

        $id_dokter = Auth::id(); 
        
        $ulasan = DB::table('ulasan_dokter as ud')
                    ->join('konsultasi as k', 'ud.id_konsultasi', '=', 'k.id_konsultasi')
                    ->where('ud.id_dokter', $id_dokter)
                    ->select('ud.rating', 'ud.ulasan')
                    ->orderBy('ud.id_ulasan', 'DESC')
                    ->get();
                    
        return view('dokter.ulasan', compact('ulasan'));
    }
}