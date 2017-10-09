<!DOCTYPE HTML>
<html>
  <head>
    <title>Tambah Makanan</title>
    <link rel="shotchut icon" href="../img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
  </head>
  <body>
    <?php
      ob_start();
      session_start();
      require_once "../konfigurasi.php";
      require_once "../functions.php";
    ?>
    <div class="container">
      <div class="row">
        <div style="top: 10px;" class="col-md-6 col-md-offset-3 login">
          <div class="header">
            <center><h1>Tambah Makanan</h1></center>
          </div>
          <hr style="margin: 0 -15px 20px;">
          <form class="form-horizontal" role="form" action="aksi.php?aksi=tambah&n_data=makanan" method="post">
            <div class="form-group">
              <label for="email" class="col-md-3 col-md-offset-1 control-label">Nama</label>
              <div class="col-md-7">
                <input name="nama" type="text" class="form-control" placeholder="nama">
              </div>
            </div>
            <div class="form-group">
              <label for="alamat" class="col-md-3 col-md-offset-1 control-label">Deskripsi</label>
              <div class="col-md-7">
                <textarea rows="5" name="deskripsi" class="textarea" style="width: 100%;"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Harga</label>
              <div class="col-md-7">
                <input name="harga" type="text" class="form-control" placeholder="0">
              </div>
            </div>

            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">potongan</label>
              <div class="col-md-7">
                <input name="potongan" type="text" class="form-control" placeholder="0">
              </div>
            </div>
            <input name="posted" type="hidden" class="form-control" value="<?php echo $_SESSION['id'];?>">
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Jenis</label>
              <div class="col-md-7">
                <select name="jenis" class="form-control">
                  <option value="makanan">makanan</option>
                  <option value="minuman">minuman</option>"
                </select>
              </div>
            </div>
            <input type="hidden" name="posted" value="<?php echo $_SESSION['nama']; ?>">
            <input type="hidden" name="update" value="">
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label"></label>
              <div class="col-md-7">
                <input type="submit" class="btn btn-primary" value="TAMBAH">
                </form>
                <a href="../admin.php?page=makanan" class="btn btn-primary">KEMBALI</a>
              </div>
            </div>

        </div>
      </div>
    </div>
  </body>
</html?
