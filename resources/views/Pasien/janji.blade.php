@extends('layouts.pasien.pasien')

@section('title', 'Buat Janji Temu')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/stylesJanji.css') }}">
@endsection

@section('banner-title', 'Janji Temu')
@section('banner-description', 'Janji temu dengan dokter kami untuk konsultasi dan perawatan gigi.')

@section('content')
<br>
<div class="containerIl">
    <img src="{{ asset('/img/ilustrasi2.jpg') }}" alt="Dentease img">
    <div class="text">
        <br><br><br>
        <h1 style="font-family: 'Oswald', sans-serif;">Form janji temu</h1>
        <p style="font-family: 'Barlow', sans-serif; font-size: 15px;">
            Halo sobat gigi! Silakan isi formulir di bawah ini untuk membuat janji temu dengan dokter kami.
        </p>
    </div>
</div>

<div class="container">
    <form action="{{ route('pasien.janji.store') }}" method="POST" id="form">
        @csrf

        <div class="row">
            <div class="col-25"><label for="dokter">Pilih Dokter</label></div>
            <div class="col-75">
                <select id="dokter" name="id_dokter" required>
                    <option value="">Pilih Dokter</option>
                    @foreach($dokterList as $dokter)
                        <option value="{{ $dokter->id_dokter }}">
                            {{ $dokter->nama_lengkap }} - {{ $dokter->nama_layanan }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-25"><label for="keluhan">Keluhan</label></div>
            <div class="col-75">
                <textarea id="keluhan" name="keluhan" placeholder="Tuliskan keluhan jika ada.." style="height:200px">{{ old('keluhan') }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-25"><label for="tanggalJanji">Tanggal</label></div>
            <div class="col-75">
                <input type="date" id="tanggalJanji" name="tanggalJanji" 
                       min="{{ \Carbon\Carbon::now()->addDays(2)->toDateString() }}" required>
            </div>
        </div>

        <div class="d-flex flex-column gap-2 mt-4">
            <a href="{{ route('pasien.homepage') }}" class="btn btn-secondary">Kembali</a>
            <input type="submit" value="Submit">
        </div>
    </form>
</div>
<br>
@endsection
@section('scripts')
    <script src="{{ asset('js/form.js') }}"></script>
    <script src="{{ asset('js/AllJava.js') }}"></script>
@endsection
    
    