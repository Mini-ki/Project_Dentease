@extends('layouts.admin.admin')

@section('title', 'Data Konsultasi')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>KONSULTASI</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('admin.konsultasi') }}">Data Konsultasi</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info konsultasi">
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>KONSULTASI</h3>
                <h5>SUDAH SELESAI</h5>
                <p>{{ $jumlah_konsultasiSelesai }}</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>KONSULTASI</h3>
                <h5>BELUM SELESAI</h5>
                <p>{{ $jumlah_konsultasiBelum }}</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>KONSULTASI</h3>
                <h5>SEDANG BERLANGSUNG</h5>
                <p>{{ $jumlah_konsultasiSedangKonsultasi }}</p>
            </span>
        </li>
    </ul>

    <div class="table-data">
        <div class="showTable">
            <div class="head">
                <h3>DATA KONSULTASI</h3>
                <div class="header-actions">
                    <i class='bx bx-search' ></i>
                    <i class='bx bx-filter' ></i>
                    <form id="searchForm" action="{{ route('admin.konsultasi') }}" method="GET">
                        <div class="form-input">
                            <input type="search" name="searchInput" id="searchInput" placeholder="Search..." value="{{ request('searchInput') }}">
                            <button type="submit"><i class='bx bx-search' style="color:#FFFFFF"></i></button>
                        </div>
                    </form>
                    <div class="boxFilter">
                        <form action="{{ route('admin.konsultasi') }}" method="GET">
                            @if(request('searchInput'))
                                <input type="hidden" name="searchInput" value="{{ request('searchInput') }}">
                            @endif
                            <select id="filter" onchange="this.form.submit()" name="filter" style="width: 100%; padding: 5px; border: 1px solid; border-radius: 5px; font-size: 12px;">
                                <option value="">-- Pilih Status --</option>
                                <option value="Sudah Selesai" {{ request('filter') == 'Sudah Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Sedang Konsultasi" {{ request('filter') == 'Sedang Konsultasi' ? 'selected' : '' }}>Sedang Konsultasi</option>
                                <option value="Belum" {{ request('filter') == 'Belum' ? 'selected' : '' }}>Belum Selesai</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="body">
                <table id="table-information">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Nama Pasien</th>
                            <th scope="col">Nama Dokter</th>
                            <th scope="col">Nama Layanan</th>
                            <th scope="col">Tanggal Konsultasi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($konsultasiData as $key => $data)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                {{-- Mengakses data melalui relasi --}}
                                <td scope="row">{{ $data->pasien->nama_lengkap ?? 'N/A' }}</td>
                                <td scope="row">{{ $data->dokter->nama_lengkap ?? 'N/A' }}</td>
                                <td scope="row">{{ $data->dokter->layananDokter->nama_layanan ?? 'N/A' }}</td> {{-- Akses layanan via dokter --}}
                                <td scope="row">{{ $data->tanggal_konsultasi }}</td>
                                <td scope="row">{{ $data->status }}</td>
                                <td scope="row">{{ $data->status_pembayaran }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data konsultasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
