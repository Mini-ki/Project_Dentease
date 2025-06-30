@extends('layouts.auth') {{-- Pastikan ini sesuai dengan nama file layout Anda (misal: 'main.blade.php') --}}

@section('title', 'Register - Dentease') {{-- Menetapkan judul halaman --}}

@section('additional-css')
    {{-- CSS khusus untuk halaman register --}}
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pasien/stylesJadwal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pasien/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('content')
    <div class="wrapper" style="margin-top: 150px;">
        <section class="signup">
            <img class="imageMenu" src="{{ asset('img/Dental Health.jpg') }}" alt="DentalHealth">
            <div class="kolomform">
                <h1 style="font-family: 'Oswald', sans-serif;">Hello, Welcome!</h1>
                <h2 style="font-family: 'Oswald', sans-serif; text-align: left;">Sign-Up</h2>
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    <label for="username" style="font-family: 'Barlow', sans-serif;">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}">
                    @error('username') <span class="errorText">{{ $message }}</span> @enderror

                    <label for="email" style="font-family: 'Barlow', sans-serif;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                    @error('email') <span class="errorText">{{ $message }}</span> @enderror

                    <label for="password" style="font-family: 'Barlow', sans-serif;">Password</label>
                    <input type="password" id="password" name="password">
                    @error('password') <span class="errorText">{{ $message }}</span> @enderror

                    <label for="password_confirmation" style="font-family: 'Barlow', sans-serif;">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation') <span class="errorText">{{ $message }}</span> @enderror

                    <input type="submit" value="Register" style="height: auto; width: 211px; font-family: sans-serif;">
                </form>
            </div>
        </section>
    </div>

    {{-- Bagian errorBoxWrapper dan iconSuksesWrapper ini mungkin perlu disesuaikan.
         Jika layout utama sudah punya penanganan error/notifikasi, ini bisa dihapus atau diganti. --}}
    <div class="errorBoxWrapper">
        <div id="errorBox">
            Invalid Username or Password. Please try again!!
        </div>
    </div>
    <div class="iconSuksesWrapper" id="iconLogInSukses"> {{-- Nama ID ini 'iconLogInSukses' mungkin perlu diubah jadi 'iconRegisterSukses' agar lebih spesifik --}}
        <i class="fa-solid fa-circle-check checkIcon"></i>
    </div>

    <div id="loginStatus" data-status="{{ session('loginStatus') }}"></div>
    <div id="loginRole" data-role="{{ session('loginRole') }}"></div>
@endsection

@section('scripts')
    {{-- JavaScript khusus untuk halaman register --}}
    <script src="{{ asset('js/signUp.js') }}"></script>
@endsection