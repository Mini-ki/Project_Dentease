@extends('layouts.admin.admin') 
@section('title', 'Data Admin')

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
                    <a class="active" href="{{ route('admin.admin_index') }}">Data Admin</a>
                </li>
            </ul>
        </div>
        <div class="right">
            <a href="{{ route('admin.admin_create') }}" class="btn-download">
                <i class='bx bxs-add-to-queue'></i>
                <span class="text">Tambah Admin Baru</span>
            </a>
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

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>DATA ADMIN</h3>
            </div>
            <div class="body">
                <table>
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
                        @foreach($admins as $admin)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $admin->nama_admin }}</td>
                                <td>{{ $admin->noHp }}</td>
                                <td>{{ $admin->role }}</td>
                                <td class="nowrap">
                                    <a href="{{ route('admin.admin_edit', $admin->id_admin) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.admin_destroy', $admin->id_admin) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection