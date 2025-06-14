document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    console.log("form:", form);
    if (!form) return;
    let allowSubmit = false;

    form.addEventListener("submit", function (event) {
        if (!allowSubmit) {
            event.preventDefault(); 

            // HAPUS ATAU KOMENTARI BARIS INI:
            // const name = document.getElementById("name").value.trim();
            // const email = document.getElementById("email").value.trim();

            const dokter = document.getElementById("dokter").value;
            const errorMessages = [];

            // HAPUS ATAU KOMENTARI BLOK VALIDASI INI:
            // if (name === "" || /[^a-zA-Z ]/.test(name)) {
            //     errorMessages.push("Nama tidak boleh kosong atau berisi karakter bukan huruf.");
            // }

            // HAPUS ATAU KOMENTARI BLOK VALIDASI INI:
            // if (!email.includes("@") || !email.includes(".")) {
            //     errorMessages.push("Email tidak valid.");
            // }

            if (!dokter) {
                errorMessages.push("Pilih dokter yang diinginkan.");
            }

            if (errorMessages.length > 0) {
                alert(errorMessages.join("\n"));
                return;
            }

            showNotification("Janji temu berhasil dibuat!");
            setTimeout(() => {
                allowSubmit = true;
                form.submit(); 
            }, 2000);
        }
    });

    function showNotification(message) {
        const notification = document.createElement("div");
        notification.innerText = message;
        notification.style.backgroundColor = "#274760";
        notification.style.color = "white";
        notification.style.padding = "10px";
        notification.style.margin = "10px 0";
        notification.style.position = "fixed";
        notification.style.top = "10px";
        notification.style.left = "50%";
        notification.style.transform = "translateX(-50%)";
        notification.style.zIndex = "1000";
        notification.style.borderRadius = "20px";
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.opacity = 0;
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
});