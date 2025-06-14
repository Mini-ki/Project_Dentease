<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Dentease</title>
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
    <section class="login">
        <img class="imageMenu" src="{{ asset('img/Dental Health.jpg') }}" alt="DentalHealth">
        <div class="kolomform">
            <h1>Welcome Back!!</h1>
            <h2>Login</h2>
            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror

                <input type="submit" value="Submit">
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

<!-- Hidden elements to hold login status and role for JS -->
<div id="loginStatus" data-status="{{ session('loginStatus') }}"></div>
<div id="loginRole" data-role="{{ session('loginRole') }}"></div>

<script src="{{ asset('js/logIn.js') }}"></script>

</body>
</html>