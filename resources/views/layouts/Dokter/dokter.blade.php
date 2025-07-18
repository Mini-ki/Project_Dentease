<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Dokter Dashboard')</title> {{-- Default title if not set --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Penting untuk keamanan AJAX --}}
    <link rel="icon" href="{{ asset('img/Icon Dentease.png') }}" type="image/png">
    {{-- External CSS Libraries --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    {{-- Your Custom CSS Files (di dalam folder Dokter) --}}
    <link href="{{ asset('css/Dokter/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Dokter/dashboard.css') }}" rel="stylesheet">

    {{-- Additional CSS from specific views --}}
    @yield('additional-css')

</head>
<body style="z-index: 1000">
    @php
        $imagePath = 'storage/' . ($dokter->foto_profil);
    @endphp
    <section id="sidebar">
        <div class="head">
            <a href="{{ route('dokter.dashboard') }}" class="profile">
                {{-- Pastikan gambar ini ada di public/img/DokterProfile.jpg --}}
                <img src="{{ asset($imagePath ?? 'default.jpg') }}" alt="Dokter Profile Picture">
            </a>
            <a href="{{ route('dokter.dashboard') }}" class="logoDentease">
                <span class="text">DENTEASE</span>
            </a>
        </div>
        <ul class="side-menu top">
            <li class="{{ Request::routeIs('dokter.dashboard') ? 'active' : '' }}">
                <a href="{{ route('dokter.dashboard') }}">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('dokter.profil') ? 'active' : '' }}">
                <a href="{{ route('dokter.profil') }}">
                    <i class='bx bxs-user'></i> {{-- Menggunakan ikon user yang lebih sesuai untuk profil --}}
                    <span class="text">Profil Dokter</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('rekam_medis') ? 'active' : '' }}">
                <a href="{{ route('rekam_medis') }}">
                    <i class='bx bxs-group'></i> {{-- Tetap pakai ikon group untuk rekam medis/pasien --}}
                    <span class="text">Rekam Medis</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('dokter.jadwal') ? 'active' : '' }}">
                <a href="{{ route('dokter.jadwal') }}">
                    <i class='bx bx-calendar'></i> {{-- Menggunakan ikon kalender untuk jadwal --}}
                    <span class="text">Jadwal</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('dokter.janjitemu') ? 'active' : '' }}">
                <a href="{{ route('dokter.janjitemu') }}">
                    <i class='bx bxs-conversation'></i>
                    <span class="text">Janji Temu</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('ulasan') ? 'active' : '' }}">
                <a href="{{ route('ulasan') }}">
                    <i class='bx bxs-star'></i> {{-- Menggunakan ikon bintang untuk ulasan --}}
                    <span class="text">Ulasan</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" class="logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class='bx bx-log-out' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" style="z-index: 2000;">
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

    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            {{-- Mengganti "Categories" menjadi "Dashboard" atau nama yang lebih relevan --}}
            <a href="{{ route('dokter.dashboard') }}" class="nav-link">Dashboard</a>
            {{-- Anda bisa menambahkan elemen lain di sini, seperti notifikasi atau profil dokter di navbar atas --}}
        </nav>

        <main>
            @yield('content')
        </main>
    </section>

    {{-- External JavaScript Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Your Custom JavaScript Files (di dalam folder Dokter) --}}
    {{-- Memastikan jalur ke file JS Anda benar-benar di public/js/Dokter/ --}}
    <script src="{{ asset('js/Dokter/dashboard.js') }}"></script>
    <script src="{{ asset('js/Dokter/main.js') }}"></script>
    {{-- Jika pasien.js digunakan di halaman Rekam Medis dan berada di folder Dokter --}}
    <script src="{{ asset('js/Dokter/pasien.js') }}"></script>

    {{-- Additional Scripts from specific views --}}
    @yield('scripts')
</body>
</html>
