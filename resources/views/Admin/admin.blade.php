@extends('layouts.Admin.admin')
@section('title', 'Data Admin')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>ADMIN</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.admin_index') }}">Admin</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('admin.admin_index') }}">Data Admin</a>
                </li>
            </ul>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-data">
        {{-- Form Tambah/Edit Admin --}}
        <div class="createData">
            <div class="head">
                <h3>
                    @if(isset($op) && $op == 'edit')
                        EDIT DATA ADMIN
                    @else
                        TAMBAH DATA ADMIN
                    @endif
                </h3>
            </div>
            <div class="body">
                {{-- Arahkan form ke route store untuk create, atau update untuk edit --}}
                <form action="{{ (isset($op) && $op == 'edit') ? route('admin.admin_update', $adminToEdit->id_admin) : route('admin.admin_store') }}" method="POST">
                    @csrf
                    @if(isset($op) && $op == 'edit')
                        @method('PUT')
                    @endif

                    {{-- Field username dan email hanya muncul saat mode 'create' --}}
                    @if(isset($op) && $op != 'edit')

                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username', $userToEdit->username ?? '') }}" required>
                            @error('username')<div class="text-danger">{{ $message }}</div>@enderror


                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $userToEdit->email ?? '') }}" required>
                            @error('email')<div class="text-danger">{{ $message }}</div>@enderror

                    @endif

                    {{-- Field password dan konfirmasi password --}}

                        <label for="password" class="form-label">Password</label>
                        {{-- Required hanya saat create, kosong saat edit (opsional) --}}
                        <input type="password" id="password" name="password" {{ (isset($op) && $op == 'create') ? 'required' : '' }}>
                        @if(isset($op) && $op == 'edit')
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                        @endif
                        @error('password')<div class="text-danger">{{ $message }}</div>@enderror

                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" {{ (isset($op) && $op == 'create') ? 'required' : '' }}>
                        @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror


                        <label for="nama_admin" class="form-label">Nama Admin</label>
                        <input type="text" name="nama_admin" id="nama_admin" value="{{ old('nama_admin', $adminToEdit->nama_admin ?? '') }}" required>
                        @error('nama_admin')<div class="text-danger">{{ $message }}</div>@enderror


                        <label for="noHP" class="form-label">No Hp</label>
                        <input type="text" name="noHP" id="noHP" value="{{ old('noHP', $adminToEdit->noHP ?? '') }}" required>
                        @error('noHP')<div class="text-danger">{{ $message }}</div>@enderror


                        <label for="role_admin" class="form-label">Role</label>
                        <select id="role_admin" name="role_admin" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ (old('role_admin', $adminToEdit->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
                            <option value="operator" {{ (old('role_admin', $adminToEdit->role ?? '') == 'operator') ? 'selected' : '' }}>Operator</option>
                        </select>
                        @error('role_admin')<div class="text-danger">{{ $message }}</div>@enderror
                    <br style="display-top: 10px">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                    <a href="{{ route('admin.admin_index') }}" class="btn btn-secondary">BATAL</a>
                </form>
            </div>
        </div>

        {{-- Tabel Data Admin: SELALU TAMPIL --}}
        <div class="showTable">
            <div class="head">
                <h3>DATA ADMIN</h3>
            </div>
            <div class="body">
                <table id="table-information">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Nama Admin</th>
                            <th scope="col">No Hp</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $adminItem)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $adminItem->nama_admin }}</td>
                                <td>{{ $adminItem->noHP }}</td>
                                <td>{{ $adminItem->role }}</td>
                                <td class="nowrap">
                                    <a href="{{ route('admin.admin_edit', $adminItem->id_admin) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.admin_destroy', $adminItem->id_admin) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data admin yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
