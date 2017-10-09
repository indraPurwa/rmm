<div class="col-md-12">
  <form action="?page=lapor-pelanggan" method="post" role="form">
    <label for="bulan">Pilih Bulan</label>
    <select name="bulan">
       <?php
       $tanggal = $conn->query("SELECT DISTINCT MONTH(tpesanan.waktu_pesan) as bulan, year(waktu_pesan) as tahun from tpesanan");
       while ($tgl = $tanggal->fetch_assoc()) {
         echo "<option value=\"".$tgl['bulan']."\">".$tgl['bulan']."</option>";
       }
       ?>
    </select>
    <label style="margin-left: 10px;" for="tahun">Tahun</label>
    <select name="tahun">
      <?php
      $tanggal = $conn->query("SELECT DISTINCT year(waktu_pesan) as tahun from tpesanan");
      while ($tgl = $tanggal->fetch_assoc()) {
        echo "<option value=\"".$tgl['tahun']."\">".$tgl['tahun']."</option>";
      }
      ?>
    </select>
    <input type="submit" style="btn btn-small btn-primary" value="LIHAT">
  </form>
  <center><h1>LAPORAN PELANGGAN</h1></center>
  <table class="table table-responsive table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Email</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Total Belanja</th>
      </tr>
    </thead>
    <tbody>
      <?php
        @ $bulan = $_POST['bulan'];
        if($bulan == "") {
          $bulan = date('n');
        }
        @ $tahun = $_POST['tahun'];
        if($tahun == "") {
          $tahun = date('Y');
        }
        echo "Bulan ".$bulan."/".$tahun;
        $query = "SELECT email, nama, alamat, sum(tpembayaran.total_bayar) as total_belanja from tpembayaran, tuser,tpesanan WHERE tuser.email = tpesanan.email_plg AND tpembayaran.id_pesanan = tpesanan.id AND tuser.akses='pelanggan' AND month(waktu_pesan)=$bulan AND year(waktu_pesan)=$tahun group by email ORDER BY total_belanja DESC";
        $data = $conn->query($query);
        $i = 1;
        while ($pelanggan = $data->fetch_assoc()) {
          if($i % 2 != 0)
            $class = "success";
          else
            $class = "warning";
          echo "<tr class=\"".$class." tengah\">
            <td>".$i."</td>
            <td>".$pelanggan['email']."</td>
            <td>".$pelanggan['nama']."</td>
            <td>".$pelanggan['alamat']."</td>
            <td class=\"uang\">IDR ".$pelanggan['total_belanja'].",00</td>
            </tr>";
          $i++;
        }
      ?>
    </tbody>
    <tfoot>
      <tr class="danger">
        <td colspan="5"><a class="btn btn-primary" href="aksi.php?aksi=cetak-pelanggan&bulan=<?php echo $bulan ."&tahun=".$tahun; ?>">CETAK</a></td>
      </tr>
    </tfoot>
  </table>
</div>
