
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>MVC Tanjidor</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= asset('stisla-1-2.2.0/dist/assets/modules/bootstrap/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?= asset('stisla-1-2.2.0/dist/assets/modules/fontawesome/css/all.min.css')?>">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= asset('stisla-1-2.2.0/dist/assets/css/style.css')?>">
  <link rel="stylesheet" href="<?= asset('stisla-1-2.2.0/dist/assets/css/components.css')?>">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi">Tanjidor</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi">T</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Me And U</li>
            <li class=active><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi"><i class="fas fa-fire"></i> <span>Getting Started</span></a></li>
            <li class="menu-header">Starter</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Model</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/omodel">Old Model</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/nmodel">New Model</a></li>
              </ul>
            </li>
            <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/controller"><i class="far fa-square"></i> <span>Controller</span></a></li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Support</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/asset">Asset</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/auth">AuthMiddleware</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/cors">Cors</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/crypto">Crypto</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/csrf">Csrf</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/datatable">Data table</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/date">Date</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/http">Http</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/mailer">Mailer</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/ratelimiter">Rate Limiter</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/request">Request</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/response">Response</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/uuid">UUID</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/validator">Validator</a></li>
                <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/support/view">View</a></li>
              </ul>
            </li>
            <!-- <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/config"><i class="far fa-square"></i> <span>Config</span></a></li> -->
            <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/view"><i class="far fa-square"></i> <span>View</span></a></li>
            <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/route"><i class="far fa-square"></i> <span>Route</span></a></li>
            <li><a class="nav-link" href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/env"><i class="far fa-square"></i> <span>ENV</span></a></li>
            
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <?= $content ?>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/modules/jquery.min.js')?>"></script>
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/modules/popper.js')?>"></script>
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/modules/tooltip.js')?>"></script>
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/modules/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/modules/nicescroll/jquery.nicescroll.min.js')?>"></script>
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/modules/moment.min.js')?>"></script>
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/js/stisla.js')?>"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/js/scripts.js')?>"></script>
  <script src="<?= asset('stisla-1-2.2.0/dist/assets/js/custom.js')?>"></script>
</body>
</html>