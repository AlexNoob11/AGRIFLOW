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
    <title>Agriflow | System Settings & Reports</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .settings-container { display: grid; grid-template-columns: 1fr 1.5fr; gap: 2rem; }
        .settings-card { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: var(--secondary); font-size: 0.85rem; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 10px; background: #fafafa; }
        
        .report-preview { background: white; padding: 2rem; border-radius: 20px; }
        
        /* Print Styles - Crucial for "Download and Print Graphs" */
        @media print {
            .sidebar, .mobile-nav, .btn-action, .settings-card:first-child { display: none !important; }
            main { margin-left: 0 !important; padding: 0 !important; width: 100% !important; }
            .report-preview { box-shadow: none; border: none; width: 100%; }
            body { background: white; }
            canvas { max-width: 100% !important; height: auto !important; }
        }

        .export-btn { background: #1a1c1a; color: white; border: none; padding: 12px 24px; border-radius: 10px; cursor: pointer; font-weight: 600; width: 100%; }
    </style>
</head>
<body>

    <?php include('sidebar/sidebar.php'); ?>

    <main>
        <header>
            <div>
                <h1>System Settings & Reporting</h1>
                <p style="color: var(--secondary);">Configure hardware and generate data exports.</p>
            </div>
            <button class="btn-action" onclick="window.print()">🖨️ Print Report</button>
        </header>

        <div class="settings-container">
            <div class="settings-card">
                <h3>Hardware Configuration</h3>
                <form onsubmit="event.preventDefault(); alert('Settings Saved Localhost');">
                    <div class="form-group">
                        <label>ESP32 Device ID</label>
                        <input type="text" value="AGRI-NODE-2026-X1" readonly>
                    </div>
                    <div class="form-group">
                        <label>Data Update Frequency</label>
                        <select>
                            <option>Every 5 Minutes</option>
                            <option>Every 15 Minutes</option>
                            <option>Every Hour</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cloud API Key</label>
                        <input type="password" value="************************">
                    </div>
                    <button type="submit" class="export-btn" style="background: var(--accent);">Save Changes</button>
                </form>
            </div>

            <div class="report-preview">
                <h3>Current Cycle Analysis</h3>
                <p style="font-size: 0.8rem; color: var(--secondary);">Report generated on: <?php echo date('F d, Y'); ?></p>
                
                <div style="height: 300px; margin: 2rem 0;">
                    <canvas id="reportChart"></canvas>
                </div>

                <div class="stats-grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="card" style="padding: 15px; border: 1px solid #eee; box-shadow: none;">
                        <h3 style="font-size: 0.7rem;">AVG MOISTURE</h3>
                        <div class="value" style="font-size: 1.2rem;">44.2%</div>
                    </div>
                    <div class="card" style="padding: 15px; border: 1px solid #eee; box-shadow: none;">
                        <h3 style="font-size: 0.7rem;">TOTAL WATERING</h3>
                        <div class="value" style="font-size: 1.2rem;">12 Liters</div>
                    </div>
                </div>

                <p style="font-size: 0.75rem; color: #888; margin-top: 2rem; border-top: 1px solid #eee; padding-top: 1rem;">
                    This document is an official data log from the AgriFlow IoT Hydration System.
                </p>
            </div>
        </div>
    </main>

    <script>
        const ctx = document.getElementById('reportChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Water Usage (L)',
                    data: [12, 19, 3, 5, 2, 3, 9],
                    backgroundColor: '#2e7d32',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>