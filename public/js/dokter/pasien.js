function openEditModal(data) {
    document.getElementById('edit-id-pasien').value = data.id_pasien;
    document.getElementById('edit-nama-panggilan').value = data.nama_panggilan;
    document.getElementById('edit-nama-lengkap').value = data.nama_lengkap;
    document.getElementById('edit-umur').value = data.umur;
    document.getElementById('edit-alamat').value = data.alamat;
    document.getElementById('edit-noHp').value = data.noHp;
    document.getElementById('editModal').style.display = 'block';
}

function openDeleteModal(id_pasien) {
    document.getElementById('delete-id-pasien').value = id_pasien;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}