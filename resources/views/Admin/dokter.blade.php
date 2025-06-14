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
                {{-- Tombol Tambah Data hanya untuk super_admin dan admin --}}
                @if($role === 'super_admin' || $role === 'admin')
                <a href="{{ route('admin.dokter.create') }}" class="btn-download">
                    <i class='bx bxs-cloud-download' ></i>
                    <span class="text">Tambah Data</span>
                </a>
                @endif
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head" style="display:block">
                        <h3>DATA DOKTER</h3>
                        {{-- Notifikasi Sukses/Error --}}
                        @if(session('sukses'))
                            <div class="alert alert-success mt-3">
                                {{ session('sukses') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        <i class='bx bx-search' ></i>
                        <i class='bx bx-filter' ></i>
                        <div class="boxFilter">
                            <form action="{{ route('admin.dokter') }}" method="GET">
                                <select id="filter" onchange="this.form.submit()" name="filter" style="width: 100%; padding: 5px; border: 1px solid; border-radius: 5px; font-size: 12px;">
                                    <option value="" style="text-align: center;">-- Pilih Spesialis --</option>
                                    @foreach($distinctSpesialis as $spec)
                                        <option value="{{ $spec }}" {{ request('filter') == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <form id="searchForm" action="{{ route('admin.dokter') }}" method="GET">
                            <div class="form-input">
                                <input type="search" name="searchInput" id="searchInput" placeholder="Search..." value="{{ request('searchInput') }}">
                                <button type="submit"><i class='bx bx-search' style="color:#FFFFFF"></i></button>
                            </div>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama Panggilan</th>
                                <th>Nama Lengkap</th>
                                <th>Umur</th>
                                <th>Spesialis</th>
                                <th>Alamat</th>
                                <th>Rating</th>
                                @if($role === 'super_admin' || $role === 'admin')
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $urut = 1; @endphp
                            @foreach($dokters as $dokter)
                                <tr>
                                    <td>{{ $urut++ }}</td>
                                    <td>{{ $dokter->nama_panggilan }}</td>
                                    <td class="nowrap">{{ $dokter->nama_lengkap }}</td>
                                    <td>{{ $dokter->umur }}</td>
                                    <td>{{ $dokter->spesialis }}</td>
                                    <td>{{ $dokter->alamat }}</td>
                                    <td>{{ $dokter->rating }}</td>
                                    @if($role === 'super_admin' || $role === 'admin')
                                    <td class="nowrap">
                                        <a href="{{ route('admin.dokter.edit', $dokter->id_dokter) }}"><button type="button" id="button-edit">Edit</button></a>
                                        <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini??')" class="d-inline" action="{{ route('admin.dokter.destroy', $dokter->id_dokter) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="button-delete">Delete</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <div id="blurbox"></div>
    <script src="{{ asset('asset/js/main.js') }}"></script>
</body>
</html>