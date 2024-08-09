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
  ```
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
```
  <?php
    require_once __DIR__ . '/bin/support/Request.php';
    require_once __DIR__ . '/bin/support/View.php';
    require_once __DIR__ . '/bin/support/Asset.php';
    <!-- Tambahkan Controller dan Model dibawah untuk code diatas jangan diubah atau di oprek karena helpers untuk menjalankan suatu function -->
    require_once __DIR__ . '/Controller/UserController.php';
    require_once __DIR__ . '/Model/UserModel.php';

    $action = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $request = new Request();
    <!-- Tambahkan controller yang dipanggil diatas tadi seperti code dibawah ini -->
    $userController = new UserController();

    <!-- Contoh Penggunaan Routenya tambahkan saja case yang anda ingin buat misalkan case '/yourproject/product' 
    terus arahkan ke controller mana dengan function apa misal $productController->product();
    -->
    switch ($action) {
        case '/mvc/user':
            $userController->index();
            break;
        case '/mvc/store':
            $userController->store($request);
            break;
        case '/mvc/formedit':
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $userController->getUserId(base64_decode($id));
            break;
        case '/mvc/update':
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $userController->update($request,$id);
            break;
        case '/mvc/delete':
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $userController->delete(base64_decode($id));
            break;
        default:
            // include __DIR__ . '/View/home.php';
            View::render('home',[],'layout');
            break;
    }
    ?>
```
## View
- Basic View, disini view menggunakan support View.php jadi user bisa mengembalikan atau mengarahkan ke halaman mana ajah dengan support ini misalnya.
```
View::render('home',[],'layout'); <-- maksud dari code ini adalah kita mengarahkan kehalaman home, [] <-- tidak membawa parameter, 'layout' <-- jika memisahkan navbar dengan content

bisa juga menggunakan
View::redirectTo('/mvc/user'); <-- fungsi ini mengarahkan ke route misalkan /mvc/product <-- akan mengarahkan ke route product

dan bisa menggunakan basic
include __DIR__.'/../View/user.php'; <-- akan mengarahkan ke halaman user yang berada pada folder View;
```
## index.php
- index.php adalah route disini jadi pastiin jangan lupa menambahkan route nya supaya appsnya bisa berjalan oke sip mantap AKMJ

Terima gaji
## Contact

- [Email](mailto:fadliazkaprayogi1@gmail.com)
- [LinkedIn](https://www.linkedin.com/in/fadli-azka-prayogi-523879176/)
