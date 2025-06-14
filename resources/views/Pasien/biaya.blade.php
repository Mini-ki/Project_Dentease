@extends('layouts.pasien.pasien')

@section('title', 'Dokter dan Layanan')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/biaya.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cardDokter.css') }}">
@endsection
@section('banner-title', 'Dokter dan Layanan')
@section('banner-description', 'Dokter, layanan, dan biaya layanan kami.')

@section('content')

<h1 class="text-center" style="font-size: 50px; font-family: 'Oswald', sans-serif; color: #002A8C;">Dokter Kami</h1>
<p class="text-center" style="font-family: 'Oswald', sans-serif; color: #002A8C;">Kenali para profesional di balik senyum sehat Anda.</p>

<div class="grid-container" style="margin-bottom: 200px;">
    @forelse ($dokterList as $dokter)
        <div class="card">
            <img src="{{ asset('assets/img/dokter-default.png') }}" alt="Foto Dokter">
            <div class="info">
                <h4>{{ $dokter->nama_panggilan }}</h4>
                <p><em>{{ $dokter->spesialis }}</em></p>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    @empty
        <p style="text-align: center;">Belum ada data dokter.</p>
    @endforelse
</div>

<h1 class="text-center" style="font-size: 50px; font-family: 'Oswald', sans-serif; color: #002A8C;">Layanan Kami</h1>
<p class="text-center" style="font-family: 'Oswald', sans-serif; color: #002A8C;">Layanan dan biaya layanan yang kami sediakan.</p>

<div class="container mb-5">
    <table class="table table-bordered text-center">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Layanan</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($layananList as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->nama_lengkap }}</td>
                    <td>{{ $row->nama_layanan }}</td>
                    <td>Rp{{ number_format($row->biaya_layanan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada data layanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="text-center mb-5">
    <a href="{{ route('pasien.homepage') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
