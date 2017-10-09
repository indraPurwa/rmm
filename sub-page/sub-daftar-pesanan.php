<div class="col-md-12">
  <center><h1>DAFTAR PESANAN</h1></center>
  <table class="table table-responsive table-striped" style="text-align: center;">
    <thead>
      <tr>
        <th>Email</th>
        <th>Daftar Pesanan</th>
        <th>Waktu Pesan</th>
        <th>Kirim</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "SELECT * from tpesanan";
        $table = $conn->query($query);
        $i = 1;
        while ($row = $table->fetch_assoc()) {
          if($i % 2 != 0)
            $class = "success";
          else
            $class = "warning";

          $id_pesanan = $row['id'];
          $email_plg= $row['email_plg'];
          $waktu_pesan = $row['waktu_pesan'];
          $kirim = $row['kirim'];

          //untuk mencari daftar pesanan berupa id, nama dan jumlah makanan berdasar pesanan sekarang
          $table_dm = $conn->query("SELECT DISTINCT mkn_pesan.id_makanan, tmakanan.nama, mkn_pesan.jumlah from mkn_pesan, tmakanan WHERE mkn_pesan.id_pesanan = $id_pesanan AND mkn_pesan.id_makanan = tmakanan.id");

          echo "<tr class=\"".$class."\">
              <td>".$email_plg."<br><a class=\"btn btn-primary\" href=\"lihat-pelanggan.php?id=".$email_plg."\">Lihat Pelanggan</a></td>
              <td>
                <ol>";
                while ($row_dm = $table_dm->fetch_assoc()) {
                  echo "<li>".$row_dm['nama']." <span class=\"badge\">".$row_dm['jumlah']."</span></li>";
                }
                echo "</ol>
              </td>
              <td><strong>".date('G:i:s d/m/Y', strtotime($waktu_pesan))."</strong></td>";

              echo "<td>";
              //jika belum ada yang mengantar pesanan
              if ($kirim == "belum") {
                if ($_SESSION['akses'] == "karyawan") {
                  echo "<a href=\"aksi.php?aksi=antar&id=".$id_pesanan."\" class=\"btn btn-success\">Antar</a>";
                } elseif ($_SESSION['akses'] == "admin") {
                  echo NULL;
                }
              }
              //jika sudah ada yang mengantar
              elseif ($kirim == "sudah") {

                //cek pesanan sekarang sudah dibayar atau belum
                $row = $conn->query("SELECT id_pesanan as bayar FROM tpembayaran WHERE tpembayaran.id_pesanan = (SELECT id FROM tpesanan WHERE id = $id_pesanan)");
                $row = $row->fetch_assoc();
                $bayar = $row['bayar'];

                //belum dibayar ditantai dengan nilai variabel $bayar = NULL
                if($bayar == NULL) {
                  //mengetahui apakah yang mengantar pesanan adalah karyawan sekarang
                  $nm_kary_skrng = $_SESSION['nama'];
                  $row = $conn->query("SELECT * FROM tuser, tpengantaran WHERE tuser.nama = '$nm_kary_skrng' AND tpengantaran.id_pesanan = $id_pesanan AND tuser.nama = tpengantaran.nama_karyawan");
                  $krywn = $row->fetch_assoc();

                  //jika dia yang mengantar
                  if ($krywn['nama_karyawan'] != "") {
                    echo "<a class=\"btn btn-primary\" href=\"bayar_pesanan.php?id=".$id_pesanan."\">Bayar</a>";
                  }

                  //jika bukan dia yang mengantar
                  elseif ($krywn['nama_karyawan'] == "") {
                    $row = $conn->query("SELECT * from tpengantaran where id_pesanan = $id_pesanan");
                    $antar = $row->fetch_assoc();
                    echo "Sedang Di Antar oleh : <strong>".$antar['nama_karyawan']."</strong><br>Waktu Ambil : <strong>".date('G:i:s d/m/Y', strtotime($antar['waktu_ambil']))."</strong><br/>";
                  }

                //sudah dibayar ditantai dengan nilai variabel $bayar = NULL
                } else if($bayar != NULL) {
                  $row = $conn->query("SELECT * from tpembayaran where id_pesanan = $id_pesanan");
                  $bayar = $row->fetch_assoc();
                  echo "Sudah dibayar oleh : <strong>".$bayar['nama_karyawan']."</strong><br>Waktu Bayar : <strong>".date('G:i:s d/m/Y', strtotime($bayar['waktu_bayar']))."</strong><br/>";
                }
              }
              echo "</td></tr>";
          $i++;
        }
      ?>
    </tbody>
    <tfoot>
      <tr class="danger" id="">
        <td colspan="5">*Tolong secepatnya kirimkan setiap ada pesanan</td>
      </tr>
    </tfoot>
  </table>
</div>
