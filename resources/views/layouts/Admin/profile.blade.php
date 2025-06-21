@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($admin) ? 'Edit Admin' : 'Tambah Admin' }}</h2>

    <form method="POST" action="{{ isset($admin) ? route('admin_update', $admin->id_admin) : route('admin_store') }}">
        @csrf
        @if(isset($admin))
            @method('PUT')
        @endif

        @if(!isset($admin))
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        @endif

        <div class="mb-3">
            <label>Nama Admin</label>
            <input type="text" name="nama_admin" class="form-control" value="{{ $admin->nama_admin ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="noHp" class="form-control" value="{{ $admin->noHp ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role_admin" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ (isset($admin) && $admin->role == 'admin') ? 'selected' : '' }}>Admin</option>
                <option value="operator" {{ (isset($admin) && $admin->role == 'operator') ? 'selected' : '' }}>Operator</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
