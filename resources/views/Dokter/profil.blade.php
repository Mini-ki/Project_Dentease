@extends('layouts.dokter.dokter')

@section('title', 'Profil Dokter - DENTEASE')
@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/dokter/profil.css') }}">
@endsection
@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Profil Dokter</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('dokter.profil') }}">Profil Dokter</a></li>
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-photo">
        <div>
            <img src="{{ asset('assets/image/' . $dokter->foto_profil) }}" alt="Foto Profil Dokter">
            <p style="margin-top: 10px; font-weight: bold;">{{ $dokter->nama_lengkap }}</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('dokter.profil.update') }}" enctype="multipart/form-data">
            @csrf {{-- CSRF token for security --}}
            @method('PUT') {{-- Use PUT method for updates in Laravel --}}

            <div class="form-group">
                <div class="form-field">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $dokter->nama_lengkap) }}" required>
                </div>
                <div class="form-field">
                    <label for="nama_panggilan">Nama Panggilan</label>
                    <input type="text" id="nama_panggilan" name="nama_panggilan" value="{{ old('nama_panggilan', $dokter->nama_panggilan) }}" required>
                </div>
                <div class="form-field">
                    <label for="umur">Usia</label>
                    {{-- Corrected input name from 'noHp' to 'umur' based on your variable --}}
                    <input type="number" id="umur" name="umur" value="{{ old('umur', $dokter->umur) }}" required>
                </div>
                <div class="form-field">
                    <label for="spesialis">Spesialis</label>
                    <input type="text" id="spesialis" name="spesialis" value="{{ old('spesialis', $dokter->spesialis) }}" required>
                </div>
                <div class="form-field">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $dokter->alamat) }}" required>
                </div>
                {{-- Uncomment if you want to allow profile photo uploads --}}
                {{-- <div class="form-field">
                    <label for="foto_profil">Foto Profil</label>
                    <input type="file" id="foto_profil" name="foto_profil" accept="image/*">
                </div> --}}
            </div>
            <div class="form-actions">
                <button type="submit">Update</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/dokter/dashboard.js') }}"></script>
@endsection