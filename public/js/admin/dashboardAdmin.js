document.addEventListener('DOMContentLoaded', function() {
  var canvas = document.getElementById('myLineChart');
  if (!canvas) {
    console.error("Canvas with id 'myLineChart' not found");
    return;
  }

  var dokter = parseInt(canvas.getAttribute('data-dokter')) || 0;
  var pasien = parseInt(canvas.getAttribute('data-pasien')) || 0;
  var konsultasi = parseInt(canvas.getAttribute('data-konsultasi')) || 0;

  var ctx = canvas.getContext('2d');
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Dokter', 'Pasien', 'Konsultasi'],
      datasets: [{
        label: 'Jumlah Data',
        data: [dokter, pasien, konsultasi],
        backgroundColor: 'rgba(33, 150, 243, 0.2)',
        borderColor: 'rgba(33, 150, 243, 1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#fff',
        pointBorderColor: 'rgba(33, 150, 243, 1)',
        pointRadius: 5
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: true, position: 'top' },
        tooltip: { mode: 'index', intersect: false }
      },
      scales: {
        y: { beginAtZero: true, stepSize: 1 }
      }
    }
  });
});
