@extends('layouts.dokter.dokter') 

@section('title', 'Janji Temu Dokter') 

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Janji Temu</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('dokter.janjitemu') }}">Janji Temu</a></li>
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pasien</th>
                <th>Tanggal</th>
                <th>Keluhan</th>
                <th>Status</th> {{-- Tambahkan kolom status --}}
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($konsultasi as $data)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $data->pasien->nama_lengkap }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_konsultasi)->format('d M Y') }}</td>
                    <td>{{ $data->keluhan }}</td>
                    <td>{{ $data->status }}</td> {{-- Tampilkan status --}}
                    <td>
                        @if ($data->status == 'Belum' || $data->status == 'Sedang Konsultasi')
                            <form action="{{ route('dokter.janjitemu.selesaikan') }}" method="POST" onsubmit="return confirm('Tandai konsultasi ini sebagai selesai?');">
                                @csrf {{-- Token CSRF untuk keamanan --}}
                                @method('PUT') {{-- Menggunakan method PUT untuk update --}}
                                <input type="hidden" name="id_konsultasi" value="{{ $data->id_konsultasi }}">
                                <button type="submit" id="button-selesai" style="background-color: #28a745; color: white; padding: 8px 12px; border-radius: 4px; border: none; cursor: pointer;">Selesai</button>
                            </form>
                        @else
                            <span style="color: grey;">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada janji temu yang menunggu atau sedang berjalan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

{{-- Jika ada script JS terpisah untuk ini, bisa ditambahkan di section scripts --}}
{{-- @section('scripts')
    <script src="{{ asset('assets/js/your_janji_temu_script.js') }}"></script>
@endsection --}}