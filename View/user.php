<table>
    <tr>
        <td>Nama</td>
        <td>Email</td>
        <td>Password</td>
        <td>Action</td>
    </tr>
    <?php foreach($user as $u): ?>
    <tr>
        <td><?= $u['username']?></td>
        <td><?= $u['email']?></td>
        <td><?= $u['password']?></td>
        <td><a href="/mvc/formedit?id=<?= htmlspecialchars($u['user_id']) ?>">Edit</a>
            <a href="/mvc/delete?id=<?= htmlspecialchars($u['user_id']) ?>">Delete</a></td>
    </tr>
    <?php endforeach;?>
</table>