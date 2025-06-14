<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DENTEASE - @yield('title')</title> {{-- Title akan dinamis --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet"> 
    
    @stack('styles') 
</head>
<body>
    <section id="sidebar">
        <div class="head">
            <a href="{{ route('admin.dashboard') }}" class="profile"> 
                <img src="{{ asset('img/logo dentease.png') }}" alt="Admin Profile"> 
            </a>
            <a href="{{ route('admin.dashboard') }}" class="logoDentease">
                <span class="text">DENTEASE {{ Auth::user()->role }}</span>
            </a>
        </div>
        <ul class="side-menu top">
            <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"> 
                <a href="{{ route('admin.dashboard') }}">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->role === 'super_admin')
                <li class="{{ Request::routeIs('admin.admin_index') || Request::routeIs('admin.admin_create') || Request::routeIs('admin.admin_edit') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin_index') }}"> {{-- Link ke halaman daftar admin --}}
                        <i class='bx bxs-group'></i>
                        <span class="text">Admin</span>
                    </a>
                </li>
            @endif
            @if(Auth::user()->role !== 'operator')
                <li class="{{ Request::routeIs('admin.dokter') ? 'active' : '' }}">
                    <a href="{{ route('admin.dokter') }}">
                        <i class='bx bxs-group'></i>
                        <span class="text">Dokter</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('admin.layanan') ? 'active' : '' }}">
                    <a href="{{ route('admin.layanan') }}">
                        <i class='bx bxs-doughnut-chart'></i>
                        <span class="text">Layanan</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('admin.laporan') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan') }}">
                        <i class='bx bx-notepad'></i>
                        <span class="text">Laporan</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('admin.feed.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.feed.index') }}">
                        <i class='bx bx-layout'></i>
                        <span class="text">Feed</span>
                    </a>
                </li>
            @endif
            <li class="{{ Request::routeIs('admin.pasien') ? 'active' : '' }}">
                <a href="{{ route('admin.pasien') }}">
                    <i class='bx bxs-group'></i>
                    <span class="text">Pasien</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('admin.konsultasi') ? 'active' : '' }}">
                <a href="{{ route('admin.konsultasi') }}">
                    <i class='bx bxs-conversation'></i>
                    <span class="text">Konsultasi</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: none;" id="logout-form">
                    @csrf
                </form>
                <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a> {{-- Sesuaikan ini jika ada kategori --}}
             {{-- Navbar kanan, mungkin ada profil user atau notifikasi --}}
            <a href="#" class="profile-nav">
                <img src="{{ asset('img/AdminSimpelah.jpg') }}" alt="User">
            </a>
        </nav>

        <main>
            @yield('content') {{-- Konten halaman akan dirender di sini --}}
        </main>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/dashboard.js') }}"></script> {{-- Path JS admin --}}
    <script src="{{ asset('js/main.js') }}"></script> {{-- Path JS umum --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>