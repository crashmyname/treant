    <h1>Hello, Hell!</h1>
    <form action="<?= $_ENV['ROUTE_PREFIX']?>/store" id="" method="POST">
        <div class="card container-fluid ms-auto">

            nama : <input type="text" class="form-control" name="username" id="username"><br>
            email : <input type="email" class="form-control" name="email" id="email"required><br>
            password : <input type="password" class="form-control" name="password" id="password"required><br>
            <button type="submit" name="add" class="btn btn-success" id="add">Submit</button>
        </div>
    </form><br>
    <a href="<?= $_ENV['ROUTE_PREFIX']?>/user" class="btn btn-info">data</a>
    <img src="<?= asset('FAP.png')?>" alt="">