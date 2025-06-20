@extends('layouts.Admin.admin') 
 
@section('title', (isset($op) && $op == 'edit') ? 'Edit Data Admin' : 'Tambah Data Admin')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>ADMIN</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="{{ route('admin.admin_index') }}">Data Admin</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">{{ (isset($op) && $op == 'edit') ? 'Edit Admin' : 'Tambah Admin' }}</a>
                </li>
            </ul>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>{{ (isset($op) && $op == 'edit') ? 'EDIT DATA ADMIN' : 'TAMBAH DATA ADMIN' }}</h3>
            </div>
            <div class="body">
                <form action="{{ (isset($op) && $op == 'edit') ? route('admin.admin_update', $id_admin) : route('admin.admin_store') }}" method="POST">
                    @csrf
                    @if(isset($op) && $op == 'edit')
                        @method('PUT') {{-- Gunakan PUT untuk update --}}
                    @endif

                    @if(!isset($op) || $op !== 'edit') {{-- Tampilkan hanya jika mode tambah --}}
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="{{ old('username', $user->username ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" {{ (isset($op) && $op == 'edit') ? '' : 'required' }}>
                            @if(isset($op) && $op == 'edit')
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                            @endif
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="nama_admin" class="form-label">Nama Admin</label>
                        <input type="text" class="form-control" name="nama_admin" id="nama_admin" value="{{ old('nama_admin', $admin->nama_admin ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="noHp" class="form-label">No Hp</label>
                        <input type="text" class="form-control" name="noHp" id="noHp" value="{{ old('noHp', $admin->noHp ?? '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="role_admin" class="form-label">Role</label>
                        <select id="role_admin" name="role_admin" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ (old('role_admin', $admin->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
                            <option value="operator" {{ (old('role_admin', $admin->role ?? '') == 'operator') ? 'selected' : '' }}>Operator</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
@endsection