@extends('layouts.admin.admin') {{-- Asumsi Anda memiliki layout admin --}}

@section('title', 'Data Pasien')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>PASIEN</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('admin.pasien') }}">Data Pasien</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="createData">
            <div class="head">
                <h3>{{ (request('op') == 'edit' && $pasien) ? 'EDIT DATA PASIEN' : 'TAMBAH DATA PASIEN' }}</h3>
            </div>
            <div class="body">
                @if ($error)
                    <script>
                        alert("{{ $error }}");
                        window.location.href = "{{ route('admin.pasien') }}";
                    </script>
                @endif
                @if ($sukses)
                    <script>
                        alert("{{ $sukses }}");
                        window.location.href = "{{ route('admin.pasien') }}";
                    </script>
                @endif
                @if ($errors->any())
                    <script>
                        alert("Ada kesalahan input:\n@foreach ($errors->all() as $err)- {{ $err }}\n@endforeach");
                    </script>
                @endif

                <form action="{{ route('admin.pasien') }}{{ (request('op') == 'edit' && $pasien) ? '?op=edit&id_pasien=' . $pasien->id_pasien : '' }}" method="POST">
                    @csrf
                    @if(request('op') == 'edit' && $pasien)
                        {{-- Hidden input untuk menyimpan ID pasien saat mode edit --}}
                        <input type="hidden" name="id_pasien_edit" value="{{ $pasien->id_pasien }}">
                    @else
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required>
                        @error('username') <div class="text-danger">{{ $message }}</div> @enderror

                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror

                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        @error('password') <div class="text-danger">{{ $message }}</div> @enderror

                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    @endif

                    <label for="nama_panggilan">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" id="nama_panggilan" value="{{ old('nama_panggilan', $pasien->nama_panggilan ?? '') }}" required>
                    @error('nama_panggilan') <div class="text-danger">{{ $message }}</div> @enderror

                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $pasien->nama_lengkap ?? '') }}" required>
                    @error('nama_lengkap') <div class="text-danger">{{ $message }}</div> @enderror

                    <label for="umur">Umur</label>
                    <input type="number" name="umur" id="umur" value="{{ old('umur', $pasien->umur ?? '') }}" required>
                    @error('umur') <div class="text-danger">{{ $message }}</div> @enderror

                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $pasien->alamat ?? '') }}" required>
                    @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror

                    <label for="noHp">No Hp</label>
                    <input type="text" name="noHp" id="noHp" value="{{ old('noHp', $pasien->noHp ?? '') }}" required>
                    @error('noHp') <div class="text-danger">{{ $message }}</div> @enderror
                    
                    <input type="submit" value="SUBMIT" name="submit">
                </form>
            </div>
        </div>
        <div class="showTable">
            <div class="head" style="display:block">
                <h3>DATA PASIEN</h3>
                <div class="header-actions"> {{-- Gabungkan search dan filter --}}
                    <form id="searchForm" action="{{ route('admin.pasien') }}" method="GET" class="form-input">
                        <input type="search" name="searchInput" id="searchInput" placeholder="Search..." value="{{ request('searchInput') }}">
                        <button type="submit"><i class='bx bx-search' style="color:#FFFFFF"></i></button>
                    </form>
                    <div class="boxFilter">
                        <form action="{{ route('admin.pasien') }}" method="GET">
                            @if(request('searchInput'))
                                <input type="hidden" name="searchInput" value="{{ request('searchInput') }}">
                            @endif
                            <select id="filter" onchange="this.form.submit()" name="filter" style="width: 100%; padding: 5px; border: 1px solid; border-radius: 5px; font-size: 12px;">
                                <option value="" style="text-align: center;">-- Pilih Status Konsultasi --</option>
                                <option value="Ada" {{ request('filter') == 'Ada' ? 'selected' : '' }}>Ada Konsultasi Berlangsung/Belum</option>
                                <option value="Tidak Ada" {{ request('filter') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada Konsultasi Berlangsung/Belum</option>
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
                            <th scope="col">Nama Panggilan</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Umur</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No Hp</th>
                            <th scope="col">Konsultasi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasienData as $key => $data)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td scope="row">{{ $data->nama_panggilan }}</td>
                                <td scope="row" class="nowrap">{{ $data->nama_lengkap }}</td>
                                <td scope="row">{{ $data->umur }}</td>
                                <td scope="row">{{ $data->alamat }}</td>
                                <td scope="row">{{ $data->noHp }}</td>
                                <td scope="row">
                                    {{-- Cek status konsultasi terbaru --}}
                                    @php
                                        $konsultasiStatus = 'Tidak Ada';
                                        if ($data->latestKonsultasi) {
                                            if (in_array($data->latestKonsultasi->status, ['Belum', 'Sedang Konsultasi'])) {
                                                $konsultasiStatus = 'Ada';
                                            }
                                        }
                                    @endphp
                                    {{ $konsultasiStatus }}
                                </td>
                                <td scope="row" class="nowrap" >
                                    <a href="{{ route('admin.pasien', ['op' => 'edit', 'id_pasien' => $data->id_pasien]) }}"><button type="button" id="button-edit">Edit</button></a>
                                    <a href="{{ route('admin.pasien', ['op' => 'delete', 'id_pasien' => $data->id_pasien]) }}" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini??')"><button type="button" id="button-delete">Delete</button></a>       
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center;">Tidak ada data pasien.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection