console.log("login.js loaded");

document.addEventListener("DOMContentLoaded", function () {
    const loginStatus = document.getElementById('loginStatus').getAttribute('data-status');
    const loginRole = document.getElementById('loginRole').getAttribute('data-role');
    const successIcon = document.getElementById('iconLogInSukses');
    const errorBox = document.getElementById('errorBox');

    if (loginStatus === 'success') {
        if (successIcon) successIcon.classList.add('show');

        setTimeout(() => {
            if (loginRole === "admin") {
                window.location.href = 'admin/dashboardAdmin.php';
            } else if (loginRole === "dokter") {
                window.location.href = 'dokter/dashboardDokter.php';
            } else {
                window.location.href = 'pasien/dashboardUser.php';
            }
        }, 3000);

    } else if (loginStatus === 'failed') {
        if (errorBox) {
            errorBox.classList.add('show');
            setTimeout(() => {
                errorBox.classList.remove('show');
            }, 2000);
        }
    }
});