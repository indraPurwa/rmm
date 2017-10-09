<?php
  ob_start();
  session_start();
  @ $page = $_GET['page'];
  if($page == "")
    $page = "home";
  require_once "konfigurasi.php";
  require_once "functions.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <title>RUMAH MAKAN MAHASISWA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shotchut icon" href="img/favicon.png">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/rmm.css" rel="stylesheet">
    <link href="css/menu-review.css" rel="stylesheet">
  </head>
  <body>
    <div class="container main-frame">
      <div class="row header">
        <div class="col-md-6">
          <div class="media">
            <a class="pull-left">
              <img style="height:150px;margin-bottom: 10px; width:150px;" class="media-object" src="img\11779865_1088352257849247_1573709096002270238_o.gif">
            </a>
            <div>
              <h1 class="brand">Rumah Makan Mahasiswa</h1>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <img class="iklan-top img img-responsive" src="img\d49b113203ce3d87360137fb880fbcaa34966340.jpg">
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
          <a class="navbar-brand" href="?page=home">RMM</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav nav-pills navbar-nav">
            <li><a href="?page=makanan">Makanan</a></li>
            <li><a href="?page=minuman">Minuman</a></li>
            <li><a href="?page=tentang">Tentang Kami</a></li>
            <li><a href="?page=hubungi">Hubungi Kami</a></li>
            <li><a href="?page=panduan">Panduan Belanja</a></li>
            <?php
              if(cek_session("email") != "")
                echo "<li><a href=\"?page=keranjang\">Keranjang</a></li>";
            ?>
          </ul>
          <?php
            if(cek_session("nama")) {
              echo "<a class=\"btn btn-default pull-right\" href=\"logout.php\">Logout</a>";
              if(cek_session('akses')){
                if ($_SESSION['akses'] == 'admin' || $_SESSION['akses'] == 'karyawan') {
                  echo "<a class=\"btn btn-default pull-right\" href=\"admin.php\">Admin Area</a>";
                }
              }
              echo "<button class=\"btn btn-default pull-right\">Hi, ".$_SESSION['nama']."</button>";
            } else {
              echo "<a class=\"btn btn-default pull-right\" href=\"form-login.php\">Login</a>";
            }
          ?>
        </div>
      </nav>
      <?php
      if($page == "home") {
        echo "<div id=\"MyCarousel\" class=\"carousel slide\">
          <ol class=\"carousel-indicators\">";
            $i = 0;
            $act = 0;
            $data = $conn->query("SELECT id from tmakanan ORDER BY post DESC limit 0, 5");
            if($data != NULL ){
              while ($menu = $data->fetch_assoc()) {
                $active = "";
                if($act == 0)
                  $active = "active";
                echo "<li class=\"".$active."\" data-target=\"#MyCarousel\" data-slide-to=\"".$i."\"></li>";
                $i++;
                $act++;
              }
            }
          echo "</ol>
          <div class=\"carousel-inner\">";
            $act = 0;
            $data = $conn->query("SELECT id, nama from tmakanan ORDER BY post DESC limit 0, 5");
            if($data != NULL ){
              while ($menu = $data->fetch_assoc()) {
                $id = $menu['id'];
                $foto = $conn->query("SELECT * FROM foto_mkn WHERE id_mkn = $id limit 0, 1");
                $foto = $foto->fetch_assoc();
                $active = "";
                if($act == 0)
                  $active = "active";
                echo "<div class=\"item ".$active."\">
                  <img src=\"img/menu/".$foto['nama_foto']."\" alt='Gambar Makanan'>
                  <div class=\"carousel-caption\"><h2><a href=\"?page=view&id=".$id."\">".$menu['nama']."</a></h2></div>
                </div>";
                $act++;
              }
            }
          echo "</div>
              <a class=\"carousel-control left\" href=\"#MyCarousel\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-menu-left\"></span></a>
              <a class=\"carousel-control right\" href=\"#MyCarousel\" data-slide=\"next\"><span class=\"glyphicon glyphicon-menu-right\"></span></a>
            </div>";
      }
      ?>

      <div class="row content">
        <div class="col-md-8 right-side">
          <!--sub-page-->
          <?php
            if($page == "home")
              include 'sub-page/sub-index.php';
            elseif ($page == "makanan")
              include 'sub-page/sub-makanan-tab.php';
            elseif ($page == "minuman")
              include 'sub-page/sub-minuman-tab.php';
            elseif ($page == "tentang")
              include 'sub-page/sub-kami-tab.php';
            elseif ($page == "hubungi")
                include 'sub-page/hubungi.php';
            elseif ($page == "view")
              include 'sub-page/sub-menu-view.php';
            elseif ($page == "panduan")
              include 'sub-page/panduan.php';
            elseif ($page == "panduan-daftar")
              include 'sub-page/panduan-mendaftar.php';
            elseif ($page == "keranjang")
              include 'sub-page/sub-keranjang.php';

           ?>
          <!--sub-page-->
        </div>
        <div class="col-md-4 left-side">
          <div class="row">
            <div class="col-md-12">
                <div class="title"><span class="title-text">Iklan</span></div>
            </div>
            <div class="col-md-12 iklan">
              <a href=""><img class="img img-responsive" src="img\1512131_10151891325880843_1259508154_o.png"></a>
            </div>
            <div class="col-md-12">
              <div class="title title-right-side"><span class="title-text">Top Order</span></div>
            </div>
            <div class="col-md-12">
              <?php
                $top = $conn->query("SELECT id, tmakanan.nama, sum(mkn_pesan.jumlah) AS jumlah FROM tmakanan left outer join mkn_pesan on tmakanan.id = mkn_pesan.id_makanan group by tmakanan.id ORDER BY `jumlah` DESC limit 0 , 5");
                while($to = $top->fetch_assoc()){
                  echo "<a href=\"?page=view&id=".$to['id']."\" class=\"list-group-item\">".$to['nama']." <span class=\"badge\">".$to['jumlah']."</span></a>";
                }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="jumbotron">
        <div class="row sertifikat">
          <div class="col-md-3"><img class="sertifikat-img" src="img\halal-mui.png"></div>
          <div class="col-md-3"><img class="sertifikat-img" src="img\totv-2.png"></div>
          <div class="col-md-3"><img class="sertifikat-img" src="img\LOGO-POS-INDONESIA.png"></div>
          <div class="col-md-3" style="padding-left: 50px;"><img class="sertifikat-img" src="img\logotiki.png"></div>
        </div>
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
<?php ob_start(); ?>
