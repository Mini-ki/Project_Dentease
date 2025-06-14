@extends('layouts.Admin.admin')
@section('title', 'Edit Pasien')
@section('content')
<div class="container">
    <h1>Edit Pasien</h1>

    <form action="{{ route('pasien.update', $pasien->id_pasien) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_panggilan">Nama Panggilan</label>
            <input type="text" name="nama_panggilan" id="nama_panggilan" class="form-control" value="{{ $pasien->nama_panggilan }}" required>
        </div>
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ $pasien->nama_lengkap }}" required>
        </div>
        <div class="form-group">
            <label for="umur">Umur</label>
            <input type="number" name="umur" id="umur" class="form-control" value="{{ $pasien->umur }}" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $pasien->alamat }}" required>
        </div>
        <div class="form-group">
            <label for="noHp">No Hp</label>
            <input type="text" name="noHp" id="noHp" class="form-control" value="{{ $pasien->noHp }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection