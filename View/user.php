<!doctype html>
<html lang="en">
<?php 
echo $_SESSION['user_id'];
echo $_SESSION['username'];
echo $_SESSION['email'];
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
    <h1>Daftar Pengguna</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $field => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    <li><?php echo htmlspecialchars($message); ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<a href="/mvc/adduser" class="btn btn-secondary">Tambah Pengguna</a>
<table id="datatable" class="table">
    <tr>
        <td>Nama</td>
        <td>Email</td>
        <td>Password</td>
        <td>Action</td>
    </tr>
    <?php foreach($user as $u): ?>
    <tr>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['password']) ?></td>
        <td><a href="<?= $_ENV['ROUTE_PREFIX']?>/formedit?id=<?= base64_encode($u['user_id']) ?>" class="btn btn-warning">Edit</a>
            <a href="<?= $_ENV['ROUTE_PREFIX']?>/delete?id=<?= base64_encode($u['user_id']) ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin ingin dihapus?')">Delete</a>
        </td>
    </tr>
    <?php endforeach;?>
</table>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
