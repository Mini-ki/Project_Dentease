@extends('layouts.admin.admin')

@section('title', 'Dashboard Admin')



@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="{{ route('admin.dashboard') }}">Home</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        <li>
            <i class='bx bxs-group' ></i>
            <span class="text">
                <h3>DOKTER</h3>
                <p>{{ $jumlahDokter }}</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group' ></i>
            <span class="text">
                <h3>PASIEN</h3>
                <p>{{ $jumlahPasien }}</p>
            </span>
        </li>
        <li>
            <i class='bx bx-notepad'></i>
            <span class="text">
                <h3>KONSULTASI</h3>
                <p>{{ $jumlahKonsultasi }}</p>
            </span>
        </li>
    </ul>

    <div class="table-data">
        <div class="grafik">
            <div class="head">
                <h3>GRAFIK ANALISIS</h3>
                <i class='bx bx-filter' ></i>
            </div>
            <canvas id="myLineChart" data-dokter="{{ $jumlahDokter }}" data-pasien="{{ $jumlahPasien }}" data-konsultasi="{{ $jumlahKonsultasi }}" width="400" height="200"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/dashboardAdmin.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection