<?php
  ob_start();
  session_start();
  $email = $_GET['id'];

  require_once "konfigurasi.php";
  require_once "functions.php";
  $query = "SELECT * from tuser where email = '$email'";
  $data = $conn->query($query);
  $user = $data->fetch_assoc();
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Profile user</title>
    <link rel="shotchut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 login">
          <div class="header">
            <center><h1>Profile Pelanggan</h1></center>
          </div>
          <hr style="margin: 0 -15px 20px;">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="email" class="col-md-3 col-md-offset-1 control-label">Email</label>
              <div class="col-md-7">
                <input type="text" class="form-control" value="<?php echo $user['email'];?>">
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Nama</label>
              <div class="col-md-7">
                <input type="text" class="form-control" value="<?php echo $user['nama'];?>">
              </div>
            </div>
            <div class="form-group">
              <label for="alamat" class="col-md-3 col-md-offset-1 control-label">Alamat</label>
              <div class="col-md-7">
                <textarea class="textarea" style="width: 100%;"><?php echo $user['alamat'];?>l</textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Nama</label>
              <div class="col-md-7">
                <input type="text" class="form-control" value="<?php echo $user['no_hp'];?>">
              </div>
            </div>
            <br/>
            <div class="form-group">
              <div class="col-md-offset-2 col-md-8">
                <a class="btn btn-primary" style="width:100%" href="javascript: history.back()">Kembali</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html?
