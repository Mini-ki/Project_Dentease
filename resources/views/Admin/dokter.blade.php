@extends('layouts.admin.admin')

@section('title', 'Data Dokter')

@section('content')
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
                <h3>
                    @if(isset($op) && $op == 'edit')
                        EDIT DATA DOKTER
                    @else
                        TAMBAH DATA DOKTER
                    @endif
                </h3>
            </div>
            <div class="body">
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($op) && $op == 'edit' ? route('admin.dokter.update', $doktertoEdit->id_dokter) : route('admin.dokter.store') }}" method="POST">
                    @csrf
                    @if(isset($op) && $op == 'edit')
                        @method('PUT')
                    @endif

                    @if(isset($op) && $op != 'edit')
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username', $userToEdit->username ?? '') }}" required>
                        @error('username')<div class="text-danger">{{ $message }}</div>@enderror

                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $userToEdit->email ?? '') }}" required>
                        @error('email')<div class="text-danger">{{ $message }}</div>@enderror

                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" {{ (isset($op) && $op == 'create') ? 'required' : '' }}>
                        @error('password')<div class="text-danger">{{ $message }}</div>@enderror

                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" {{ (isset($op) && $op == 'create') ? 'required' : '' }}>
                        @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror
                    @endif

                    <label for="nama_panggilan">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" id="nama_panggilan" value="{{ old('nama_panggilan', $doktertoEdit->nama_panggilan ?? '') }}">

                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $doktertoEdit->nama_lengkap ?? '') }}">

                    <label for="umur">Umur</label>
                    <input type="text" name="umur" id="umur" value="{{ old('umur', $doktertoEdit->umur ?? '') }}">

                    <label for="spesialis">Spesialis</label>
                    <input type="text" name="spesialis" id="spesialis" value="{{ old('spesialis', $doktertoEdit->spesialis ?? '') }}">

                    <label for="layanan">Layanan</label>
                    <select id="layanan" name="layanan" style="width: 100%; padding: 10px; border: 1px solid; border-radius: 5px;">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($layanans as $layanan)
                            <option value="{{ $layanan->nama_layanan }}"
                                {{ (isset($doktertoEdit) && $doktertoEdit->id_layanan == $layanan->id_layanan) || old('layanan') == $layanan->nama_layanan ? 'selected' : '' }}>
                                {{ $layanan->nama_layanan }}
                            </option>
                        @endforeach
                    </select>

                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $doktertoEdit->alamat ?? '') }}">

                    <input type="submit" value="SUBMIT" name="submit">
                </form>
            </div>
        </div>
        <div class="showTable">
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
            <table id="table-information">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Panggilan</th>
                        <th>Nama Lengkap</th>
                        <th>Umur</th>
                        <th>Spesialis</th>
                        <th>Alamat</th>
                        <th>Rating</th>
                        @if(Auth::check() && (Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin'))
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
                            @if(Auth::check() && (Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin'))
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
@endsection
