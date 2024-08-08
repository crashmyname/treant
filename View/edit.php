<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <form action="/mvc/update?id=<?= htmlspecialchars($user['user_id'])?>" id="" method="POST">
        nama : <input type="text" name="username" id="username" value="<?= $user['username']?>"><br>
        email : <input type="email" name="email" id="email" value="<?= $user['email']?>"><br>
        password : <input type="password" name="password" id="password" value="<?= $user['password']?>"><br>
        <button type="submit" name="add" id="add">Submit</button>
    </form>
</body>
</html>