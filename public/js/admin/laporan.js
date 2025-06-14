console.log("grafik");
const { labels: labelsOriginal, layananList, rawData } = window.chartData;
console.log(window.chartData);

// Konversi bulan numerik ke nama (misal "01" jadi "Jan")
const bulanMap = {
  '01': 'Jan', '02': 'Feb', '03': 'Mar', '04': 'Apr',
  '05': 'Mei', '06': 'Jun', '07': 'Jul', '08': 'Agu',
  '09': 'Sep', '10': 'Okt', '11': 'Nov', '12': 'Des'
};

// Ubah label dari "2025-01" jadi "Jan"
const labels = labelsOriginal.map(bln => {
  const bulan = bln.split('-')[1];
  return bulanMap[bulan] || bln;
});

// Siapkan data tiap layanan
const ds = layananList.map(l => ({
  label: l,
  data : labelsOriginal.map(bln => (rawData[bln]?.[l]) ?? 0),
  borderWidth: 2,
  tension: 0.3,
  fill: false
}));

// Cari nilai maksimum dari semua dataset
let maxY = 0;
layananList.forEach(l => {
  labelsOriginal.forEach(bln => {
    const val = rawData[bln]?.[l] ?? 0;
    if (val > maxY) maxY = val;
  });
});
const suggestedMaxValue = maxY + 1;

// Buat chart
new Chart(document.getElementById('myLineChart'), {
  type: 'line',
  data: {
    labels,
    datasets: ds
  },
  options: {
    responsive: true,
    interaction: {
      mode: 'index',
      intersect: false
    },
    scales: {
      y: {
        beginAtZero: true,
        suggestedMax: suggestedMaxValue,
        ticks: { precision: 1 }
      },
      x: {
        title: {
          display: true,
          text: 'Bulan'
        }
      }
    }
  }
});

