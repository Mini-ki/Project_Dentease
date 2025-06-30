@extends('layouts.pasien.pasien')

@section('title', 'Konsultasi')

@section('additional-css')
<link rel="stylesheet" href="{{ asset('css/pasien/stylesJadwal.css') }}">
<link rel="stylesheet" href="{{ asset('css/pasien/konsultasi.css') }}">
<style>
    .rekam-medis-modal-content p {
        margin-bottom: 0.5rem;
    }
    .rekam-medis-modal-content strong {
        color: #002A8C; 
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/AllJava.js') }}"></script>
<script src="{{ asset('js/rating.js') }}"></script>
@endsection

@section('banner-title', 'Konsultasi')
@section('banner-description', 'Lihat janji konsultasi yang telah Anda buat!')

@section('content')
<main class="container my-5">
    <h2 class="mb-4 text-center" style="font-family: 'Oswald', sans-serif;">Daftar Janji Temu Anda</h2>

    @if ($konsultasiList->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            Anda belum membuat janji temu.
        </div>
    @else
    <div class="table-responsive">
        <table class="table custom-table align-middle">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Rekam Medis</th> {{-- KOLOM BARU --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($konsultasiList as $k)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($k->tanggal_konsultasi)->format('d-m-Y') }}</td>
                        <td>{{ $k->nama_panggilan }}</td>
                        <td>{{ $k->nama_layanan }}</td>
                        <td>
                            <span class="badge {{ $k->status === 'Sudah Selesai' ? 'bg-success' : 'bg-warning text-light' }}">
                                {{ $k->status }}
                            </span>
                        </td>
                        <td>
                            @if ($k->status === 'Sudah Selesai')
                                @if ($k->rating !== null)
                                    @php
                                        $fullStars = floor($k->rating);
                                        $halfStar = ($k->rating - $fullStars) >= 0.5 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                    @endphp
                                    <div class="star-rating mb-1" style="font-size: 1.5rem; color: #FFD700;">
                                        {!! str_repeat('★', $fullStars) . str_repeat('⯪', $halfStar) . str_repeat('☆', $emptyStars) !!}
                                    </div>
                                    <button class="btn btn-sm btn-info"
                                        onclick="showDetailModal('{{ $k->id_konsultasi }}', '{{ $k->rating }}', '{{ json_encode($k->ulasan) }}')"
                                        style="color: #002A8C; background-color: #F1F5F9;">
                                        Lihat Detail
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-success mt-2"
                                        onclick="openRatingModal('{{ $k->id_konsultasi }}')"
                                        style="color: #002A8C; background-color: #F1F5F9;">
                                        Beri Rating
                                    </button>
                                @endif
                            @else
                                <span class="text-muted">Belum selesai</span>
                            @endif
                        </td>
                        {{-- KOLOM BARU UNTUK REKAM MEDIS --}}
                        <td>
                            @if ($k->rekamMedis)
                                <button class="btn btn-sm btn-primary"
                                    onclick="showRekamMedisModal('{{ json_encode($k->rekamMedis) }}')"
                                    style="background-color: #F1F5F9; color: #002A8C; "> 
                                    Lihat Rekam Medis
                                </button>
                            @else
                                <span class="text-muted">Belum tersedia</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- MODAL: Detail Rating & Ulasan (yang sudah ada) --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Rating & Ulasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="detailStars" class="mb-3 fs-3" style="color: #FFD700;"></div>
                    <textarea id="detailUlasan" class="form-control" rows="5" readonly></textarea>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="detailIdKonsultasi">
                    <button class="btn btn-danger" id="btnDeleteRating">Hapus</button>
                    <button class="btn btn-primary" id="btnUpdateRating" style="background-color: #002A8C;">Update</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Beri/Ubah Rating (yang sudah ada) --}}
    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('pasien.konsultasi.storeRating') }}" class="modal-content" id="ratingForm">
                @csrf
                <input type="hidden" name="id_konsultasi" id="modalIdKonsultasi">
                <input type="hidden" name="rating" id="modalRating" value="0">
                <div class="modal-header">
                    <h5 class="modal-title">Beri Rating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="starsContainer" class="mb-3 fs-3" style="color: #FFD700; user-select:none;"></div>
                    <textarea name="ulasan" class="form-control" rows="4" placeholder="Tulis ulasan... (opsional)" id="modalUlasanTextarea"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" style="background-color: #002A8C;">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: Konfirmasi Hapus Rating (yang sudah ada) --}}
    <div class="modal fade" id="deleteConfirm" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('pasien.konsultasi.deleteRating') }}" class="modal-content">
                @csrf
                <input type="hidden" name="id_konsultasi" id="deleteKonsultasiId">
                <input type="hidden" name="deleteRating" value="1">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Rating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus rating ini?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Ya, Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    ---

    {{-- MODAL BARU: Detail Rekam Medis --}}
    <div class="modal fade" id="rekamMedisModal" tabindex="-1" aria-labelledby="rekamMedisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rekam-medis-modal-content">
                <div class="modal-header" style="background-color: #002A8C; color: white;">
                    <h5 class="modal-title" id="rekamMedisModalLabel">Detail Rekam Medis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Tanggal Konsultasi:</strong> <span id="rmTanggal"></span></p>
                    <p><strong>Diagnosa:</strong> <span id="rmDiagnosa"></span></p>
                    <p><strong>Tindakan:</strong> <span id="rmTindakan"></span></p>
                    <p><strong>Obat:</strong> <span id="rmObat"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection