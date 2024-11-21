<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Occurred</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f2f6;
            color: #333;
        }
        .hero {
            background-color: #F95454;
            color: #fff;
            padding: 40px;
            text-align: center;
        }
        .hero h1 {
            margin: 0;
            font-size: 42px;
        }
        .hero p {
            margin: 10px 0 0;
            font-size: 18px;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            background-color: #3498db;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .error-section {
            display: none;
            margin-top: 20px;
        }
        .error-section pre {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow-x: auto;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #7f8c8d;
        }
    </style>
    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.style.display = section.style.display === 'none' || section.style.display === '' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <div class="hero">
        <h1><?= htmlspecialchars($message ?? 'Unknown Error') ?></h1>
        <p>An unexpected error occurred. Please check the details below.</p>
    </div>

    <div class="container">
        <h2>Error Summary</h2>
        <p><strong>Message:</strong> <?= htmlspecialchars($message ?? 'Unknown') ?></p>
        <p><strong>File:</strong> <?= htmlspecialchars($file ?? 'Unknown') ?></p>
        <p><strong>Line:</strong> <?= htmlspecialchars($line ?? 'Unknown') ?></p>

        <div class="btn-group">
            <button class="btn" onclick="toggleSection('trace')">View Trace</button>
            <button class="btn" onclick="toggleSection('query')">View Query</button>
            <button class="btn" onclick="toggleSection('route')">View Route</button>
            <button class="btn" onclick="toggleSection('response')">View Response</button>
        </div>

        <div id="trace" class="error-section">
            <h3>Trace Details</h3>
            <pre><?= htmlspecialchars($trace ?? 'No trace available') ?></pre>
        </div>

        <div id="query" class="error-section">
            <h3>Query Details</h3>
            <pre><?= htmlspecialchars($query ?? 'No query information available') ?></pre>
        </div>

        <div id="route" class="error-section">
            <h3>Route Details</h3>
            <pre><?= htmlspecialchars($route ?? 'No route information available') ?></pre>
        </div>

        <div id="response" class="error-section">
            <h3>Response Details</h3>
            <pre><?= htmlspecialchars($response ?? 'No response information available') ?></pre>
        </div>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Your Application. All rights reserved.
    </footer>
</body>
</html>
