<!DOCTYPE HTML>
<html>
  <head>
    <title>Tambah Pelanggan</title>
    <link rel="shotchut icon" href="../img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 login">
          <div class="header">
            <center><h1>TAMBAH USER</h1></center>
          </div>
          <hr style="margin: 0 -15px 20px;">
          <form class="form-horizontal" role="form" action="aksi.php?aksi=tambah" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Nama</label>
              <div class="col-md-7">
                <input name="nama" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-md-3 col-md-offset-1 control-label">Email</label>
              <div class="col-md-7">
                <input name="email" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="alamat" class="col-md-3 col-md-offset-1 control-label">Alamat</label>
              <div class="col-md-7">
                <textarea name="alamat" class="textarea" style="width: 100%;"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">NO Handphone</label>
              <div class="col-md-7">
                <input name="no_hp" type="text" class="form-control" >
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Password</label>
              <div class="col-md-7">
                <input name="password" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label">Jenis</label>
              <div class="col-md-7">
                <select name="akses" class="form-control">
                  <option value="admin">Admin</option>
                  <option value="karyawan">Karyawan</option>
                  <option value="pelanggan">Pelanggan</option>"
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="nama" class="col-md-3 col-md-offset-1 control-label"></label>
              <div class="col-md-7">
                <input type="submit" class="btn btn-primary" value="TAMBAH">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html?
