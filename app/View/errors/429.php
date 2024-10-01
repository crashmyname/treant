<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>429 Too Many Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .not-found-container {
            text-align: center;
        }
        .not-found-container h1 {
            font-size: 10rem;
            margin-bottom: 0;
            color: #343a40;
        }
        .not-found-container p {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #6c757d;
        }
        .not-found-container a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="not-found-container">
    <h1>429</h1>
    <h3>Too Many Requests</h3>
    <p>Sorry! Too Many Requests. Please try again later.</p>
    <a href="<?= base_url()?>" class="btn btn-primary">Go Home</a>
</div>

</body>
</html>
