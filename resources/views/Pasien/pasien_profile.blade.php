@extends('layouts.pasien.pasien')

@section('title', 'Profil Pasien - DENTEASE')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('/css/stylesJanji.css') }}">
    <style>
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border-radius: 8px;
        }
        .profile-photo {
            margin-bottom: 20px;
            text-align: center;
        }
        .profile-photo img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #002A8C;
        }
        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 80%;
            margin-top: 20px;
        }
        .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-field {
            flex: 1 1 calc(50% - 10px); 
            display: flex;
            flex-direction: column;
        }
        .form-field label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-field input[type="text"],
        .form-field input[type="number"],
        .form-field input[type="tel"],
        .form-field input[type="email"],
        .form-field input[type="password"],
        .form-field input[type="file"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-actions {
            text-align: right;
            margin-top: 20px;
        }
        .form-actions button {
            background-color: #002A8C;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .form-actions button:hover {
            background-color: #001f6e;
        }
        @media (max-width: 768px) {
            .form-field {
                flex: 1 1 100%;
            }
        }
    </style>
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
            <div>
                <img src="{{ asset('img/' . ($pasien->foto_profil ?? 'default.jpg')) }}" alt="Foto Profil Pasien" style="margin-left: 135px;">
                <p style="margin-top: 10px; font-weight: bold;">{{ $pasien->nama_lengkap ?? 'Nama Lengkap Pasien' }}</p>
            </div>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
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
    {{-- Your existing scripts, if any --}}
@endsection