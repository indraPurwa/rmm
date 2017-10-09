<div class="row">
  <div class="col-md-12">
    <div class="title"><span class="title-text" style="font-size:20px; padding-top:10px;">Keranjang Pesanan</span></div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-responsive" style="border: 1px solid #BAB6B6; background: rgba(203, 212, 251, 0.41);">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Jumlah</th>
          <th>Harga</th>
          <th>Total</th>
          <th>Check</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $pelanggan = $_SESSION['email'];
          $data = $conn->query("SELECT tmakanan.id, tmakanan.nama, temp_pesan.jumlah, tmakanan.harga, tmakanan.harga*temp_pesan.jumlah as subtotal from tmakanan, temp_pesan WHERE tmakanan.id = temp_pesan.id_mkn AND temp_pesan.email_plg = '$pelanggan'");
          while ($pesan = $data->fetch_assoc()) {
            echo "
              <form action='aksi.php?aksi=edit_temp_pesan' method='post'>
                <input type='hidden' name='email_plg' value='$pelanggan'>
                <input type='hidden' name='id_mkn' value='".$pesan['id']."'>
                <tr>
                  <td>".$pesan['nama']."</td>
                  <td><input type=\"text\" name=\"jumlah\" value=\"".$pesan['jumlah']."\"></td>
                  <td>".$pesan['harga']."</td>
                  <td>".$pesan['subtotal']."</td>
                  <td><input class='btn-success' type='submit' value='check'</td>
                </tr>
              </form>";
          }
          $data = $conn->query("SELECT sum(jumlah*harga) as total from temp_pesan, tmakanan WHERE temp_pesan.email_plg = '$pelanggan' and tmakanan.id = temp_pesan.id_mkn");
          $pesan = $data->fetch_assoc();
          echo "<tr>
            <td></td>
            <td></td>
            <th>Harga Total</th>
            <th>".$pesan['total']."</th>
          </tr>";
        ?>
      </tbody>
    </table>
  </div>
  <div class="col-md-offset-2 col-md-10">
    <?php
      $row = $conn->query("SELECT * from tuser WHERE email = '$pelanggan'");
      $data = $row->fetch_assoc();
     ?>
    <form class="form-horizontal" action="aksi.php?aksi=pesan" role="form" method="post">
      <input type="hidden" name="email_plg" value="<?php echo $pelanggan; ?>">
      <div class="form-group">
        <label for="alamat" class="col-md-6 control-label">Alamat Tujuan</label>
        <div class="col-md-6">
          <?php echo "<textarea name=\"alamat\" class=\"form-control\" rows=\"3\">".$data['alamat']."</textarea>"; ?>
        </div>
      </div>
      <div class="form-group">
        <label for="handphone" class="col-md-6 control-label">NO Handphone</label>
        <div class="col-md-6">
          <?php echo "<input type=\"text\" name=\"no_hp\" class=\"form-control\" placeholder=\"masukkan no handphone\" value=\"".$data['no_hp']."\">" ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-6 col-md-6">
          <input type="submit" class="btn btn-success" value="PESAN"></input>
          <a href="aksi.php?aksi=batal_pesan"class="btn btn-success">BATAL</a>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-12">
    <div class="alert alert-danger"><p style="text-align: justify;">Pesanan yang telah termuat di nota diatas telah tersimpan di sistem dan akan dikirim segera. Untuk membatalkan pengiriman dan menghapus pesanan di sistem klik batal</p></div>
  </div>
</div>
