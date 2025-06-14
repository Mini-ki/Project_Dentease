@extends('layouts.Admin.admin')

@section('title', isset($admin) ? 'Edit Admin' : 'Tambah Admin')

@section('content')
<main>
    <div class="head-title">
        <div class="left">
            <h1>{{ isset($admin) ? 'EDIT ADMIN' : 'TAMBAH ADMIN' }}</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.index') }}">Admin</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active">{{ isset($admin) ? 'Edit' : 'Tambah' }}</a></li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="createData">
            <div class="head">
                <h3>{{ isset($admin) ? 'Edit Data Admin' : 'Tambah Data Admin' }}</h3>
            </div>
            <div class="body">
                <form method="POST" action="{{ isset($admin) ? route('admin.update', $admin->id_admin) : route('admin.store') }}">
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
                        <input type="text" name="nama_admin" value="{{ $admin->nama_admin ?? '' }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" name="noHp" value="{{ $admin->noHp ?? '' }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role_admin" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ (isset($admin) && $admin->role == 'admin') ? 'selected' : '' }}>Admin</option>
                            <option value="operator" {{ (isset($admin) && $admin->role == 'operator') ? 'selected' : '' }}>Operator</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">{{ isset($admin) ? 'Update' : 'Simpan' }}</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
