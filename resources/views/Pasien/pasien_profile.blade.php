@extends('layouts.pasien.pasien')

@section('title', 'Profil Pasien - DENTEASE')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('/css/pasien/stylesJanji.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/pasien/pofile.css') }}">
@endsection

@section('banner-title', 'Profil Pasien')
@section('banner-description', 'Kelola informasi pribadi Anda di sini.')

@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-container">
        <div class="profile-photo">
            @php
                $imagePath = 'storage/' . ($pasien->foto_profil);
            @endphp
            <div>
                <img src="{{ asset($imagePath ?? 'default.jpg') }}" alt="Foto Profil Pasien" style="margin-left: 135px;">
                <p style="margin-top: 10px; font-weight: bold; font-family: 'Barlow', sans-serif;">{{ $pasien->nama_lengkap ?? 'Nama Lengkap Pasien' }}</p>
            </div>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group" style="font-family: 'Barlow', sans-serif;">
                    {{-- Data dari tabel `pasiens` --}}
                    <div class="form-field">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $pasien->nama_lengkap ?? '') }}" required>
                    </div>
                    <div class="form-field">
                        <label for="nama_panggilan">Nama Panggilan</label>
                        <input type="text" id="nama_panggilan" name="nama_panggilan"
                            value="{{ old('nama_panggilan', $pasien->nama_panggilan ?? '') }}" required>
                    </div>
                    <div class="form-field">
                        <label for="umur">Usia</label>
                        <input type="number" id="umur" name="umur"
                            value="{{ old('umur', $pasien->umur ?? '') }}" required>
                    </div>
                    <div class="form-field">
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat"
                            value="{{ old('alamat', $pasien->alamat ?? '') }}" required>
                    </div>
                    <div class="form-field">
                        <label for="noHp">Nomor Telepon</label>
                        <input type="tel" id="noHp" name="noHp"
                            value="{{ old('noHp', $pasien->noHp ?? '') }}" required>
                    </div>
                    <div class="form-field">
                        <label for="foto_profil">Foto Profil (opsional)</label>
                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*">
                    </div>

                    {{-- Data dari tabel `users` --}}
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $user->email ?? '') }}" required>
                    </div>
                    <div class="form-field">
                        <label for="username">Username (opsional)</label>
                        <input type="text" id="username" name="username"
                            value="{{ old('username', $user->username ?? '') }}">
                    </div>

                    {{-- Password Update --}}
                    <div class="form-field">
                        <label for="password">Password Baru (kosongkan jika tidak ingin diubah)</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="form-field">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit">Update Profil</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/AllJava.js') }}"></script>
@endsection
