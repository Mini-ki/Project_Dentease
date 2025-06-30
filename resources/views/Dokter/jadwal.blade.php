@extends('layouts.dokter.dokter') 

@section('title', 'Jadwal Dokter') 

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Jadwal Operasional</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('dokter.jadwal') }}">Jadwal</a></li>
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button type="button" id="button-edit" style="background-color: #002A8C; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer; margin-bottom: 20px;" onclick="openTambahModal()">+ Tambah Jadwal</button>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Hari</th>
                <th>Jam Operasional</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $urut = 1; @endphp
            @forelse ($jadwals as $data)
                <tr>
                    <td>{{ $urut++ }}</td>
                    <td>{{ $data->hari }}</td>
                    <td>{{ $data->jam_mulai . " - " . $data->jam_selesai }}</td>
                    <td class="nowrap">
                        <button type="button" id="button-edit" style="background-color: #4CAF50; color: white; padding: 8px 12px; border-radius: 4px; border: none; cursor: pointer; margin-right: 5px;"
                            onclick="openEditModal('{{ json_encode($data) }}')">Edit</button>
                                       
                            <button type="button" id="button-delete" style="background-color: #f44336; color: white; padding: 8px 12px; border-radius: 4px; border: none; cursor: pointer;"
                            onclick="openDeleteModal('{{ $data->id_jadwal }}')">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada jadwal yang ditambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Modal Edit --}}
    <div id="editModal" class="modal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
            <span class="close" onclick="closeModal('editModal')" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <h2>Edit Jadwal</h2>
            <form action="{{ route('dokter.jadwal.update') }}" method="POST">
                @csrf {{-- Token CSRF untuk keamanan --}}
                @method('PUT') {{-- Method spoofing untuk HTTP PUT --}}
                <input type="hidden" name="id_jadwal" id="edit-id-jadwal">
                <label for="edit-hari">Hari:</label>
                <input type="text" name="hari" id="edit-hari" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <label for="edit-jam-mulai">Jam Mulai:</label>
                <input type="time" name="jam_mulai" id="edit-jam-mulai" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <label for="edit-jam-selesai">Jam Selesai:</label>
                <input type="time" name="jam_selesai" id="edit-jam-selesai" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background-color: #007BFF; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div id="deleteModal" class="modal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 400px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
            <span class="close" onclick="closeModal('deleteModal')" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus jadwal ini?</p>
            <form action="{{ route('dokter.jadwal.destroy') }}" method="POST">
                @csrf
                @method('DELETE') {{-- Method spoofing untuk HTTP DELETE --}}
                <input type="hidden" name="id_jadwal" id="delete-id-jadwal">
                <button type="submit" style="background-color: #f44336; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer; margin-right: 10px;">Ya, Hapus</button>
                <button type="button" onclick="closeModal('deleteModal')" style="background-color: #ddd; color: black; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;">Batal</button>
            </form>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div id="tambahModal" class="modal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
            <span class="close" onclick="closeModal('tambahModal')" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <h2>Tambah Jadwal Baru</h2>
            <form action="{{ route('dokter.jadwal.store') }}" method="POST">
                @csrf
                <label for="tambah-hari">Hari:</label>
                <input type="text" name="hari" id="tambah-hari" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <label for="tambah-jam-mulai">Jam Mulai:</label>
                <input type="time" name="jam_mulai" id="tambah-jam-mulai" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <label for="tambah-jam-selesai">Jam Selesai:</label>
                <input type="time" name="jam_selesai" id="tambah-jam-selesai" required style="width: calc(100% - 22px); padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background-color: #28a745; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;">Simpan Jadwal</button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/dokter/jadwal.js') }}"></script>
@endsection