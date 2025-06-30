@extends('layouts.admin.admin')

@section('title', 'Layanan Dentease')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>LAYANAN</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('admin.layanan.index') }}">Data Layanan</a></li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        @foreach($layananStatistik as $layanan)
            @if($layanan->dokters_count > 0 && $layanan->status == 'Aktif')
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h4>{{ $layanan->nama_layanan }}</h4>
                        <p>{{ $layanan->dokters_count }} Dokter</p>
                    </span>
                </li>
            @endif
        @endforeach
    </ul>

    @if($userRole !== 'operator')
        <div class="table-data">
            <div class="createData">
                <div class="head">
                    <h3>{{ $op == 'edit' ? 'EDIT DATA LAYANAN' : 'TAMBAH DATA LAYANAN' }}</h3>
                </div>
                <div class="body">
                    @if ($error)
                        <script>alert("{{ $error }}");</script>
                    @endif
                    @if ($sukses)
                        <script>alert("{{ $sukses }}");</script>
                    @endif
                    <form action="{{ isset($op) && $op == 'edit'? route('admin.layanan.update', $layanantoEdit->id_layanan) : route('admin.layanan.store') }}" method="POST">
                        @csrf
                        @if(isset($op) && $op == 'edit')
                            @method('PUT')
                        @endif

                        <label for="nama_layanan">Nama Layanan</label>
                        <input type="text" name="nama_layanan" id="nama_layanan" value="{{ old('nama_layanan', $layanantoEdit->nama_layanan ?? '') }}" required>
                        @error('nama_layanan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="biaya_layanan">Biaya Layanan</label>
                        <input type="text" name="biaya_layanan" id="biaya_layanan" value="{{ old('biaya_layanan', $layanantoEdit->biaya_layanan ?? '') }}" required>
                        @error('biaya_layanan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <input type="submit" value="SUBMIT">
                    </form>
                </div>
            </div>
            <div class="showTable">
                <div class="head">
                    <h3>DATA LAYANAN</h3>
                </div>
                <div class="body">
                    <table id="table-information">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama Layanan</th>
                                <th>Biaya Layanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $urut = 1; @endphp
                            @forelse($layananData as $data)
                                <tr>
                                    <td>{{ $urut++ }}</td>
                                    <td>{{ $data->nama_layanan }}</td>
                                    <td>Rp. {{ number_format($data->biaya_layanan, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('admin.layanan.toggle-status', $data->id_layanan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" id="{{ $data->status == 'Aktif' ? 'button-hijau' : 'button-merah' }}">
                                                {{ $data->status }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="nowrap">
                                        <a href="{{ route('admin.layanan.edit', $data->id_layanan) }}"><button type="button" id="button-edit">Edit</button></a>
                                        <form action="{{ route('admin.layanan.destroy', $data->id_layanan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="button-delete" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">Tidak ada data layanan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="table-data">
        <div class="showTable">
            <div class="head">
                <h3>JADWAL DOKTER</h3>
                <i class='bx bx-search' ></i>
                <i class='bx bx-filter' ></i>
                <div class="boxFilter">
                    <form action="{{ route('admin.layanan.index') }}" method="GET" style="display:inline-block;">
                        <select name="filter" onchange="this.form.submit()" style="width: 100%; padding: 5px; border: 1px solid; border-radius: 5px; font-size: 12px;">
                            <option value="">-- Pilih Hari --</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                                <option value="{{ $hari }}" {{ request('filter') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                    <form id="searchForm" action="{{ route('admin.layanan.index') }}" method="GET">
                    <div class="form-input">
                        <input type="search" name="searchInput" id="searchInput" placeholder="Search..." value="{{ request('searchInput') }}">
                        <button type="submit"><i class='bx bx-search' style="color:#FFFFFF"></i></button>
                    </div>
                </form>
            </div>
            <div class="body">
                <table id="table-information">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Dokter</th>
                            <th>Nama Layanan</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalDokterData as $key => $jadwal)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $jadwal->dokter->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $jadwal->dokter->layananDokter->nama_layanan ?? 'N/A' }}</td>
                                <td>{{ $jadwal->hari }}</td>
                                <td>{{ $jadwal->jam_mulai }}</td>
                                <td>{{ $jadwal->jam_selesai }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">Tidak ada data jadwal dokter.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
