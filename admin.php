<?php
  ob_start();
  session_start();
  @ $page = $_GET['page'];
  if($page == "")
    $page = "pesanan";
  require_once "konfigurasi.php";
  require_once "functions.php";
  if ($_SESSION['akses'] == "admin" || $_SESSION['akses'] == "karyawan") {
  ?>
    <!DOCTYPE HTML>
    <html>
      <head>
        <title>ADMIN AREA</title>
        <link rel="shotchut icon" href="img/favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/admin.css" rel="stylesheet">
      </head>
      <body>
        <div class="container main-frame">
          <div class="row header">
            <div class="col-md-6">
              <h1 class="brand">Rumah Makan Mahasiswa</h1>
            </div>
            <div class="col-md-4 pull-right">
              <p style="text-align:center;">Selamat datang <span><?php echo $_SESSION['nama']; ?></span><br>Anda Login sebagai <span><?php echo $_SESSION['akses']; ?></span></p>
            </div>
          </div>
          <nav class="navigasi navbar navbar-default" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">RMM</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
              <ul class="nav nav-pills navbar-nav">
                <li><a href="?page=pesanan">Pesanan</a></li>
                <?php
                  if($_SESSION['akses'] == "admin") {
                    echo '<li><a href="?page=makanan">Kelola Makanan</a></li>
                    <li><a href="?page=user">Kelola User</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <b class="caret"></b> </a>
                      <ul class="dropdown-menu">
                        <li><a href="?page=lapor-makanan">Makanan</a></li>
                        <li><a href="?page=lapor-pelanggan">Pelanggan</a></li>
                      </ul>
                    </li>';
                  }
                 ?>
              </ul>
              <div class="login-logout pull-right">
                <a class="btn btn-primary" href="logout.php">LOGOUT</a>
              </div>
            </div>
          </nav>
          <div class="row">
            <!--frame-page-->
            <?php
              if($page == "pesanan")
                include "sub-page\sub-daftar-pesanan.php";

              else if($page == "makanan")
                include 'sub-page\kelola-makanan.php';
              else if($page == "user")
                  include 'sub-page\kelola-user.php';

              elseif ($page == 'lapor-pelanggan')
                include "sub-page/laporan-pelanggan.php";
              elseif($page == 'lapor-makanan')
                include "sub-page/laporan-makanan.php";
              elseif ($page == 'lapor-karyawan')
                include "sub-page/laporan-karyawan.php";
            ?>
          </div>
          <div class="row footer">
            <div class="col-md-6">
              <span>Designed By: Indra Purwa Laksana</span>
            </div>
            <div class="col-md-6">
              <span>Copyright &copy; 2016 Rumah Makan Mahasiswa</span>
            </div>
          </div>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
      </body>
    </html>
<?php
  }
  else {
    echo '<script>alert("Data Tidak memiliki hak untuk mengakses Halaman ini");window.location = history.back();</script>';
  }
?>
