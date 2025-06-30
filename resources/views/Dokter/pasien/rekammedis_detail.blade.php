@extends('layouts.dokter.dokter')

@section('title', 'Detail Rekam Medis - DENTEASE')

@section('additional-css')
    {{-- Sesuaikan path CSS jika rekammedis.css ada di folder Dokter --}}
    <link rel="stylesheet" href="{{ asset('css/Dokter/rekammedis.css') }}">
    <style>
        /* CSS untuk Modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative;
        }

        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .modal-content form textarea {
            width: calc(100% - 20px);
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            min-height: 80px;
            resize: vertical;
        }

        .modal-content form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .modal-content form button.btn-danger {
            background-color: #f44336;
        }
        /* Styling for the cards */
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #333; /* Darker text for readability */
        }
        .card p strong {
            color: #555;
        }
        .card .btn {
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none; /* For anchor buttons */
            display: inline-block; /* For anchor buttons */
            margin-top: 10px;
        }
        .card .btn.btn-danger {
            background-color: #f44336;
        }

    </style>
@endsection

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Rekam Medis Pasien</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a href="{{ route('rekam_medis') }}">Rekam Medis</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Detail</a></li>
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

    <div style="margin-bottom: 20px;">
        <a href="{{ route('rekam_medis') }}" class="btn btn-danger">Kembali</a>
        <button onclick="openForm()" class="btn">+ Tambah Rekam Medis</button>
    </div>

    {{-- Informasi Pasien --}}
    @if ($pasien_data)
        <div class="card" style="background-color: #e9e9e9;">
            <h3>Informasi Pasien</h3>
            <p><strong>Nama Lengkap:</strong> {{ $pasien_data->nama_lengkap }}</p>
            <p><strong>Nama Panggilan:</strong> {{ $pasien_data->nama_panggilan }}</p>
            <p><strong>Umur:</strong> {{ $pasien_data->umur }}</p>
            <p><strong>Alamat:</strong> {{ $pasien_data->alamat }}</p>
            <p><strong>No HP:</strong> {{ $pasien_data->noHp }}</p>
        </div>
    @endif

    <h3>Riwayat Rekam Medis</h3>
    @forelse ($rekam_medis_list as $row)
        <div class="card" style="z-index: 9999px">
            <p><strong>Nama Pasien:</strong> {{ $row->nama_pasien }}</p>
            <p><strong>Nama Dokter:</strong> {{ $row->nama_dokter }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y H:i') }}</p>
            <p><strong>Diagnosa:</strong> {{ $row->diagnose }}</p>
            <p><strong>Tindakan:</strong> {{ $row->tindakan }}</p>
            <p><strong>Obat:</strong> {{ $row->obat }}</p>
            <button onclick="editData('{{ json_encode($row) }}')" class="btn">Edit</button>
            <a href="{{ route('rekam_medis.delete_rm', ['id_pasien' => $pasien_data->id_pasien, 'id_rekam_medis' => $row->id_rekam_medis]) }}" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus rekam medis ini?')">Hapus</a>
        </div>
    @empty
        <p style="color: #666;">Belum ada rekam medis untuk pasien ini.</p>
    @endforelse

    {{-- Modal Form Tambah/Edit Rekam Medis --}}
    <div class="modal" id="modalForm">
        <div class="modal-content">
            <span class="close" onclick="closeForm()">&times;</span>
            <h2>Rekam Medis</h2>
            <form method="POST" action="{{ route('rekam_medis.store_update_rm', $pasien_data->id_pasien) }}">
                @csrf
                <input type="hidden" name="id_rekam_medis" id="id_rekam_medis">
                <label>Diagnosa:</label><br>
                <textarea name="diagnosa" id="diagnosa" required></textarea><br>
                <label>Tindakan:</label><br>
                <textarea name="tindakan" id="tindakan" required></textarea><br>
                <label>Obat:</label><br>
                <textarea name="obat" id="obat" required></textarea><br>
                <button type="submit" class="btn">Simpan</button>
                <button type="button" onclick="closeForm()" class="btn btn-danger">Batal</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openForm() {
            document.getElementById('id_rekam_medis').value = ''; // Clear for add new
            document.getElementById('diagnosa').value = '';
            document.getElementById('tindakan').value = '';
            document.getElementById('obat').value = '';
            document.getElementById('modalForm').style.display = 'flex';
        }

        function closeForm() {
            document.getElementById('modalForm').style.display = 'none';
        }

        function editData(data) {
            document.getElementById('id_rekam_medis').value = data.id_rekam_medis;
            document.getElementById('diagnosa').value = data.diagnosa;
            document.getElementById('tindakan').value = data.tindakan;
            document.getElementById('obat').value = data.obat;
            document.getElementById('modalForm').style.display = 'flex';
        }

        // Close modals if clicked outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>
@endsection
