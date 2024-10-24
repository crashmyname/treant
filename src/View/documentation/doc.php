
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Treant MVC</title>

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
            <a href="<?= base_url()?>">Treant</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url()?>">T</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Me And U</li>
            <li class="<?= $title == "Get Started" ? "active" : ""?>"><a class="nav-link" href="<?= base_url()?>/dokumentasi"><i class="fas fa-fire"></i> <span>Getting Started</span></a></li>
            <li class="menu-header">Starter</li>
            <li class="<?= $title == "CLI" ? "active" : ""?>"><a class="nav-link" href="<?= route('cli')?>"><i class="fas fa-fire"></i> <span>CLI</span></a></li>
            <li class="<?= $title == "ORM" ? "active" : ""?>"><a class="nav-link" href="<?= route('orm')?>"><i class="fas fa-fire"></i> <span>ORM</span></a></li>
            <li class="dropdown <?= $title == "Old Model" || $title == "New Model" ? "active" : ""?>">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Model</span></a>
              <ul class="dropdown-menu">
                <li class="<?= $title == "Old Model" ? "active" : ""?>"><a class="nav-link" href="<?= route('old-model') ?>">Old Model</a></li>
                <li class="<?= $title == "New Model" ? "active" : ""?>"><a class="nav-link" href="<?= route('new-model')?>">New Model</a></li>
              </ul>
            </li>
            <li class="<?= $title == "Controller" ? "active" : ""?>"><a class="nav-link" href="<?= route('controller')?>"><i class="far fa-square"></i> <span>Controller</span></a></li>
            <li class="dropdown <?= $title == "Asset" || $title == "Auth" || $title == "Cors" || $title == "Crypto" || $title == "DataTable" || $title == "Date" || $title == "Http" || $title == "Mailer" || $title == "Rate Limiter" || $title == "Request" || $title == "Response" || $title == "UUID" || $title == "Validator" || $title == "CSRF" ? "active" : ""?>">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Support</span></a>
              <ul class="dropdown-menu">
                <li class="<?= $title == "Asset" ? "active" : ""?>"><a class="nav-link" href="<?= route('asset')?>">Asset</a></li>
                <li class="<?= $title == "Auth" ? "active" : ""?>"><a class="nav-link" href="<?= route('auth')?>">AuthMiddleware</a></li>
                <li class="<?= $title == "Cors" ? "active" : ""?>"><a class="nav-link" href="<?= route('cors')?>">Cors</a></li>
                <li class="<?= $title == "Crypto" ? "active" : ""?>"><a class="nav-link" href="<?= route('crypto')?>">Crypto</a></li>
                <li class="<?= $title == "CSRF" ? "active" : ""?>"><a class="nav-link" href="<?= route('csrf')?>">Csrf</a></li>
                <li class="<?= $title == "DataTable" ? "active" : ""?>"><a class="nav-link" href="<?= route('datatable')?>">Data table</a></li>
                <li class="<?= $title == "Date" ? "active" : ""?>"><a class="nav-link" href="<?= route('date')?>">Date</a></li>
                <li class="<?= $title == "Http" ? "active" : ""?>"><a class="nav-link" href="<?= route('http')?>">Http</a></li>
                <li class="<?= $title == "Mailer" ? "active" : ""?>"><a class="nav-link" href="<?= route('mailer')?>">Mailer</a></li>
                <li class="<?= $title == "Rate Limiter" ? "active" : ""?>"><a class="nav-link" href="<?= route('ratelimiter')?>">Rate Limiter</a></li>
                <li class="<?= $title == "Request" ? "active" : ""?>"><a class="nav-link" href="<?= route('request')?>">Request</a></li>
                <li class="<?= $title == "Response" ? "active" : ""?>"><a class="nav-link" href="<?= route('response')?>">Response</a></li>
                <li class="<?= $title == "UUID" ? "active" : ""?>"><a class="nav-link" href="<?= route('uuid')?>">UUID</a></li>
                <li class="<?= $title == "Validator" ? "active" : ""?>"><a class="nav-link" href="<?= route('validator')?>">Validator</a></li>
              </ul>
            </li>
            <li class="<?= $title == "View" ? "active" : ""?>"><a class="nav-link" href="<?= route('view')?>"><i class="far fa-square"></i> <span>View</span></a></li>
            <li class="<?= $title == "Route" ? "active" : ""?>"><a class="nav-link" href="<?= route('route')?>"><i class="far fa-square"></i> <span>Route</span></a></li>
            <li class="<?= $title == "Env" ? "active" : ""?>"><a class="nav-link" href="<?= route('env')?>"><i class="far fa-square"></i> <span>ENV</span></a></li>
            
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