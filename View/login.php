<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form</title>
    <link href="<?= $_ENV['ROUTE_PREFIX'].'/node_modules/bootstrap/dist/css/bootstrap.min.css'?>" rel="stylesheet">
    <script src="<?= $_ENV['ROUTE_PREFIX'].'/node_modules/sweetalert2/dist/sweetalert2.all.min.js'?>"></script>
  </head>
  <body>
    <h1>Hello, Hell!</h1>
    <?php if(isset($error_m)): ?>
    <script>
        Swal.fire({
            title: 'Failed',
            icon: 'error',
            text: '<?= $error_m; ?>'
        });
    </script>
    <?php endif; ?>
    <form action="<?= $_ENV['ROUTE_PREFIX']?>/login" id="" method="POST">
        <div class="card container-fluid ms-auto">
            email : <input type="email" class="form-control" name="email" id="email"required><br>
            password : <input type="password" class="form-control" name="password" id="password"required><br>
            <button type="submit" name="add" class="btn btn-success" id="add">Submit</button>
        </div>
    </form><br>
    <a href="<?= $_ENV['ROUTE_PREFIX']?>/user" class="btn btn-info">data</a>
    <script src="<?= $_ENV['ROUTE_PREFIX'].'/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'?>"></script>
  </body>
</html>