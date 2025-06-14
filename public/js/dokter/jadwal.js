function openEditModal(data) {
    document.getElementById('edit-id-jadwal').value = data.id_jadwal;
    document.getElementById('edit-hari').value = data.hari;
    document.getElementById('edit-jam-mulai').value = data.jam_mulai;
    document.getElementById('edit-jam-selesai').value = data.jam_selesai;
    document.getElementById('editModal').style.display = 'block';
}

function openDeleteModal(id_jadwal) {
    document.getElementById('delete-id-jadwal').value = id_jadwal;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}
function openTambahModal() {
    document.getElementById('tambahModal').style.display = 'block';
}