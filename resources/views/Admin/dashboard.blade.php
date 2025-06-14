<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset/css/admin/dasboardAdmin.css') }}">

    <title>Admin Dentease</title>
</head>
<body>
    <section id="sidebar">
        <div class="head">
            <a href="#" class="profile">
                <img src="{{ asset('asset/image/AdminSimpelah.jpg') }}">
            </a>
            <a href="#" class="logoDentease">
                <span class="text">DENTEASE</span>{{-- role tidak perlu ditampilkan di sini --}}
            </a>
        </div>
        <ul class="side-menu top">
            <li class="active">
                {{-- Menggunakan route() helper untuk link --}}
                <a href="{{ route('admin.dashboard') }}">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @if($role === 'super_admin')
            <li>
                <a href="{{ route('admin.admin') }}">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Admin</span>
                </a>
            </li>
            @endif
            @if($role !== 'operator')
            <li>
                <a href="{{ route('admin.dokter') }}">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Dokter</span>
                </a>
            </li>
            @endif
            <li>
                <a href="{{ route('admin.pasien') }}">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Pasien</span>
                </a>
            </li>
            @if($role !== 'operator')
            <li>
                <a href="{{ route('admin.layanan') }}">
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">Layanan</span>
                </a>
            </li>
            @endif
            <li>
                <a href="{{ route('admin.konsultasi') }}">
                    <i class='bx bxs-conversation'></i>
                    <span class="text">Konsultasi</span>
                </a>
            </li>
            @if($role !== 'operator')
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
        </ul>
        <ul class="side-menu">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout" style="background: none; border: none; padding: 0; margin: 0; color: inherit; cursor: pointer;">
                        <i class='bx bx-log-out'></i>
                        <span class="text">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </section>
    <section id="content">
        <nav>
            <i class='bx bx-menu' ></i>
            <a href="#" class="nav-link">Categories</a>
        </nav>
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-group' ></i>
                    <span class="text">
                        <h3>DOKTER</h3>
                        <p>{{ $jumlahDokter }}</p> {{-- Menampilkan variabel dari controller --}}
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group' ></i>
                    <span class="text">
                        <h3>PASIEN</h3>
                        <p>{{ $jumlahPasien }}</p> {{-- Menampilkan variabel dari controller --}}
                    </span>
                </li>
                <li>
                    <i class='bx bx-notepad'></i>
                    <span class="text">
                        <h3>KONSULTASI</h3>
                        <p>{{ $jumlahKonsultasi }}</p> {{-- Menampilkan variabel dari controller --}}
                    </span>
                </li>
            </ul>
            <div class="table-data">
                <div class="grafik">
                    <div class="head">
                        <h3>GRAFIK ANALISIS</h3>
                        <i class='bx bx-filter' ></i>
                    </div>
                    <canvas id="myLineChart" data-dokter="{{ $jumlahDokter }}" data-pasien="{{ $jumlahPasien }}" data-konsultasi="{{ $jumlahKonsultasi }}" width="400" height="200"></canvas>
                </div>
            </div>
        </main>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('asset/js/admin/dashboardAdmin.js') }}"></script>
    <script src="{{ asset('asset/js/main.js') }}"></script>
</body>
</html>