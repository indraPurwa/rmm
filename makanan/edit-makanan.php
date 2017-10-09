<!DOCTYPE HTML>
<html>
  <head>
    <title>Edit Makanan</title>
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

      $id = $_GET['id'];
      $query = "SELECT * from tmakanan where id = '$id'";
      $data = $conn->query($query);
      $makanan = $data->fetch_assoc();
    ?>
    <div class="container">
      <div class="row">
        <div style="top: 10px;" class="col-md-6 col-md-offset-3 login">
          <div class="header">
            <center><h1>Edit Makanan</h1></center>
          </div>
          <hr style="margin: 0 -15px 20px;">
          <form class="form-horizontal" role="form" action="aksi.php?aksi=edit&n_data=makanan" method="post">

            <input name="id" type="hidden" class="form-control" value="<?php echo $makanan['id'];?>">
            <div class="form-group">
              <label for="email" class="col-md-3 col-md-offset-1 control-label">Nama</label>
              <div class="col-md-7">
                <input name="nama" type="text" class="form-control" value="<?php echo $makanan['nama'];?>">
              </div>
            </div>
            <div class="form-group">
              <label for="alamat" class="col-md-3 col-md-offset-1 control-label">Deskripsi</label>
              <div class="col-md-7">
                <textarea rows="5" name="deskripsi" class="textarea" style="width: 100%;"><?php echo $makanan['deskripsi'];?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Harga</label>
              <div class="col-md-7">
                <input name="harga" type="text" class="form-control" value="<?php echo $makanan['harga'];?>">
              </div>
            </div>

            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">potongan</label>
              <div class="col-md-7">
                <input name="potongan" type="text" class="form-control" value="<?php echo $makanan['potongan'];?>">
              </div>
            </div>
            <input name="post" type="hidden" class="form-control" value="<?php echo $makanan['post'];?>">
            <input name="posted" type="hidden" class="form-control" value="<?php echo $makanan['posted'];?>">

            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Jenis</label>
              <div class="col-md-7">
                <select name="jenis" class="form-control">
                <?php
                  if($makanan['jenis'] == "makanan") {
                    echo "<option selected value=\"makanan\">makanan</option>
                          <option value=\"minuman\">minuman</option>";
                  }
                  elseif($makanan['jenis'] == "minuman") {
                    echo "<option  value=\"makanan\">makanan</option>
                          <option selected value=\"minuman\">minuman</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label"></label>
              <div class="col-md-7">
                <input type="submit" class="btn btn-primary" value="UPDATE">
                </form>
                <a href="../admin.php?page=makanan" class="btn btn-primary">KEMBALI</a>
              </div>
            </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-12 gambar">
          <center><h2>Gambar Makanan</h1></center>
          <div class="col-md-12">
            <form class="form-inline" role="form" action="aksi.php?aksi=tambah&n_data=foto_mkn" method="post" enctype="multipart/form-data">
              <input name="id" type="hidden" class="form-control" value="<?php echo $makanan['id'];?>">
              <div class="form-group">
                <label for="foto-mkn">Uploud Gambar</label>
                <input type="file" class="form-control" name="foto-mkn" accept="image/*">
              </div>
              <input type="submit" class="btn btn-primary" value="UPLOUD">
            </form>
          </div>
          <?php
            $query = "SELECT * from foto_mkn WHERE id_mkn = $id";
            $data = $conn->query($query);
            while (@ $foto_mkn = $data->fetch_assoc()) {
                echo "<div class=\"col-md-3\">
                  <div class=\"thumbnail gmb-mkn\">
                    <img alt=\"makanan\" src=\"../img/menu/".$foto_mkn['nama_foto']."\">
                  </div>
                  <div class=\"caption\">
                    <a class=\"btn btn-primary\" href=\"aksi.php?aksi=hapus&n_data=foto-mkn&id=".$id."&foto=".$foto_mkn['nama_foto']."\">Hapus</a>
                  </div>
                </div>";
            }
          ?>
        </div>
      </div>
    </div>
  </body>
</html?
