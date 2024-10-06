<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            color: #721c24;
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        a {
            color: #0056b3;
            text-decoration: none;
        }
        .error-details {
            background-color: #f8d7da;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404 - Not Found</h1>
        <p>Oops! View Not Found</p>
        <p>Oops! The page you're looking for doesn't exist.</p>

        <!-- Optional: link to homepage -->
        <a href="<?= base_url() ?>">Return to Home</a><br>

        <!-- Detail error untuk debugging (optional) -->
        <div class="error-details">
            <strong>Error:</strong> <?= htmlspecialchars($message ?? 'Unknown error') ?><br>
            <strong>File:</strong> <?= htmlspecialchars($file ?? 'N/A') ?><br>
            <strong>Line:</strong> <?= htmlspecialchars($line ?? 'N/A') ?><br>
            
            <?php if (strpos($exception->getMessage(), 'View file not found') !== false): ?>
                <p>The system could not locate the requested view file. Please make sure the following file exists: <br>
                <strong><?= htmlspecialchars($exception->getMessage()) ?></strong></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
