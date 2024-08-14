<?php 
echo 'Your ID : '.$_SESSION['user_id'].'<br>';
echo 'Username : '.$_SESSION['username'].'<br>';
echo 'Email : '.$_SESSION['email'];
?>
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
        <td>UUID</td>
        <td>Email</td>
        <td>Password</td>
        <td>Action</td>
    </tr>
    <?php foreach($user as $u): ?>
    <tr>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['uuid']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['password']) ?></td>
        <td><a href="<?= $_ENV['ROUTE_PREFIX']?>/formedit?id=<?= $u['edit_link'] ?>" class="btn btn-warning">Edit</a>
            <a href="<?= $_ENV['ROUTE_PREFIX']?>/delete?id=<?= $u['delete_link'] ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin ingin dihapus?')">Delete</a>
        </td>
    </tr>
    <?php endforeach;?>
</table>

    </div>
    <script>
        function refreshTable()
        {
            var routePrefix = "<?php echo $_ENV['ROUTE_PREFIX']; ?>";
            fetch(routePrefix+'/user')
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data,'text/html');
                const newTable = doc.querySelector('#datatable').innerHTML;
                document.querySelector('#datatable').innerHTML = newTable;
            })
            .catch(error=>console.error('error fetching data:', error));
        }
        setInterval(refreshTable, 5000);
    </script>

