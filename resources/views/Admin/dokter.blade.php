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
        {{-- Tombol Tambah Data hanya untuk super_admin dan admin --}}
        @if(Auth::check() && (Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin'))
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