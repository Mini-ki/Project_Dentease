console.log("grafik");
const { labels, layananList, rawData } = window.chartData;
console.log(window.chartData);

const ds = layananList.map(l => ({
  label: l,
  data : labels.map(bulan => (rawData[bulan]?.[l]) ?? 0),
  borderWidth: 2,
  tension: 0.3,
  fill: false
}));

new Chart(document.getElementById('myLineChart'), {
  type: 'line',
  data: { labels, datasets: ds },   
  options: {
    responsive: true,
    interaction: { mode: 'index', intersect: false },
    scales: {
      y: { beginAtZero: true, ticks: { precision: 0 } },
      x: { title: { display: true, text: 'Bulan' } }
    }
  }
});
