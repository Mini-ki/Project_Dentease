@extends('layouts.dokter.dokter')

@section('title', 'Rekam Medis Pasien - DENTEASE')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Rekam Medis</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('rekam_medis') }}">Rekam Medis</a></li> {{-- Sesuaikan dengan nama rute Anda --}}
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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
            @php $urut = 1; @endphp
            @forelse ($pasien as $data)
                <tr>
                    <td>{{ $urut++ }}</td>
                    <td>{{ $data->nama_panggilan }}</td>
                    <td class="nowrap">{{ $data->nama_lengkap }}</td>
                    <td>{{ $data->umur }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->noHp }}</td>
                    <td>
                        <button type="button" id="button-detail"
                            style="background-color: #002A8C; color: white; padding: 8px 12px; border-radius: 4px; border: none; cursor: pointer;"
                            onclick="openDetailRekamMedisModal('{{ $data->id_pasien }}')">Detail</button>
                    </td>
                    <td class="nowrap">
                        <button type="button" id="button-edit" style="background-color: #4CAF50; color: white; padding: 8px 12px; border-radius: 4px; border: none; cursor: pointer; margin-right: 5px;"
                            onclick="openEditModal('{{ json_encode($data) }}')">Edit</button>
                        <button type="button" id="button-delete" style="background-color: #f44336; color: white; padding: 8px 12px; border-radius: 4px; border: none; cursor: pointer;"
                            onclick="openDeleteModal('{{ $data->id_pasien }}')">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada pasien dalam rekam medis Anda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Modal Edit --}}
    <div id="editModal" class="modal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
            <span class="close" onclick="closeModal('editModal')" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <h2>Edit Data Pasien</h2>
            <form action="{{ route('rekam_medis.update') }}" method="POST"> {{-- Sesuaikan dengan nama rute Anda --}}
                @csrf
                @method('PUT')
                <input type="hidden" name="id_pasien" id="edit-id-pasien">
                <label for="edit-nama-panggilan">Nama Panggilan:</label>
                <input type="text" name="nama_panggilan" id="edit-nama-panggilan" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <label for="edit-nama-lengkap">Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" id="edit-nama-lengkap" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <label for="edit-umur">Umur:</label>
                <input type="number" name="umur" id="edit-umur" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <label for="edit-alamat">Alamat:</label>
                <input type="text" name="alamat" id="edit-alamat" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <label for="edit-noHp">No HP:</label>
                <input type="text" name="noHp" id="edit-noHp" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background-color: #007BFF; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div id="deleteModal" class="modal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 400px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
            <span class="close" onclick="closeModal('deleteModal')" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus data pasien ini?</p>
            <form action="{{ route('rekam_medis.destroy') }}" method="POST"> 
                @csrf
                @method('DELETE')
                <input type="hidden" name="id_pasien" id="delete-id-pasien">
                <button type="submit" style="background-color: #f44336; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer; margin-right: 10px;">Ya, Hapus</button>
                <button type="button" onclick="closeModal('deleteModal')" style="background-color: #ddd; color: black; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;">Batal</button>
            </form>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div id="detailRekamMedisModal" class="modal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 5% auto; padding: 20px; border: 1px solid #888; width: 90%; max-width: 800px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
            <span class="close" onclick="closeModal('detailRekamMedisModal')" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <h2>Detail Rekam Medis Pasien</h2>
            <div id="rekamMedisContent">
                <h3 id="detail-pasien-nama"></h3>
                <p><strong>Umur:</strong> <span id="detail-pasien-umur"></span></p>
                <p><strong>Alamat:</strong> <span id="detail-pasien-alamat"></span></p>
                <p><strong>No HP:</strong> <span id="detail-pasien-noHp"></span></p>

                <h4>Riwayat Konsultasi:</h4>
                <div id="riwayat-konsultasi-list">
                </div>
                <p id="no-konsultasi-msg" style="display: none; color: gray;">Belum ada riwayat konsultasi.</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dokter/pasien.js') }}"></script>

    <script>
        function openForm() {
            document.getElementById('id_rekam_medis').value = '';
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
    </script>
@endsection