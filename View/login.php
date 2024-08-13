<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1>Hello, Hell!</h1>
    <form action="<?= $_ENV['ROUTE_PREFIX']?>/login" id="" method="POST">
        <div class="card container-fluid ms-auto">
            email : <input type="email" class="form-control" name="email" id="email"required><br>
            password : <input type="password" class="form-control" name="password" id="password"required><br>
            <button type="submit" name="add" class="btn btn-success" id="add">Submit</button>
        </div>
    </form><br>
    <a href="<?= $_ENV['ROUTE_PREFIX']?>/user" class="btn btn-info">data</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>