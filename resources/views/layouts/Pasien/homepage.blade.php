<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="icon" href="{{ asset('img/Icon Dentease.png') }}" type="image/png">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pasien/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pasien/footer.css') }}">

    @yield('additional-css')
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('pasien.homepage') }}">
                <img src="{{ asset('img/logo dentease.png') }}" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.homepage') ? 'active' : '' }}" href="{{ route('pasien.homepage') }}">Homepage</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.jadwal') ? 'active' : '' }}" href="{{ route('pasien.jadwal') }}">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.janji') ? 'active' : '' }}" href="{{ route('pasien.janji') }}">Janji Temu</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.konsultasi') ? 'active' : '' }}" href="{{ route('pasien.konsultasi') }}">Konsultasi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pasien.biaya') ? 'active' : '' }}" href="{{ route('pasien.biaya') }}">Biaya</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('profile') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">Akun</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            {{-- Perubahan di sini untuk link Profil --}}
                            <li><a class="dropdown-item {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @yield('content')
    <footer id="footer" style="margin-top: 200px;">
        <div class="footer-container">
            <div class="footer-section">
                <h3>About us</h3>
                <p>Dentease adalah tempat perawatan gigi terbaik di Jogja dengan
                pelayanan modern dan tenaga medis berpengalaman.</p>
            </div>
            <div class="footer-section">
                <h3>Our contact</h3>
                <p><strong>Alamat:</strong> Jl. Informatika Alamat No. 23, Kota Yogyakarta</p>
                <p><strong>Telepon:</strong> F1D02310107</p>
                <p><strong>Email:</strong> <a href="mailto:f1d02310107@student.unram.ac.id">f1d02310107@student.unram.ac.id</a></p>
            </div>
            <div class="footer-section">
                <h3>Location</h3>
                <iframe src="https://www.google.com/maps/embed?pb=..."
                        style="width: 250.4px; height: 150.4px; border: none; border-radius: 20px;">
                </iframe>
            </div>
            <div class="footer-section">
                <h3>Follow us!</h3>
                <ul class="social-media">
                    <li><a href="https://facebook.com" target="_blank">Facebook</a></li>
                    <li><a href="https://twitter.com" target="_blank">Twitter</a></li>
                    <li><a href="https://instagram.com" target="_blank">Instagram</a></li>
                    <li><a href="https://linkedin.com" target="_blank">LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Dentease | All rights reserved.</p>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
