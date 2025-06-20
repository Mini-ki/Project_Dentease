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
                <h3>{{ isset($dokter) ? 'EDIT DATA DOKTER' : 'TAMBAH DATA DOKTER' }}</h3>
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

                <form action="{{ isset($dokter) ? route('admin.dokter.update', $dokter->id_dokter) : route('admin.dokter.store') }}" method="POST">
                    @csrf
                    @if(isset($dokter))
                        @method('PUT')
                    @endif

                    @if(!isset($dokter))
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
@endsection

@section('scripts')
    <script src="{{ asset('asset/js/main.js') }}"></script>
@endsection