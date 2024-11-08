<!-- monitoring.php -->

<h1>Status Sistem</h1>
<p>CPU Load: <span id="cpu-load">Loading...</span></p>
<p>Memory Usage: <span id="memory-usage">Loading...</span></p>
<p>Disk Usage: <span id="disk-usage">Loading...</span></p>

<!-- Chart.js: untuk menampilkan grafik -->
<canvas id="system-status-chart" width="400" height="200"></canvas>

<!-- Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Mengambil elemen canvas untuk chart
    const ctx = document.getElementById('system-status-chart').getContext('2d');

    // Membuat chart awal dengan nilai kosong
    const systemStatusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['CPU Load', 'Memory Usage', 'Disk Usage'],
            datasets: [{
                label: 'System Status (%)',
                data: [0, 0, 0], // Data awal kosong
                backgroundColor: ['#ff5733', '#33b5ff', '#ffeb3b'],
                borderColor: ['#ff5733', '#33b5ff', '#ffeb3b'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Fungsi untuk memperbarui data chart setiap detik
    function fetchMonitoringData() {
        fetch('<?= 'monitorings'?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Pastikan header ini ada untuk menandakan AJAX request
            }
        })
        .then(response => response.json()) // Parsing response ke JSON
        .then(data => {
            // Update chart atau UI lainnya dengan data
            document.getElementById('cpu-load').textContent = data.cpu_load + '%';
            document.getElementById('memory-usage').textContent = data.memory_usage + ' MB';
            document.getElementById('disk-usage').textContent = data.disk_usage + '%';

            // Update chart
            systemStatusChart.data.datasets[0].data = [data.cpu_load, data.memory_usage, data.disk_usage];
            systemStatusChart.update();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            // Menampilkan pesan error jika data tidak valid atau terjadi kesalahan lainnya
        });
    }

    // Memanggil fungsi ini untuk mendapatkan data
    setInterval(fetchMonitoringData, 1000); // Memperbarui data setiap detik
</script>
