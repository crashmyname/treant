
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
