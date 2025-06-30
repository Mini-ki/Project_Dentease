@extends('layouts.pasien.pasien')

@section('title', 'Jadwal Dokter')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/pasien/stylesJadwal.css') }}">
@endsection

@section('banner-title', 'Jadwal')
@section('banner-description', 'Jadwal praktik dokter-dokter kami.')

@section('content')
<div class="container">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Dokter</th>
                    <th>Layanan</th>
                    @foreach ($hariList as $hari)
                        <th>{{ $hari }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalPerDokter as $dokter)
                    <tr>
                        <td>{{ $dokter['nama'] }}</td>
                        <td>{{ $dokter['layanan'] }}</td>
                        @foreach ($hariList as $hari)
                            @php
                                $jam = $dokter['jadwal'][$hari] ?? '-';
                            @endphp
                            <td class="{{ $jam === '-' ? 'empty' : '' }}">{{ $jam }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="display: flex; justify-content: center; margin-top: 20px;">
        <a href="{{ route('pasien.homepage') }}" class="btn btn-primary" style="background-color: #002A8C; border: none; width: 200px;">
            Kembali
        </a>
    </div>
    <hr style="margin-top: 80px; margin-bottom: 80px;">
    <h1 style="font-family: 'Oswald', sans-serif; color:#002A8C; text-align: center;">Ayo buat janji temu dengan dokter-dokter terbaik kami.</h1>
    <img src="{{ asset('img/ilustrasi3.jpg') }}" alt="janji temu" style="width: 40%">
    <p style="font-family: 'Barlow', sans-serif; margin-left: 200px; margin-right: 200px;">
        Kesehatan gigi dan mulut Anda sangat penting! Jangan menunggu hingga masalah gigi 
        menjadi lebih serius. Kami mengundang Anda untuk membuat janji temu dengan dokter 
        gigi kami agar bisa mendapatkan perawatan yang tepat dan terbaik untuk kebutuhan Anda.</p>
    <div style="display: flex; justify-content: center; margin-top: 20px;">
        <a href="{{ route('pasien.janji') }}" class="btn btn-primary" style="background-color: #002A8C; border: none; width: 200px;">
            Buat Janji Temu
        </a>
    </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/AllJava.js') }}"></script>
@endsection
