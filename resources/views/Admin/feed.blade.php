@extends('layouts.Admin.admin')
@section('title', 'Feed')

@section('content')
<h1>Data Feed</h1>
@if(session('success'))
    <div>{{ session('success') }}</div>
@endif
<a href="{{ route('admin.feed.create') }}">Tambah Feed</a>
<table border="1" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul Feed</th>
            <th>Deskripsi</th>
            <th>Gambar</th>
            <th>Admin</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($feeds as $key => $feed)
        <tr>
            <td>{{ $feeds->firstItem() + $key }}</td>
            <td>{{ $feed->judul_feed }}</td>
            <td>{{ Str::limit($feed->deskripsi, 20, '...') }}</td>
            <td>
                @if($feed->image)
                    <img src="{{ asset('storage/uploads/feed/' . $feed->image) }}" alt="" style="width:100px;">
                @endif
            </td>
            <td>{{ $feed->admin->nama_admin ?? '-' }}</td>
            <td>{{ $feed->created_at }}</td>
            <td>{{ $feed->updated_at }}</td>
            <td>
                <a href="{{ route('admin.feed.edit', $feed) }}">Edit</a>
                <form action="{{ route('admin.feed.destroy', $feed) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color:red">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $feeds->links() }}

@endsection
