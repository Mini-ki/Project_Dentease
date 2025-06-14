@extends('layouts.pasien.pasien')

@section('title', 'Jadwal Dokter')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/stylesJadwal.css') }}">
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

    <a href="{{ route('pasien.homepage') }}" class="btn btn-secondary">Kembali</a>
    <hr style="margin-top: 80px">
    <h1>Ayo buat janji temu dengan dokter-dokter terbaik kami.</h1>
    <img src="{{ asset('assets/img/ilustrasi3.jpg') }}" alt="janji temu" style="width: 40%">
    <p>Kesehatan gigi dan mulut Anda sangat penting! ...</p>
    <a href="{{ route('pasien.janji') }}" class="btn btn-primary">Buat Janji Temu</a>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/AllJava.js') }}"></script>
@endsection
