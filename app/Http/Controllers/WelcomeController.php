<?php

namespace App\Http\Controllers;

use App\Models\LayananDokter; 
use App\Models\Feed;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        
        $layananData = LayananDokter::with('dokter')->get();
        
        $artikel = Feed::select(
                'id_feed',
                'judul_feed',
                'image',
                'update_at',
                'created_at',
                DB::raw('TRIM(SUBSTRING_INDEX(deskripsi, " ", 20)) AS summary')
            )
            ->orderBy('update_at', 'desc')
            ->limit(3)
            ->get();

        return view('welcome', compact('layananData', 'artikel'));
    }
}