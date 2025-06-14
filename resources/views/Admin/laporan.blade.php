<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset/css/admin/dashboardAdmin.css') }}">

    <title>Laporan</title>
</head>
<body>
    <section id="sidebar">
        <div class="head">
            <a href="#" class="profile">
                <img src="{{ asset('asset/image/AdminSimpelah.jpg') }}">
            </a>
            <a href="#" class="logoDentease">
                <span class="text">DENTEASE</span>
            </a>
        </div>
        <ul class="side-menu top">
            <li>
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
            <li class="active">
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
                    <h1>LAPORAN</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">LAPORAN</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Grafik Analisis</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="grafik">
                    <div class="head">
                        <h3>GRAFIK ANALISIS</h3>
                        <i class='bx bx-filter'></i>
                        <div class="boxFilter">
                            <form action="{{ route('admin.laporan') }}" method="GET">
                                <select id="tahun" onchange="this.form.submit()" name="tahun" style="width: 100%; padding: 5px; border: 1px solid; border-radius: 5px; font-size: 12px;">
                                <option value="">-- Pilih Tahun --</option>
                                @foreach($availableYears as $yearOption)
                                <option value="{{ $yearOption }}" {{ $yearOption == $tahun ? 'selected' : '' }}>{{ $yearOption }}</option>
                                @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <canvas id="myLineChart" width="400" height="200"></canvas>
                    <a class="btn btn-outline-primary" href="{{ route('admin.laporan.cetak', ['tahun' => $tahun]) }}" target="_blank" role="button" style="float:right; font-size:15px">Cetak Laporan</a>
                </div>
            </div>
        </main>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.chartData = {
            labels: <?php echo json_encode($bulanList); ?>,
            layananList: <?php echo json_encode($layananList); ?>,
            rawData: <?php echo json_encode($data); ?>
        };
    </script>
    <script src="{{ asset('asset/js/admin/laporan.js') }}"></script>
    <script src="{{ asset('asset/js/main.js') }}"></script>
</body>
</html>