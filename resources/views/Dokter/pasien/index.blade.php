@extends('layouts.dokter.dokter')

@section('title', 'Daftar Pasien - DENTEASE')

@section('additional-css')
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
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

        .modal-content form input[type="text"],
        .modal-content form input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        .modal-content form button[type="button"] {
            background-color: #f44336;
        }
    </style>
@endsection

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Rekam Medis</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('rekam_medis') }}">Rekam Medis</a></li>
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
                <th>Nama Panggilan</th>
                <th>Nama Lengkap</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Rekam Medis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pasien as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->nama_panggilan }}</td>
                    <td class="nowrap">{{ $row->nama_lengkap }}</td>
                    <td>{{ $row->umur }}</td>
                    <td>{{ $row->alamat }}</td>
                    <td>{{ $row->noHp }}</td>
                    <td>
                        <a href="{{ route('rekam_medis.detail', $row->id_pasien) }}">
                            <button type="button" id="button-detail">Detail</button>
                        </a>
                    </td>
                    <td class="nowrap">
                        <button type="button" id="button-edit"
                                onclick="openEditModal(`{{ json_encode($row) }}`)">Edit</button>
                        <button type="button" id="button-delete"
                                onclick="openDeleteModal('{{ $row->id_pasien }}')">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada pasien yang terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Data Pasien</h2>
            <form action="{{ route('rekam_medis.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_pasien" id="edit-id-pasien">
                <label>Nama Panggilan:</label>
                <input type="text" name="nama_panggilan" id="edit-nama-panggilan" required>
                <label>Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" id="edit-nama-lengkap" required>
                <label>Umur:</label>
                <input type="number" name="umur" id="edit-umur" required>
                <label>Alamat:</label>
                <input type="text" name="alamat" id="edit-alamat" required>
                <label>No HP:</label>
                <input type="text" name="noHp" id="edit-noHp" required>
                <button type="submit">Simpan Perubahan</button>
                <button type="button" onclick="closeModal('editModal')" style="background-color: #f44336;">Batal</button>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <form action="{{ route('rekam_medis.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id_pasien" id="delete-id-pasien">
                <button type="submit">Ya, Hapus</button>
                <button type="button" onclick="closeModal('deleteModal')" style="background-color: #f44336;">Batal</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openEditModal(jsonString) {
            // Parse string JSON menjadi objek JavaScript
            const data = JSON.parse(jsonString);

            document.getElementById('edit-id-pasien').value = data.id_pasien;
            document.getElementById('edit-nama-panggilan').value = data.nama_panggilan;
            document.getElementById('edit-nama-lengkap').value = data.nama_lengkap;
            document.getElementById('edit-umur').value = data.umur;
            document.getElementById('edit-alamat').value = data.alamat;
            document.getElementById('edit-noHp').value = data.noHp;
            document.getElementById('editModal').style.display = 'flex';
        }

        function openDeleteModal(id_pasien) {
            document.getElementById('delete-id-pasien').value = id_pasien;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>
@endsection