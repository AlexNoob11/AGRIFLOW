<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Simulated real-time values
$moisture = 42; 
$temp = 28;
$humidity = 65;
$last_update = date("H:i:s");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriflow | Sensor Monitoring</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .monitoring-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 1rem;
        }

        .sensor-card {
            background: white;
            padding: 2rem;
            border-radius: 24px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }

        /* Circular Progress Visual */
        .gauge-container {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gauge-svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .gauge-bg { fill: none; stroke: #edf2ed; stroke-width: 10; }
        .gauge-fill { 
            fill: none; stroke: var(--accent); stroke-width: 10; 
            stroke-linecap: round; transition: stroke-dasharray 1s ease;
        }

        .gauge-value {
            position: absolute;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text);
        }

        .sensor-label { font-size: 1.1rem; font-weight: 600; color: var(--secondary); margin-bottom: 0.5rem; }
        .status-dot { height: 8px; width: 8px; background: #4caf50; border-radius: 50%; display: inline-block; margin-right: 5px; }
        
        .data-meta { 
            display: flex; justify-content: space-between; 
            margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #eee;
            font-size: 0.85rem; color: var(--secondary);
        }

        .refresh-tag { font-size: 0.75rem; background: #f0f0f0; padding: 4px 10px; border-radius: 20px; }
    </style>
</head>
<body>

    <?php include('sidebar/sidebar.php'); ?>

    <main>
        <header>
            <div>
                <h1>Sensor Monitoring</h1>
                <p style="color: var(--secondary);">Live telemetry from ESP32 Node 01</p>
            </div>
            <div class="refresh-tag">Last Synced: <?php echo $last_update; ?></div>
        </header>

        <div class="monitoring-grid">
            <div class="sensor-card">
                <div class="sensor-label">Soil Moisture</div>
                <div class="gauge-container">
                    <svg class="gauge-svg" viewBox="0 0 100 100">
                        <circle class="gauge-bg" cx="50" cy="50" r="45"></circle>
                        <circle class="gauge-fill" cx="50" cy="50" r="45" 
                                style="stroke-dasharray: <?php echo ($moisture / 100) * 283; ?>, 283;"></circle>
                    </svg>
                    <div class="gauge-value"><?php echo $moisture; ?>%</div>
                </div>
                <div style="color: <?php echo $moisture < 35 ? '#d32f2f' : '#2e7d32'; ?>; font-weight: 600;">
                    <?php echo $moisture < 35 ? '⚠️ Needs Water' : '✅ Optimal Hydration'; ?>
                </div>
                <div class="data-meta">
                    <span>Range: 0-100%</span>
                    <span>Sensor: Capacitive V2</span>
                </div>
            </div>

            <div class="sensor-card">
                <div class="sensor-label">Ambient Temperature</div>
                <div style="font-size: 4rem; margin: 1rem 0; color: #f57c00;">
                    <?php echo $temp; ?><span style="font-size: 1.5rem; vertical-align: top;">°C</span>
                </div>
                <p style="color: var(--secondary);">Conditions: Warm / Sunny</p>
                <div class="data-meta">
                    <span>Range: -40 to 80°C</span>
                    <span>Sensor: DHT22</span>
                </div>
            </div>

            <div class="sensor-card">
                <div class="sensor-label">Air Humidity</div>
                <div class="gauge-container">
                    <svg class="gauge-svg" viewBox="0 0 100 100">
                        <circle class="gauge-bg" cx="50" cy="50" r="45" style="stroke: #e3f2fd;"></circle>
                        <circle class="gauge-fill" cx="50" cy="50" r="45" 
                                style="stroke: #1976d2; stroke-dasharray: <?php echo ($humidity / 100) * 283; ?>, 283;"></circle>
                    </svg>
                    <div class="gauge-value" style="color: #1976d2;"><?php echo $humidity; ?>%</div>
                </div>
                <p style="color: var(--secondary);">Vapor Pressure: Balanced</p>
                <div class="data-meta">
                    <span>Range: 0-100% RH</span>
                    <span>Sensor: DHT22</span>
                </div>
            </div>
        </div>

        <div class="sensor-card" style="margin-top: 2rem; text-align: left; padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center;">
                    <span class="status-dot"></span>
                    <b style="font-size: 0.9rem;">ESP32 Connection: Strong</b>
                </div>
                <span style="font-size: 0.8rem; color: var(--secondary);">Signal Strength: -65dBm</span>
            </div>
        </div>
    </main>

</body>
</html>