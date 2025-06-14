<!DOCTYPE html>
<html lang="en">
<head>
<title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/dashboard.css') }}" rel="stylesheet">

</head>
    
<body>
    <section id="sidebar">
        <div class="head">
            <a href="{{ route('admin.admin') }}" class="profile">
                <img src="{{ asset('img/AdminSimpelah.jpg') }}">
            </a>
            <a href="{{ route('admin.dashboard') }}" class="logoDentease">
                <span class="text">DENTEASE {{ Auth::user()->role }}</span>
            </a>
        </div>
        <ul class="side-menu top">
            <li class="active"> 
                <a href="{{ route('admin.dashboard') }}">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->role === 'super_admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class='bx bxs-group'></i>
                        <span class="text">Admin</span>
                    </a>
                </li>
            @endif
            @if(Auth::user()->role !== 'operator')
                <li>
                    <a href="{{ route('admin.dokter') }}">
                        <i class='bx bxs-group'></i>
                        <span class="text">Dokter</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.layanan') }}">
                        <i class='bx bxs-doughnut-chart'></i>
                        <span class="text">Layanan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.laporan') }}">
                        <i class='bx bx-notepad'></i>
                        <span class="text">Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.feed') }}">
                        <i class='bx bx-layout'></i>
                        <span class="text">Feed</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('admin.pasien') }}">
                    <i class='bx bxs-group'></i>
                    <span class="text">Pasien</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.konsultasi') }}">
                    <i class='bx bxs-conversation'></i>
                    <span class="text">Konsultasi</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" class="logout">
                    <i class='bx bx-log-out'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
        </nav>

        <main>
            @yield('content')
        </main>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/dashboardAdmin.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>