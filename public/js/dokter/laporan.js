const ctx = document.getElementById('konsultasiChart').getContext('2d');
const konsultasiChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            '2 Bulan Terakhir',
            '1 Bulan Terakhir',
            '3 Minggu Terakhir',
            '2 Minggu Terakhir',
            '1 Minggu Terakhir'
        ],
        datasets: [{
            label: 'Pasien Konsultasi',
            data: [1, 2, 3, 4, 5], // ubah data sesuai realita
            fill: false,
            borderColor: '#22c55e',
            backgroundColor: '#22c55e',
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Pasien'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Periode'
                }
            }
        }
    }
});
