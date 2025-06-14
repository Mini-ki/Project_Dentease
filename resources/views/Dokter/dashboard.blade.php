@extends('layouts.dokter.dokter') 

@section('title', 'Dokter Dashboard') 

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/dokter/dashboard.css') }}">
@endsection

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('dokter.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('dokter.dashboard') }}">Home</a>
                </li>
            </ul>
        </div>
    </div>
    <ul class="box-info">
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>Total Pasien</h3>
                <p>{{ $jumlah_pasien }}</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>Total Konsultasi</h3>
                <p>{{ $jumlah_konsultasi }}</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-conversation'></i>
            <span class="text">
                <h3>Sedang Konsultasi</h3>
                <p>{{ $jumlah_belum }}</p>
            </span>
        </li>
        <li>
            <i class='bx bx-check-circle'></i>
            <span class="text">
                <h3>Sudah Diperiksa</h3>
                <p>{{ $jumlah_selesai }}</p>
            </span>
        </li>
    </ul>

    <div class="table-data">
        <div class="grafik">
            <canvas id="myLineChart"
                data-pasien="{{ $jumlah_pasien }}"
                data-konsultasi="{{ $jumlah_konsultasi }}"
                data-belum="{{ $jumlah_belum }}"
                data-selesai="{{ $jumlah_selesai }}">
            </canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dokter/dashboard.js') }}"></script> 
@endsection