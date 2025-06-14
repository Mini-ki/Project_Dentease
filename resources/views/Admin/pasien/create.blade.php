@extends('layouts.Admin.admin')
@section('title', 'Tambah Pasien')
@section('content')
<div class="container">
    <h1>Tambah Pasien</h1>

    <form action="{{ route('pasien.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nama_panggilan">Nama Panggilan</label>
            <input type="text" name="nama_panggilan" id="nama_panggilan" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="umur">Umur</label>
            <input type="number" name="umur" id="umur" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="noHp">No Hp</label>
            <input type="text" name="noHp" id="noHp" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection