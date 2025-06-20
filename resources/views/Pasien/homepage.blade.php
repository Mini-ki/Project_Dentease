@extends('layouts.pasien.homepage')

@section('title', 'Dentease')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/stylesJadwal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylesHomepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/grid.css') }}">
@endsection

@section('content')
    <div class="container" style="top: 100px; margin-bottom: 180px;">
        <div class="text-container">
            <h1 style="left: 5px;"><b>Klinik Kesehatan Gigi</b></h1>
            <p>
                Sistem informasi manajemen klinik kesehatan gigi terbaik di kelas Pemweb-D angkatan 2023.
            </p>
        </div>
        
        <img src="{{ asset('img/doc9.jpg') }}">
    </div>

    <div class="grid-container">
        @if ($artikel->isNotEmpty())
            @foreach ($artikel as $artikelItem)
                @php
                    $imagePath = 'img/uploads/feed/' . $artikelItem->image;
                    $tanggal = date('j F Y', strtotime($artikelItem->update_at ?: $artikelItem->created_at));
                @endphp
                <div class="card">
                    <div class="card-image" style="background-image: url('{{ asset($imagePath) }}');"></div>
                    <h4>{{ htmlspecialchars($artikelItem->judul_feed) }}</h4>
                    <p><i>Ditulis oleh: <strong>Admin</strong> | Terbit {{ $tanggal }}</i></p>
                    <p>{{ htmlspecialchars($artikelItem->summary) }}...</p>
                    <!-- Button buat modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#artikelModal{{ $artikelItem->id }}">
                        Baca Artikel
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="artikelModal{{ $artikelItem->id }}" tabindex="-1" aria-labelledby="artikelModalLabel{{ $artikelItem->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="artikelModalLabel{{ $artikelItem->id }}">{{ htmlspecialchars($artikelItem->judul_feed) }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{ asset($imagePath) }}" class="img-fluid" alt="{{ htmlspecialchars($artikelItem->judul_feed) }}">
                                    <p class="mt-3">{{ htmlspecialchars($artikelItem->deskripsi) }}</p> 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p style="text-align:center;">Belum ada artikel yang tersedia.</p>
        @endif
    </div>

    <div class="container" style="margin-top: 100px;">
        <img src="{{ asset('/img/doc2.jpg') }}" alt="About Us">
        <div class="text">
            <h1 style="font-family: 'Oswald', sans-serif; color: #002A8C;"> About Us </h1>
            <p style="font-family: 'Barlow', sans-serif; font-size: 1.1rem;">
                <strong>Dentease</strong> adalah solusi modern untuk kebutuhan konsultasi kesehatan gigi Anda. Kami menyediakan sistem informasi yang memudahkan pasien dalam melakukan:
            </p>
            <ul style="font-family: 'Barlow', sans-serif; font-size: 1.05rem; list-style: none; padding-left: 0;">
                <li><i class="fas fa-calendar-check text-success me-2"></i> Pemesanan janji temu dokter gigi</li>
                <li><i class="fas fa-comments text-primary me-2"></i> Konsultasi langsung & ulasan dokter</li>
                <li><i class="fas fa-star text-warning me-2"></i> Penilaian dan rating pelayanan</li>
                <li><i class="fas fa-shield-alt text-info me-2"></i> Data pribadi dan jadwal yang aman & terpercaya</li>
            </ul>
            <div class="social-icons mt-2">
                <a href="#" target="_blank" style="margin-right: 15px; color: #002A8C;"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" target="_blank" style="margin-right: 15px; color: #002A8C;"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" target="_blank" style="margin-right: 15px; color: #002A8C;"><i class="fab fa-linkedin fa-lg"></i></a>
                <a href="mailto:dentease.support@gmail.com" style="color: #002A8C;"><i class="fas fa-envelope fa-lg"></i></a>
            </div>
        </div>
    </div>

    <h1 style="text-align: center; font-size: 50px; font-family: 'Oswald', sans-serif; color: #002A8C;">Layanan kami</h1>
    <p style="text-align: center; color: #002A8C;">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

    <div class="container my-4">
        <div class="row justify-content-center align-items-stretch">
            @foreach ($layananData as $layanan)
                <div class="col-auto mb-3">
                    <div class="cardLayanan" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-family: 'Oswald', sans-serif;">{{ htmlspecialchars($layanan->nama_layanan) }}</h5>
                            <p class="card-text">
                                Dokter:<br>
                                @if (!empty($layanan->dokters))
                                @foreach ($layanan->dokters as $dokter)
                                    <div class="dokter-info">
                                        <p><strong>{{ $dokter->nama_lengkap }}</strong> - {{ $dokter->spesialis }}</p>
                                    </div>
                                @endforeach
                                @else
                                    <em>Tidak ada dokter untuk layanan ini</em>
                                @endif
                            </p>
                            <p class="card-text">Biaya: Rp{{ number_format($layanan->biaya_layanan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="text-center mb-4">
        <h2 class="text-primary" style="font-family: 'Oswald', sans-serif; color: #002A8C;">Frequently Asked Questions (FAQ)</h2>
        <p class="text-muted" style="text-align: center;">Pertanyaan yang sering diajukan oleh pasien Dentease</p>
    </div>
    <div class="accordion" id="faqAccordion" style="margin-left: 200px;">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Apa itu Dentease?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <strong>Dentease</strong> adalah platform layanan konsultasi dan informasi kesehatan gigi secara online. Anda bisa membuat janji temu, membaca artikel kesehatan, dan melihat profil dokter gigi terpercaya.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Bagaimana cara membuat janji dengan dokter?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda hanya perlu login, pilih dokter yang tersedia, lalu klik tombol "Buat Janji Temu". Sistem akan mencatat dan mengonfirmasi janji Anda.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Apakah konsultasi ini gratis?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Beberapa layanan dasar seperti membaca artikel dan konsultasi umum gratis. Namun, janji temu dengan dokter bisa memiliki biaya tergantung jenis layanannya.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Apakah data saya aman di Dentease?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Ya, kami melindungi data Anda menggunakan enkripsi dan protokol keamanan terbaik. Privasi Anda adalah prioritas kami.
                </div>
            </div>
        </div>
    </div>
@endsection