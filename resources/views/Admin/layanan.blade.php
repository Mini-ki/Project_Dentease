
@extends('layouts.admin.admin') {{-- Asumsi Anda memiliki layout admin --}}

@section('title', 'Layanan Dentease')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>LAYANAN</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('admin.layanan') }}">Data Layanan</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        @foreach($layananStatistik as $layanan)
            @if($layanan->dokters_count > 0 && $layanan->status == 'Aktif') {{-- Hanya tampilkan jika ada dokter dan layanan aktif --}}
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
                        <script>
                            alert("{{ $error }}");
                            window.location.href = "{{ route('admin.layanan') }}";
                        </script>
                    @endif
                    @if ($sukses)
                        <script>
                            alert("{{ $sukses }}");
                            window.location.href = "{{ route('admin.layanan') }}";
                        </script>
                    @endif

                    <form action="{{ route('admin.layanan') }}" method="POST">
                        @csrf
                        {{-- Hidden input untuk menyimpan ID layanan saat mode edit --}}
                        @if($id_layanan)
                            <input type="hidden" name="id_layanan_edit" value="{{ $id_layanan }}">
                        @endif

                        <label for="nama_layanan">Nama Layanan</label>
                        <input type="text" name="nama_layanan" id="nama_layanan" value="{{ old('nama_layanan', $nama_layanan) }}" required>
                        @error('nama_layanan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="biaya_layanan">Biaya Layanan</label>
                        <input type="text" name="biaya_layanan" id="biaya_layanan" value="{{ old('biaya_layanan', $biaya) }}" required>
                        @error('biaya_layanan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <input type="submit" value="SUBMIT" name="submit">
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
                                <th scope="col">NO</th>
                                <th scope="col">Nama Layanan</th>
                                <th scope="col">Biaya Layanan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($layananData as $key => $data)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td scope="row" class="nowrap">{{ $data->nama_layanan }}</td>
                                    <td scope="row" class="nowrap">Rp. {{ number_format($data->biaya_layanan, 0, ',', '.') }}</td>
                                    <td scope="row" class="nowrap">
                                        @if($data->status == "Aktif")
                                            <a href="{{ route('admin.layanan', ['op' => 'status', 'id_layanan' => $data->id_layanan]) }}"><button type="button" id="button-hijau">Aktif</button></a>
                                        @else
                                            <a href="{{ route('admin.layanan', ['op' => 'status', 'id_layanan' => $data->id_layanan]) }}"><button type="button" id="button-merah">Non-Aktif</button></a>
                                        @endif
                                    </td>
                                    <td scope="row" class="nowrap">
                                        <a href="{{ route('admin.layanan', ['op' => 'edit', 'id_layanan' => $data->id_layanan]) }}"><button type="button" id="button-edit">Edit</button></a>
                                        <a href="{{ route('admin.layanan', ['op' => 'delete', 'id_layanan' => $data->id_layanan]) }}" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini??')"><button type="button" id="button-delete">Delete</button></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data layanan.</td>
                                </tr>
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
                <div class="header-actions">
                    <form id="searchForm" action="{{ route('admin.layanan') }}" method="GET" class="form-input">
                        <input type="search" name="searchInput" id="searchInput" placeholder="Search..." value="{{ request('searchInput') }}">
                        <button type="submit"><i class='bx bx-search' style="color:#FFFFFF"></i></button>
                    </form>
                    <div class="boxFilter">
                        <form action="{{ route('admin.layanan') }}" method="GET">
                            @if(request('searchInput'))
                                <input type="hidden" name="searchInput" value="{{ request('searchInput') }}">
                            @endif
                            <select id="filter" onchange="this.form.submit()" name="filter" style="width: 100%; padding: 5px; border: 1px solid; border-radius: 5px; font-size: 12px;">
                                <option value="">-- Pilih Hari --</option>
                                <option value="Senin" {{ request('filter') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa" {{ request('filter') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu" {{ request('filter') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis" {{ request('filter') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jumat" {{ request('filter') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                {{-- Tambahkan hari lain jika perlu --}}
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
                            <th scope="col">Nama Dokter</th>
                            <th scope="col">Nama Layanan</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Jam Mulai</th>
                            <th scope="col">Jam Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalDokterData as $key => $jadwal)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td scope="row">{{ $jadwal->dokter->nama_lengkap ?? 'N/A' }}</td>
                                <td scope="row">{{ $jadwal->dokter->layananDokter->nama_layanan ?? 'N/A' }}</td>
                                <td scope="row">{{ $jadwal->hari }}</td>
                                <td scope="row">{{ $jadwal->jam_mulai }}</td>
                                <td scope="row">{{ $jadwal->jam_selesai }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data jadwal dokter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection