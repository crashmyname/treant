# Treant MVC ✨
- Update Versi 1.3

## Documentation ✨✨
- Untuk Dokumentasi jelas kunjungi https://crashmyname.github.io/treant
```
git clone https://github.com/crashmyname/treant.git 
- Sekarang bisa menginstall menggunakan composer
composer create-project fadli-dev/treant nama_proyek_baru "v1.3"
```
- Jika sudah di clone kalian akan kehalaman awal MVC ini klik get started untuk membaca dokumentasi lengkap

## Struktur Folder
- [app]
    - [Models]
    - [Handle]
        - [errors]
    - [Controllers]
- [bin]
    - [support]
- [config]
- [logs]
- [node_moduels]
- [public]
- [routes]
- [src]
    - [View]
- [vendor]
- .env
- .env.example
- .htacces
- treant
- index.php
- autoload.php

## .env ✨
- File ini untuk mengkoneksikan ke database ya adik adik jadi untuk mengisi database nya ada disini
- Copy terlebih dahulu .env.example dan rename menjadi .env habis itu start your project
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

  Menambahkan Pretty_print kalian bisa mengganti var_dump dengan menggunakan pretty_print
  pretty_print($data);
  
  ```
  atau lainnya bisa diakses di menu public.
## Controller
- Controller Action untuk melakukan action misalkan ada kondisi dan lain sebagainya
## route
- Route adalah tujuan url yang mengarahkan ke suatu module atau view, jadi semua diarahkan melalui route bukan melalui filetujuan.php
## View
- Basic View, disini view menggunakan support View.php jadi user bisa mengembalikan atau mengarahkan ke halaman mana ajah dengan support ini misalnya.
```php
View::render('home',[],'layout'); <-- maksud dari code ini adalah kita mengarahkan kehalaman home,
[] <-- tidak membawa parameter, 'layout' <-- jika memisahkan navbar dengan content

bisa juga menggunakan
View::redirectTo('/user'); <-- fungsi ini mengarahkan ke route misalkan /mvc/product <-- akan 
mengarahkan ke route product

dan bisa menggunakan basic
include __DIR__.'/../View/user.php'; <-- akan mengarahkan ke halaman user yang berada pada folder View;
```
## route.php
- route.php adalah route disini jadi pastiin jangan lupa menambahkan route nya supaya appsnya bisa berjalan 
oke sip mantap

Terima gaji
## Contact

- [Email](mailto:fadliazkaprayogi1@gmail.com)
- [LinkedIn](https://www.linkedin.com/in/fadli-azka-prayogi-523879176/)
