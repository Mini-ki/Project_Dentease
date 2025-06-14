@extends('layouts.admin.admin')

@section('title', 'Edit Feed')
@section('page_title', 'FEED')
@section('breadcrumb_parent', 'Feed')
@section('breadcrumb_child', 'Edit Feed')

@section('content')
<div class="table-data">
    <div class="createData">
        <div class="head">
            <h3>EDIT FEED</h3>
        </div>
        <div class="body">
            <form action="{{ route('admin.feed.update', $feed->id_feed) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="judul_feed">Judul Feed</label>
                <input type="text" name="judul_feed" id="judul_feed" value="{{ old('judul_feed', $feed->judul_feed) }}">
                @error('judul_feed')
                    <p style="color: red;">{{ $message }}</p>
                @enderror

                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" style="width:100%; padding:10px; border: 1px solid; border-radius: 5px;">{{ old('deskripsi', $feed->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
                <br>
        
                <label for="image_file">Pilih Gambar (Biarkan kosong jika tidak ingin mengubah)</label>
                <input type="file" name="image_file" id="image_file" accept="image/*">
                @error('image_file')
                    <p style="color: red;">{{ $message }}</p>
                @enderror

                @if($feed->image)
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/img/uploads/feed/' . $feed->image) }}" alt="{{ $feed->judul_feed }}" style="width:150px; height:auto; margin-top: 10px;">
                @endif
                
                <input type="submit" value="UPDATE" name="submit">
            </form>
        </div>
    </div>
</div>
@endsection