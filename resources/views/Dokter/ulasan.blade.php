@extends('layouts.dokter.dokter')

@section('title', 'Ulasan Pasien - DENTEASE')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/Dokter/ulasan.css') }}">
@endsection

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Ulasan Pasien</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('ulasan') }}">Ulasan Pasien</a></li>
            </ul>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Ulasan</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ulasan as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->ulasan }}</td>
                    <td>
                        @php
                            $rating = floatval($row->rating);
                            $bintang = floor($rating);
                        @endphp
                        {{ str_repeat("⭐", $bintang) }} ({{ $rating }})
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Belum ada ulasan dari pasien Anda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection