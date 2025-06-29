@extends('layouts.admin.admin')

@section('title', 'Data Pasien')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>PASIEN</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('admin.pasien.index') }}">Data Pasien</a></li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="createData">
            <div class="head">
                <h3>{{ isset($editMode) && $editMode ? 'EDIT DATA PASIEN' : 'TAMBAH DATA PASIEN' }}</h3>
            </div>
            <div class="body">
                @if (session('error'))
                    <script>
                        alert("{{ session('error') }}");
                        window.location.href = "{{ route('admin.pasien.index') }}";
                    </script>
                @endif
                @if (session('sukses'))
                    <script>
                        alert("{{ session('sukses') }}");
                        window.location.href = "{{ route('admin.pasien.index') }}";
                    </script>
                @endif
                @if ($errors->any())
                    <script>
                        alert("Ada kesalahan input:\n@foreach ($errors->all() as $err)- {{ $err }}\n@endforeach");
                    </script>
                @endif

                <form action="{{ isset($op) && $op == 'edit' ? route('admin.pasien.update', $pasien->id_pasien) : route('admin.pasien.store') }}" method="POST">
                    @csrf
                    @if(isset($op) && $op == 'edit')
                        @method('PUT')
                    @endif

                    @if(isset($op) && $op == 'create')
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required>

                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>

                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    @endif

                    <label for="nama_panggilan">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" id="nama_panggilan" value="{{ old('nama_panggilan', $pasien->nama_panggilan ?? '') }}" required>

                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $pasien->nama_lengkap ?? '') }}" required>

                    <label for="umur">Umur</label>
                    <input type="number" name="umur" id="umur" value="{{ old('umur', $pasien->umur ?? '') }}" required>

                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $pasien->alamat ?? '') }}" required>

                    <label for="noHp">No Hp</label>
                    <input type="text" name="noHp" id="noHp" value="{{ old('noHp', $pasien->noHp ?? '') }}" required>

                    <input type="submit" value="SUBMIT" name="submit">
                </form>
            </div>
        </div>
        <div class="showTable">
            <div class="head" style="display:block">
                <h3>DATA PASIEN</h3>
                <div class="header-actions">
                    <form id="searchForm" action="{{ route('admin.pasien.index') }}" method="GET">
                        <div class="form-input">
                            <input type="search" name="searchInput" id="searchInput" placeholder="Search..." value="{{ request('searchInput') }}">
                            <button type="submit"><i class='bx bx-search' style="color:#FFFFFF"></i></button>
                        </div>
                    </form>
                    <div class="boxFilter">
                        <form action="{{ route('admin.pasien.index') }}" method="GET">
                            @if(request('searchInput'))
                                <input type="hidden" name="searchInput" value="{{ request('searchInput') }}">
                            @endif
                            <select id="filter" onchange="this.form.submit()" name="filter">
                                <option value="">-- Pilih Status Konsultasi --</option>
                                <option value="Ada" {{ request('filter') == 'Ada' ? 'selected' : '' }}>Ada Konsultasi</option>
                                <option value="Tidak Ada" {{ request('filter') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada Konsultasi</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="body">
                <table id="table-information">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Panggilan</th>
                            <th>Nama Lengkap</th>
                            <th>Umur</th>
                            <th>Alamat</th>
                            <th>No Hp</th>
                            <th>Konsultasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasienData as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $data->nama_panggilan }}</td>
                                <td>{{ $data->nama_lengkap }}</td>
                                <td>{{ $data->umur }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->noHp }}</td>
                                <td>
                                    @php
                                        $status = 'Tidak Ada';
                                        if ($data->latestKonsultasi && in_array($data->latestKonsultasi->status, ['Belum', 'Sedang Konsultasi'])) {
                                            $status = 'Ada';
                                        }
                                    @endphp
                                    {{ $status }}
                                </td>
                                <td class="nowrap">
                                    <a href="{{ route('admin.pasien.edit', $data->id_pasien) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.pasien.destroy', $data->id_pasien) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" style="text-align:center;">Tidak ada data pasien.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
