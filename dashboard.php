<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$moisture = 42; 
$temp = 28;
$humidity = 65;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriflow | Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <?php include('sidebar/sidebar.php'); ?>

    <main>
        <header>
            <div>
                <h1>Welcome, <?php echo explode(' ', $_SESSION['user_name'])[0]; ?>!</h1>
                <p style="color: var(--secondary); margin-top: 4px;">Farm Node: 001 | 🛰️ Online</p>
            </div>
        </header>

        <section class="control-panel">
            <div>
                <span style="background: #2e7d32; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">AUTO-IRRIGATION ON</span>
                <h2 style="margin: 12px 0 4px 0;">Valve Status: Idle</h2>
                <p style="color: #888; font-size: 0.9rem;">Next check in 14 minutes</p>
            </div>
            <button class="btn-action" style="background: white; color: black; padding: 16px 32px;">Manual Override</button>
        </section>

        <section class="stats-grid">
            <div class="card">
                <h3>Soil Moisture</h3>
                <div class="value"><?php echo $moisture; ?>%</div>
                <p style="color: #4caf50; font-size: 0.85rem; font-weight: 600;">Optimal Condition</p>
            </div>
            <div class="card">
                <h3>Climate</h3>
                <div class="value"><?php echo $temp; ?>°C <span style="font-size: 1rem; color: var(--secondary);">/ <?php echo $humidity; ?>% RH</span></div>
                <p style="color: var(--secondary); font-size: 0.85rem;">Stable Ambient Air</p>
            </div>
            <div class="card">
                <h3>Irrigation Threshold</h3>
                <div class="value">35%</div>
                <button style="background:none; border:none; color:var(--accent); font-weight:700; cursor:pointer; padding:0;">Update Settings</button>
            </div>
        </section>

        <div class="card" style="margin-top: 1rem;">
            <h3 style="margin-bottom: 20px;">Moisture Trends (Last 24h)</h3>
            <div style="height: 300px; width: 100%;">
                <canvas id="moistureChart"></canvas>
            </div>
        </div>
    </main>

    <script>
        const ctx = document.getElementById('moistureChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['12am', '4am', '8am', '12pm', '4pm', '8pm', 'Now'],
                datasets: [{
                    label: 'Moisture Level %',
                    data: [32, 30, 48, 42, 38, 45, 42],
                    borderColor: '#2e7d32',
                    backgroundColor: 'rgba(46, 125, 50, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });
    </script>
</body>
</html>