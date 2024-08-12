<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
    <h1>Update</h1>
    <a href="<?= $_ENV['ROUTE_PREFIX']?>/user" class="btn btn-secondary">Back</a>
    <form action="<?= $_ENV['ROUTE_PREFIX']?>/update?id=<?= htmlspecialchars($user['user_id'])?>" id="" method="POST">
        nama : <input type="text" class="form-control" name="username" id="username" value="<?= $user['username']?>"><br>
        email : <input type="email" class="form-control" name="email" id="email" value="<?= $user['email']?>"><br>
        password : <input type="password" class="form-control" name="password" id="password" value="<?= $user['password']?>"><br>
        <button type="submit" name="add" class="form-control" id="add">Submit</button>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>