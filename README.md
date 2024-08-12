# MVC Tanjidor ✨

## Struktur Folder
- [bin]
- [config]
- [Model]
- [public]
- [storage]
- [View]
- .htacces
- index.php

## .env ✨
- File ini untuk mengkoneksikan ke database ya adik adik jadi untuk mengisi database nya ada disini
## Model
- Model untuk database karena basisnya mvc ala ala jadi jangan lupa buat model crud dulu
## public
- Didalam folder public ini diisikan asset template, gambar dan lainnya.
  cara penggunaannya simple.
  ```php
  untuk mengakses image
  <img src="<?= asset('yourasset.jpg') ?>" alt="">

  untuk menagkses template
  <link rel="stylesheet" href="<?= asset('adminlte/bootstrap.min.css') ?>">
  <script src="<?= asset('adminlte/js/bootstrap.min.js') ?>"></script>
  
  ```
  atau lainnya bisa diakses di menu public.
## Controller
- Controller Action untuk melakukan action misalkan ada kondisi dan lain sebagainya
## route
- Route adalah tujuan url yang mengarahkan ke suatu module atau view, jadi semua diarahkan melalui route bukan melalui file.php
```php
  <?php
    require_once __DIR__ . '/bin/support/Request.php';
    require_once __DIR__ . '/bin/support/View.php';
    require_once __DIR__ . '/bin/support/Asset.php';
    $envFile = __DIR__ . '/.env';
    <!-- Tambahkan Controller dan Model dibawah untuk code diatas jangan diubah 
    atau di oprek karena helpers untuk menjalankan suatu function -->
    require_once __DIR__ . '/Controller/UserController.php';
    require_once __DIR__ . '/Model/UserModel.php';

    $env = parse_ini_file($envFile);

    foreach ($env as $key => $value) {
        $_ENV[$key] = $value;
    }

    if (isset($_ENV['ROUTE_PREFIX']) && !empty($_ENV['ROUTE_PREFIX'])) {
        $prefix = $_ENV['ROUTE_PREFIX'];
    } else {
        // Tampilkan pesan kesalahan atau log jika variabel tidak ada
        throw new Exception('Variabel lingkungan ROUTE_PREFIX tidak ditemukan atau kosong.');
    }
    // Code diatas adalah untuk memparsing ROUTEPREFIX yang ada pada .env untuk route_prefix diisi dengan nama projek masing masing yang ada pada file .env
    $request = new Request();
    $route = new Route($prefix);
    <!-- Tambahkan controller yang dipanggil diatas tadi seperti code dibawah ini -->
    $userController = new UserController();

    <!-- Contoh Penggunaan Routenya dibawah get untuk melakukan get dan post untuk melakukan post,
    untuk case delete kenapa menggunakan get karena dia mengambil id nya untuk dihapus dalam fungsi
    untuk tambah atau update menggunakan post, $route->get / $route->post untuk kedua ada data yang
    dikirimkan data pertama yaitu url yang dituju, yang kedua masukkan controller serta actionnya jika
    ada controller lain contoh [$productController, 'product'], dan jangan lupa lakukan pemanggilan
    require_once __DIR__ . '/Controller/ProductController.php';
    dan $productController = new ProductController();
    -->
    $route->get('/', [$userController, 'index']);
    $route->get('/user', [$userController, 'index']);
    $route->get('/adduser', [$userController, 'adduser']);
    $route->get('/formedit', function() use ($userController, $request) {
        $id = $request->id ? base64_decode($request->id) : null;
        $userController->getUserId($id);
    });
    $route->get('/delete', function() use ($userController, $request) {
        $id = $request->id ? base64_decode($request->id) : null;
        $userController->delete($id);
    });

    // Menambahkan rute POST
    $route->post('/store', function() use ($userController, $request) {
        $userController->store($request);
    });
    $route->post('/update', function() use ($userController, $request) {
        $id = $request->id ? base64_decode($request->id) : null;
        $userController->update($request, $id);
    });

    // Menjalankan route
    $route->dispatch();
    ?>
```
## View
- Basic View, disini view menggunakan support View.php jadi user bisa mengembalikan atau mengarahkan ke halaman mana ajah dengan support ini misalnya.
```php
View::render('home',[],'layout'); <-- maksud dari code ini adalah kita mengarahkan kehalaman home,
[] <-- tidak membawa parameter, 'layout' <-- jika memisahkan navbar dengan content

bisa juga menggunakan
View::redirectTo('/mvc/user'); <-- fungsi ini mengarahkan ke route misalkan /mvc/product <-- akan 
mengarahkan ke route product

dan bisa menggunakan basic
include __DIR__.'/../View/user.php'; <-- akan mengarahkan ke halaman user yang berada pada folder View;
```
## route.php
- route.php adalah route disini jadi pastiin jangan lupa menambahkan route nya supaya appsnya bisa berjalan 
oke sip mantap AKMJ

Terima gaji
## Contact

- [Email](mailto:fadliazkaprayogi1@gmail.com)
- [LinkedIn](https://www.linkedin.com/in/fadli-azka-prayogi-523879176/)
