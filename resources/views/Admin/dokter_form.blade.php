<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset/css/admin/dasboardAdmin.css') }}">

    <title>Data Dokter</title>
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
            <li class="active">
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
                    <h1>DOKTER</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dokter</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Data Dokter</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="createData">
                    <div class="head">
                        <h3>{{ isset($dokter) ? 'EDIT DATA DOKTER' : 'TAMBAH DATA DOKTER' }}</h3>
                    </div>
                    <div class="body">
                        {{-- Notifikasi Sukses/Error --}}
                        @if(session('sukses'))
                            <div class="alert alert-success">
                                {{ session('sukses') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        {{-- Display validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ isset($dokter) ? route('admin.dokter.update', $dokter->id_dokter) : route('admin.dokter.store') }}" method="POST">
                            @csrf
                            @if(isset($dokter))
                                @method('PUT') {{-- Untuk update menggunakan method PUT --}}
                            @endif

                            @if(!isset($dokter)) {{-- Form untuk tambah baru --}}
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" value="{{ old('username') }}">

                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}">

                                <label for="password">Password</label>
                                <input type="password" id="password" name="password">
                            @endif

                            <label for="nama_panggilan">Nama Panggilan</label>
                            <input type="text" name="nama_panggilan" id="nama_panggilan" value="{{ old('nama_panggilan', $dokter->nama_panggilan ?? '') }}">

                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $dokter->nama_lengkap ?? '') }}">

                            <label for="umur">Umur</label>
                            <input type="text" name="umur" id="umur" value="{{ old('umur', $dokter->umur ?? '') }}">

                            <label for="spesialis">Spesialis</label>
                            <input type="text" name="spesialis" id="spesialis" value="{{ old('spesialis', $dokter->spesialis ?? '') }}">

                            <label for="layanan">Layanan</label>
                            <select id="layanan" name="layanan" style="width: 100%; padding: 10px; border: 1px solid; border-radius: 5px;">
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->nama_layanan }}"
                                        {{ (isset($dokter) && $dokter->id_layanan == $layanan->id_layanan) || old('layanan') == $layanan->nama_layanan ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>

                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $dokter->alamat ?? '') }}">

                            <input type="submit" value="SUBMIT" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <div id="blurbox"></div>
    <script src="{{ asset('asset/js/main.js') }}"></script>
</body>
</html>