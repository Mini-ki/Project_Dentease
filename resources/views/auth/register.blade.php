<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Dentease</title>
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav>
    <div class="header">
       <div class="logoDentease">
            <img src="{{ asset('img/Logo Dentease.svg') }}" alt="logoDentease">
        </div>
        <div class="menu">
            <ul>
                <li><a href="{{ route('welcome') }}">HOME</a></li>
                <li><a href="{{ route('login') }}">LOGIN</a></li>
                <li><a href="{{ route('register') }}">SIGN UP</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper">
<section class="signup">
        <img class="imageMenu" src="{{ asset('img/Dental Health.jpg') }}" alt="DentalHealth">
        <div class="kolomform">
            <h1>Hello, Welcome!!</h1>
            <h2>Sign-Up</h2>
            <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}">
                @error('username') <span class="errorText">{{ $message }}</span> @enderror

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email') <span class="errorText">{{ $message }}</span> @enderror

                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                @error('password') <span class="errorText">{{ $message }}</span> @enderror

                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation') <span class="errorText">{{ $message }}</span> @enderror

                <input type="submit" value="Register">
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

<script src="{{ asset('js/signUp.js') }}"></script>

</body>
</html>
    