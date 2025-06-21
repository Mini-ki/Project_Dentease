@extends('layouts.auth') {{-- Asumsi nama layout Anda adalah 'main.blade.php' di folder 'layouts' --}}

@section('title', 'Login - Dentease') {{-- Menetapkan judul halaman --}}

@section('additional-css')
    {{-- CSS khusus untuk halaman login --}}
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylesJadwal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('content')
    <div class="wrapper" style="margin-top:170px;">
        <section class="login">
            <img class="imageMenu" src="{{ asset('img/Dental Health.jpg') }}" alt="DentalHealth">
            <div class="kolomform">
                <h1 style="font-family: 'Oswald', sans-serif;">Welcome Back!!</h1>
                <h2 style="font-family: 'Oswald', sans-serif; text-align: left;"> Login</h2>
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <label for="username" style="font-family: 'Barlow', sans-serif;">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <div class="error">{{ $message }}</div>
                    @enderror

                    <label for="password" style="font-family: 'Barlow', sans-serif;">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror

                    <input type="submit" value="Submit" style="height: auto; width: 211px; font-family: sans-serif;">
                </form>
            </div>
        </section>
    </div>

    <div class="errorBoxWrapper">
        <div id="errorBox">
            Invalid Username or Password. Please try again!!
        </div>
    </div>
    <div class="iconSuksesWrapper" id="iconLogInSukses">
        <i class="fa-solid fa-circle-check checkIcon"></i>
    </div>

    <div id="loginStatus" data-status="{{ session('loginStatus') }}"></div>
    <div id="loginRole" data-role="{{ session('loginRole') }}"></div>
@endsection

@section('scripts')
    {{-- JavaScript khusus untuk halaman login --}}
    <script src="{{ asset('js/logIn.js') }}"></script>
@endsection