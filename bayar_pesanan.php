<?php
  ob_start();
  session_start();
  require_once "konfigurasi.php";
	require_once "functions.php";

  $id_pesanan = $_GET['id'];
  $nama_karyawan = $_SESSION['nama'];
  $pesanan = $conn->query("SELECT sum(mkn_pesan.jumlah*tmakanan.harga) as total_bayar from tmakanan, mkn_pesan, tpesanan WHERE tpesanan.id = mkn_pesan.id_pesanan AND tmakanan.id = mkn_pesan.id_makanan AND tpesanan.id = $id_pesanan");
  $pesanan = $pesanan->fetch_assoc();
  $total_bayar = $pesanan['total_bayar'];

?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Pembayaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 login" style="top: 10px;">
          <div class="header">
              <center><h1>Pembayaran</h1></center>
          </div>
          <hr style="margin: 0 -15px 20px;">
          <form class="form-horizontal" role="form" method="post" action="aksi.php?aksi=bayar">
            <input type="hidden" name="nama_karyawan" value="<?php echo $nama_karyawan; ?>">
            <div class="form-group">
              <label for="id-pesanan" class="col-md-3 col-md-offset-1 control-label">ID Pesanan</label>
              <div class="col-md-7">
                <input name="id_pesanan" type="text" class="form-control" value="<?php echo $id_pesanan;?>">
              </div>
            </div>
            <div class="form-group">
              <label for="bayar" class="col-md-3 col-md-offset-1 control-label">Total Bayar</label>
              <div class="col-md-7">
                <input name="total_bayar" type="text" class="form-control" value="<?php echo $total_bayar; ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-4 col-md-8">
                <input type="submit" class="btn btn-primary" value="Bayar">
                <a class="btn btn-primary" href="javascript:history.back();">Batal</a>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 nota">
          <table class="table table-bordered table-responsive" style="background: rgba(252, 253, 255, 0.99);border-radius: 10px 10px 0 0;">
            <thead>
              <tr>
                <th colspan="4" style="text-align: center;"><h2>Nota</h2></th>
              </tr>
              <tr>
                <th>No</th>
                <th>Nama Makanan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $i = 1;
                $table = $conn->query("SELECT nama, jumlah, harga, (jumlah*harga) as subtotal from tmakanan, mkn_pesan, tpesanan WHERE tpesanan.id = mkn_pesan.id_pesanan AND tmakanan.id = mkn_pesan.id_makanan AND tpesanan.id = $id_pesanan");
                while ($row = $table->fetch_assoc()) {
                  echo "<tr>
                    <td>".$i."</td>
                    <td>".$row['nama']."</td>
                    <td>".$row['jumlah']."</td>
                    <td>".$row['harga']."</td>
                    <td>".$row['subtotal']."</td>
                  </tr>";
                  $i++;
                }
                $pesanan = $conn->query("SELECT sum(mkn_pesan.jumlah*tmakanan.harga) as total_bayar from tmakanan, mkn_pesan, tpesanan WHERE tpesanan.id = mkn_pesan.id_pesanan AND tmakanan.id = mkn_pesan.id_makanan AND tpesanan.id = $id_pesanan");
                $pesanan = $pesanan->fetch_assoc();
                $total_bayar = $pesanan['total_bayar'];
                echo "<tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <th>Harga Total</th>
                  <th>".$total_bayar."</th>
                </tr>";
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html?
