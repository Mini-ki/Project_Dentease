function showModal() {
    const name = document.getElementById("name").value;
    const appointmentDate = document.getElementById("tanggalJanji").value;
    const email = document.getElementById("email").value;
    const spec = document.getElementById("spec").value;
    const cabang = document.getElementById("cabang").value;


    if (!name || !appointmentDate || !email || !cabang || !spec) {
        alert("Harap lengkapi semua data sebelum mengirim!");
        return;
    }

    document.getElementById("confirmationModal").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeModal() {
    document.getElementById("confirmationModal").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

function submitForm() {
    closeModal();
    document.getElementById("form").submit();
}

window.addEventListener('scroll', function () {
const navbar = document.querySelector('.navbar');
if (window.scrollY > 50) {
    navbar.classList.add('scrolled');
} else {
    navbar.classList.remove('scrolled');
}
});