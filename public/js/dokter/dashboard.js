document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("myLineChart");

    const dataPasien = parseInt(ctx.dataset.pasien);
    const dataKonsultasi = parseInt(ctx.dataset.konsultasi);
    const dataBelum = parseInt(ctx.dataset.belum);
    const dataSelesai = parseInt(ctx.dataset.selesai);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Pasien', 'Total Konsultasi', 'Belum Konsultasi', 'Sudah Diperiksa'],
            datasets: [{
                label: 'Jumlah',
                data: [dataPasien, dataKonsultasi, dataBelum, dataSelesai],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#e83e8c'],
                borderColor: ['#0056b3', '#1e7e34', '#d39e00', '#c2185b'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Statistik Konsultasi Pasien'
                }
            }
        }
    });
});
