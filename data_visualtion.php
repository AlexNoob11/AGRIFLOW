<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriflow | Data Visualization</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .viz-container { display: flex; flex-direction: column; gap: 2rem; }
        
        .chart-main-card { 
            background: white; 
            padding: 2rem; 
            border-radius: 24px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .filter-group { display: flex; gap: 10px; }
        .filter-btn { 
            padding: 8px 16px; border-radius: 8px; border: 1px solid #eee; 
            background: white; cursor: pointer; font-size: 0.85rem; font-weight: 600;
        }
        .filter-btn.active { background: var(--accent); color: white; border-color: var(--accent); }

        .history-table-card { 
            background: white; padding: 1.5rem; border-radius: 24px; overflow-x: auto; 
        }
        
        table { width: 100%; border-collapse: collapse; min-width: 500px; }
        th { text-align: left; padding: 12px; color: var(--secondary); border-bottom: 2px solid #f0f0f0; font-size: 0.8rem; text-transform: uppercase; }
        td { padding: 15px 12px; border-bottom: 1px solid #f9f9f9; font-size: 0.9rem; }
        
        .trend-up { color: #2e7d32; font-weight: 600; }
        .trend-down { color: #d32f2f; font-weight: 600; }
    </style>
</head>
<body>

    <?php include('sidebar/sidebar.php'); ?>

    <main>
        <header>
            <div>
                <h1>Data Visualization</h1>
                <p style="color: var(--secondary);">Historical analysis and sensor trends.</p>
            </div>
            <div class="filter-group">
                <button class="filter-btn active">Last 24h</button>
                <button class="filter-btn">7 Days</button>
                <button class="filter-btn">30 Days</button>
            </div>
        </header>

        <div class="viz-container">
            <div class="chart-main-card">
                <div class="chart-header">
                    <h3>Moisture vs. Temperature Correlation</h3>
                    <div style="font-size: 0.8rem; color: var(--secondary);">📍 Node: West Wing Field</div>
                </div>
                <div style="height: 400px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="history-table-card">
                <h3>Moisture Level History</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Moisture</th>
                            <th>Temp</th>
                            <th>Humidity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2026-04-02 14:30</td>
                            <td class="trend-up">42% ↑</td>
                            <td>28°C</td>
                            <td>65%</td>
                            <td><span style="color: #4caf50;">Optimal</span></td>
                        </tr>
                        <tr>
                            <td>2026-04-02 13:30</td>
                            <td>38%</td>
                            <td>29°C</td>
                            <td>62%</td>
                            <td><span style="color: #4caf50;">Optimal</span></td>
                        </tr>
                        <tr>
                            <td>2026-04-02 12:30</td>
                            <td class="trend-down">34% ↓</td>
                            <td>31°C</td>
                            <td>58%</td>
                            <td><span style="color: #f57c00;">Low Moisture</span></td>
                        </tr>
                        <tr>
                            <td>2026-04-02 11:30</td>
                            <td>35%</td>
                            <td>30°C</td>
                            <td>60%</td>
                            <td><span style="color: #4caf50;">Optimal</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        const ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['10am', '11am', '12pm', '1pm', '2pm', '3pm', '4pm'],
                datasets: [
                    {
                        label: 'Moisture Level (%)',
                        data: [40, 38, 34, 38, 42, 45, 42],
                        borderColor: '#2e7d32',
                        backgroundColor: 'rgba(46, 125, 50, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Temperature (°C)',
                        data: [28, 30, 31, 29, 28, 27, 28],
                        borderColor: '#f57c00',
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.4,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', align: 'end' }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Moisture %' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        title: { display: true, text: 'Temp °C' }
                    }
                }
            }
        });
    </script>
</body>
</html>