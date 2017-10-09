<div class="row">
  <div class="col-md-12">
      <div class="title"><span class="title-text">Minuman</span></div>
  </div>
  <div class="menu-order">
    <?php
    $data = $conn->query("SELECT * FROM tmakanan WHERE jenis = 'minuman' ORDER BY id DESC limit 3");
    if($data->num_rows > 0) {
      while ($minuman = $data->fetch_assoc()) {
        $id = $makanan['id'];
        $foto = $conn->query("SELECT * FROM `foto_mkn` WHERE id_mkn = $id limit 1");
        $foto = $foto->fetch_assoc();
        $foto_mkn  = $foto['nama_foto'];
        echo "<div class=\"col-md-6 menu-item\">
          <div class=\"thumbnail\">
            <a href=\"?page=view&id=".$minuman['id']."\"><img src=\"img/menu/".$foto_mkn."\" alt=\"Menu RMM\"></a>
            <div class=\"caption\">
              <h3><a href=\"?page=view&id=".$minuman['id']."\">".$minuman['nama']."</a></h3>
              <p>IDR ".$minuman['harga']."</p>
              <p>";
              if(cek_session("email") != "") {
                echo "<form style=\"display: inline;\" method=\"POST\" action=\"aksi.php?aksi=pesan&id=".$minuman['id']."\">
                  <input style=\"width: 50px;height: 35px;\" type=\"text\" name=\"jumlah\" placeholder=\"0\">
                  <input type=\"submit\" class=\"btn btn-success\" role=\"button\" value=\"Pesan\">
                    </form>";
              }
              elseif (cek_session("email") == "") {
                echo "<button onclick=\"alert('Anda belum login atau anda tidak login sebagai pelanggan')\"  class=\"btn btn-success\" role=\"button\">Pesan</button>";
              }
        echo "</p>
            </div>
          </div>
        </div>";
      }
    }
    else {
      echo "<div class=\"col-md-12 menu-item\">
        <div class=\"alert alert-danger\">Saat ini menu minuman sedang kosong</div>
        </div>";
    }
    ?>
  </div>
</div>
