<div class="col-md-12">
  <form action="?page=lapor-makanan" method="post" role="form">
    <label for="bulan">Pilih Bulan</label>
    <select name="bulan">
       <?php
       $tanggal = $conn->query("SELECT DISTINCT MONTH(waktu_pesan) as bulan from tpesanan");
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

  <center><h1>LAPORAN MAKANAN</h1></center>
  <table class="table table-responsive table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Pesanan</th>
        <th>Total Biaya</th>
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
        $query = "SELECT tmakanan.id, tmakanan.nama, tmakanan.harga, sum(mkn_pesan.jumlah) AS Pesanan, sum(mkn_pesan.jumlah*tmakanan.harga) AS omset from tmakanan left outer join mkn_pesan on tmakanan.id = mkn_pesan.id_makanan AND mkn_pesan.id_pesanan in (SELECT id from tpesanan WHERE month(waktu_pesan)=$bulan AND year(waktu_pesan)=$tahun) group by tmakanan.id";
        $data = $conn->query($query);
        $i = 1;
        while ($makanan = $data->fetch_assoc()) {
          if($i % 2 != 0)
            $class = "";
          else
            $class = "";
          echo "<tr class=\"".$class." tengah\">
            <td>".$makanan['id']."</td>
            <td>".$makanan['nama']."</td>
            <td class=\"uang\">".$makanan['harga'].",00</td>
            <td class=\"uang\">".$makanan['Pesanan']."x</td>
            <td class=\"uang\">".$makanan['omset'].",00</td>
            </tr>";
          $i++;
        }
      ?>
    </tbody>
    <tfoot>
      <tr class="">
        <td colspan="5"><a class="btn btn-primary" href="aksi.php?aksi=cetak_makanan&bulan=<?php echo $bulan ."&tahun=".$tahun; ?>">CETAK</a></td>
      </tr>
    </tfoot>
  </table>
</div>
