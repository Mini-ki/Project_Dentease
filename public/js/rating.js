let currentRating = 0;
let starElements = [];

document.addEventListener('DOMContentLoaded', function() {
    const btnUpdateRating = document.getElementById('btnUpdateRating');
    if (btnUpdateRating) {
        btnUpdateRating.addEventListener('click', function() {
            const idKonsultasi = document.getElementById('detailIdKonsultasi').value;
            const currentRating = document.getElementById('detailStars').dataset.rating; 
            const currentUlasan = document.getElementById('detailUlasan').value;

            const detailModal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
            if (detailModal) {
                detailModal.hide();
            }

            openRatingModal(idKonsultasi, currentRating, currentUlasan);
        });
    }

    const btnDeleteRating = document.getElementById('btnDeleteRating');
    if (btnDeleteRating) {
        btnDeleteRating.addEventListener('click', function() {
            const idKonsultasi = document.getElementById('detailIdKonsultasi').value;
            document.getElementById('deleteKonsultasiId').value = idKonsultasi;
            const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirm'));
            deleteConfirmModal.show();
        });
    }
});

function renderStars(initialRating = 0) {
    currentRating = initialRating;  
    const container = document.getElementById('starsContainer');
    container.innerHTML = '';
    starElements = [];

    for (let i = 1; i <= 5; i++) {
        const star = document.createElement('span');
        star.classList.add('star');
        star.style.cursor = 'pointer';

        updateStarElement(star, i);

        star.addEventListener('click', () => {
            if (currentRating === i) {
                currentRating = i + 0.5;
            } else if (currentRating === i + 0.5) {
                currentRating = i;
            } else {
                currentRating = i;
            }
            if (currentRating > 5) currentRating = 5;
            renderStars(currentRating);
            document.getElementById('modalRating').value = currentRating;
        });

        container.appendChild(star);
        starElements.push(star);
    }
}

function showRekamMedisModal(rekamMedisData) {
    const rm = JSON.parse(rekamMedisData);
    
    const formattedDate = new Date(rm.tanggal).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });

    document.getElementById('rmTanggal').innerText = formattedDate;
    document.getElementById('rmDiagnosa').innerText = rm.diagnose || 'Tidak ada';
    document.getElementById('rmTindakan').innerText = rm.tindakan || 'Tidak ada';
    document.getElementById('rmObat').innerText = rm.obat || 'Tidak ada';

    const rmModal = new bootstrap.Modal(document.getElementById('rekamMedisModal'));
    rmModal.show();
}

function openRatingModal(idKonsultasi, rating = 0) {
    document.getElementById('modalIdKonsultasi').value = idKonsultasi;
    document.getElementById('modalRating').value = rating;

    renderStars(rating);

    var modal = new bootstrap.Modal(document.getElementById('ratingModal'));
    modal.show();
}

  
function confirmDelete(idKonsultasi) {
    document.getElementById('deleteKonsultasiId').value = idKonsultasi;
    var modal = new bootstrap.Modal(document.getElementById('deleteConfirm'));
    modal.show();
}

function updateStarElement(star, index) {
    const fullStars = Math.floor(currentRating);
    const halfStar = currentRating % 1 >= 0.5;

    if (index <= fullStars) {
        star.textContent = '★';
    } else if (index === fullStars + 1 && halfStar) {
        star.textContent = '⯪'; 
    } else {
        star.textContent = '☆';
    }
}

function openUpdateRatingModal(idKonsultasi, rating = 0, ulasan = '') {
    document.getElementById('updateIdKonsultasi').value = idKonsultasi;
    document.getElementById('updateRatingValue').value = rating;
    document.getElementById('updateUlasanText').value = ulasan;

    renderStars(rating);

    const modal = new bootstrap.Modal(document.getElementById('updateRatingModal'));
    modal.show();
}

function showDetailModal(idKonsultasi, rating, ulasan) {
    document.getElementById('detailIdKonsultasi').value = idKonsultasi;

    const fullStars = Math.floor(rating);
    const halfStar = (rating - fullStars) >= 0.5 ? 1 : 0;
    const emptyStars = 5 - fullStars - halfStar;

    let starsHtml = '';
    starsHtml += '★'.repeat(fullStars);
    starsHtml += '⯪'.repeat(halfStar);
    starsHtml += '☆'.repeat(emptyStars);

    document.getElementById('detailStars').innerHTML = starsHtml;

    document.getElementById('detailUlasan').value = ulasan || '';

    let detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    detailModal.show();

    document.getElementById('btnDeleteRating').onclick = function() {
        bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
    
        document.getElementById('deleteKonsultasiId').value = idKonsultasi;
    
        let deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirm'));
        deleteModal.show();
    };

    document.getElementById('btnUpdateRating').onclick = function () {
        const idKonsultasi = document.getElementById('detailIdKonsultasi').value;
        const ulasan = document.getElementById('detailUlasan').value;
    
        bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
    
        document.getElementById('modalIdKonsultasi').value = idKonsultasi;
        document.getElementById('modalRating').value = rating;
        document.querySelector('#ratingForm textarea[name="ulasan"]').value = ulasan;
    
        renderStars(rating);
    
        let modal = new bootstrap.Modal(document.getElementById('ratingModal'));
        modal.show();
    };
    
    
}

window.openRatingModal = openRatingModal;
window.showDetailModal = showDetailModal;
window.confirmDelete = confirmDelete;