<!DOCTYPE html>
<html lang="en">
<head>
<title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" /> --}}
    <link href="{{ asset('css/Admin/dashboard.css') }}" rel="stylesheet">
</head>

<body>
    <section id="sidebar" style="z-index: 1000">
        <div class="head">
            <a href="{{ route('admin.admin.index') }}" class="profile">
                <img src="{{ asset('img/admin/AdminDentease.jpeg') }}">
            </a>
            <a href="{{ route('admin.dashboard') }}" class="logoDentease">
                <span class="text">DENTEASE</span>
            </a>
        </div>
        <ul class="side-menu top">
            <li class="active">
                <a href="{{ route('admin.dashboard') }}">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @if(Auth::check() && Auth::user()->sub_role === 'super_admin')
            <li>
                <a href="{{ route('admin.admin.index') }}">
                    <i class='bx bxs-group'></i>
                    <span class="text">Admin</span>
                </a>
            </li>
            @endif
            @if(Auth::check() && Auth::user()->sub_role !== 'operator')
                <li>
                    <a href="{{ route('admin.dokter.index') }}">
                        <i class='bx bxs-group'></i>
                        <span class="text">Dokter</span>
                    </a>
                </li>
            @endif
                <li>
                    <a href="{{ route('admin.pasien.index') }}">
                        <i class='bx bxs-group'></i>
                        <span class="text">Pasien</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.layanan.index') }}">
                        <i class='bx bxs-doughnut-chart'></i>
                        <span class="text">Layanan</span>
                    </a>
                </li>
            @if(Auth::check() && Auth::user()->sub_role !== 'operator')
                <li>
                    <a href="{{ route('admin.laporan') }}">
                        <i class='bx bx-notepad'></i>
                        <span class="text">Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.feed.index') }}">
                        <i class='bx bx-layout'></i>
                        <span class="text">Feed</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('admin.konsultasi') }}">
                    <i class='bx bxs-conversation'></i>
                    <span class="text">Konsultasi</span>
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

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" style="z-index: 2000">
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
            <a href="#" class="nav-link">Categories</a>
        </nav>

        <main>
            @yield('content')
        </main>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/dashboardAdmin.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/setTable.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
