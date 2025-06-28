@extends('layouts.admin.admin')

@section('title', 'Feed Management')

@section('page_title', 'FEED')
@section('breadcrumb_parent', 'Feed')
@section('breadcrumb_child', 'Data Feed')

@section('content')
<div class="table-data">
    <div class="createData">
        <div class="head">
            <h3>
                @if(isset($op) && $op == 'edit')
                    EDIT DATA FEED
                @else
                    TAMBAH DATA FEED
                @endif
            </h3>
        </div>
        <div class="body">
            <form action="{{ (isset($op) && $op == 'edit') ? route('admin.feed.update', $feedtoEdit->id_feed) : route('admin.feed.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($op) && $op == 'edit')
                    @method('PUT')
                @endif

                <label for="judul_feed">Judul Feed</label>
                <input type="text" name="judul_feed" id="judul_feed" value="{{ old('judul_feed', $feedtoEdit->judul_feed  ?? '') }}">
                @error('judul_feed')
                    <p style="color: red;">{{ $message }}</p>
                @enderror

                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" style="width:100%; padding:10px; border: 1px solid; border-radius: 5px;">{{ old('deskripsi', $feedtoEdit->deskripsi ?? '')}}</textarea>
                @error('deskripsi')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
                <br>

                <label for="image">Pilih Gambar</label>
                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                @error('image')
                    <p style="color: red;">{{ $message }}</p>
                @enderror

                <input type="submit" value="SUBMIT" name="submit">
            </form>
        </div>
    </div>
    <div class="showTable">
        <div class="head">
            <h3>DATA FEED</h3>
        </div>
        <div class="body">
            <table id="table-information">
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Judul Feed</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Gambar Feed</th>
                        <th scope="col">Admin</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Update At</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feeds as $feed)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td scope="row">{{ $feed->judul_feed }}</td>
                        <td scope="row">{{ Str::limit($feed->deskripsi, 20) }}</td>
                        <td scope="row">
                            @php
                                $decodedPath = base64_decode($feed->image);
                                $imagePath = 'storage/' . $decodedPath;
                            @endphp
                            @if($feed->image)
                                <img src="{{ asset($imagePath) }}" alt="{{ $feed->judul_feed }}" style="width:100px; height:auto;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td scope="row">{{ $feed->admin->nama_admin ?? 'N/A' }}</td>
                        <td scope="row">{{ $feed->created_at->format('Y-m-d H:i:s') }}</td>
                        <td scope="row">{{ $feed->update_at->format('Y-m-d H:i:s') }}</td>
                        <td scope="row" class="nowrap">
                            <a href="{{ route('admin.feed.edit', $feed->id_feed) }}"><button type="button" id="button-edit">Edit</button></a>
                            <form action="{{ route('admin.feed.destroy', $feed->id_feed) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="button-delete" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini??')">Delete</button>
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
