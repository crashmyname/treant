<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Monitoring</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    .chart-container {
        display: flex;
        /* Mengatur kontainer dalam bentuk fleksibel (flexbox) */
        justify-content: center;
        /* Mengatur agar konten berada di tengah */
        gap: 20px;
        /* Menambahkan jarak antar chart */
    }

    .chart {
        width: 100%;
        max-width: 400px;
        /* Lebar maksimum chart */
        height: 250px;
        /* Tinggi chart */
    }
</style>

<body>
    <h1>Server Monitoring Status</h1>
    <div id="status"></div>
    <div class="chart-container">
        <canvas id="cpuChart" class="chart"></canvas>
        <canvas id="memoryChart" class="chart"></canvas>
        <canvas id="diskUsageChart" class="chart"></canvas> <!-- Grafik untuk Disk Usage -->
        <canvas id="memoryPeakChart" class="chart"></canvas> <!-- Grafik untuk Memory Peak Usage -->
    </div>

    <script>
        const cpuData = [];
        const memoryData = [];
        const diskUsageData = [];
        const memoryPeakData = [];
        const labels = [];

        // Inisialisasi Chart.js untuk CPU Load
        const ctxCpu = document.getElementById('cpuChart').getContext('2d');
        const cpuChart = new Chart(ctxCpu, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'CPU Load (%)',
                    data: cpuData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true
                    },
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: 'white',
                        bodyColor: 'white',
                    }
                }
            }
        });

        // Inisialisasi Chart.js untuk Memory Usage
        const ctxMemory = document.getElementById('memoryChart').getContext('2d');
        const memoryChart = new Chart(ctxMemory, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Memory Usage (bytes)',
                    data: memoryData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: 'white',
                        bodyColor: 'white',
                    }
                }
            }
        });

        // Inisialisasi Chart.js untuk Disk Usage
        const ctxDiskUsage = document.getElementById('diskUsageChart').getContext('2d');
        const diskUsageChart = new Chart(ctxDiskUsage, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Disk Usage (%)',
                    data: diskUsageData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true
                    },
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: 'white',
                        bodyColor: 'white',
                    }
                }
            }
        });

        // Inisialisasi Chart.js untuk Memory Peak Usage
        const ctxMemoryPeak = document.getElementById('memoryPeakChart').getContext('2d');
        const memoryPeakChart = new Chart(ctxMemoryPeak, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Memory Peak Usage (bytes)',
                    data: memoryPeakData,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: 'white',
                        bodyColor: 'white',
                    }
                }
            }
        });

        function updateStatus() {
            fetch('<?= 'module' ?>')
                .then(response => response.json())
                .then(data => {
                    const currentTime = new Date().toLocaleTimeString();

                    // Fungsi untuk mengonversi bytes menjadi MB atau GB
                    function formatSize(bytes) {
                        if (bytes >= 1073741824) {
                            return (bytes / 1073741824).toFixed(2) + " GB";
                        } else if (bytes >= 1048576) {
                            return (bytes / 1048576).toFixed(2) + " MB";
                        } else if (bytes >= 1024) {
                            return (bytes / 1024).toFixed(2) + " KB";
                        } else {
                            return bytes + " bytes";
                        }
                    }

                    // Update status text dengan memformat ukuran data
                    document.getElementById('status').innerHTML = `
                <p>Status: ${data.status}</p>
                <p>Database: ${data.database}</p>
                <p>CPU Load: ${data.cpu_load} %</p>
                <p>Memory Usage: ${formatSize(data.memory_usage)}</p>
                <p>Memory Peak Usage: ${formatSize(data.disk_usage)}</p>
                <p>Disk Total space: ${formatSize(data.disk_total_space)}</p>
                <p>Disk Free space: ${formatSize(data.disk_free_space)}</p>
                <p>Disk Used space: ${formatSize(data.disk_used_space)}</p>
                <p>Execution Time: ${data.execution_time} ms</p>
            `;

                    // Update data untuk grafik
                    if (labels.length > 20) {
                        labels.shift();
                        cpuData.shift();
                        memoryData.shift();
                        diskUsageData.shift();
                        memoryPeakData.shift();
                    }

                    labels.push(currentTime);
                    cpuData.push(parseFloat(data.cpu_load));
                    memoryData.push(data.memory_usage);
                    diskUsageData.push(parseFloat(data.disk_used_space / data.disk_total_space * 100));  // Disk usage as percentage
                    memoryPeakData.push(data.disk_usage);

                    cpuChart.update();
                    memoryChart.update();
                    diskUsageChart.update();
                    memoryPeakChart.update();
                })
                .catch(error => {
                    console.error('Error fetching status:', error);
                });
        }

        // Menggunakan setInterval untuk polling setiap 1 detik
        setInterval(updateStatus, 1000);

        // Memanggil update pertama kali tanpa menunggu 5 detik
        updateStatus();
    </script>
</body>

</html>
