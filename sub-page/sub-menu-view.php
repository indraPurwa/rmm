<?php
  $id = $_GET['id'];
  $data = $conn->query("SELECT * FROM `tmakanan` WHERE id = $id");
  $makanan = $data->fetch_assoc();
  $id = $makanan['id'];
?>
<div class="row">
  <div class="col-md-12">
    <div class="title" style="width: auto;"><span class="title-text"><?php echo $makanan['nama']; ?></span></div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 menu-item">
    <?php
    echo "<div id=\"MyCarousel\" class=\"carousel slide\">
      <ol class=\"carousel-indicators\">";
        $i = 0;
        $act = 0;
        $foto = $conn->query("SELECT * FROM `foto_mkn` WHERE id_mkn = $id");
        while ($foto_mkn = $foto->fetch_assoc()) {
          $active = "";
          if($act == 0)
            $active = "active";
          echo "<li class=\"".$active."\" data-target=\"#MyCarousel\" data-slide-to=\"".$i."\"></li>";
          $i++;
          $act++;
        }
      echo "</ol>
      <div class=\"carousel-inner\">";
        $foto = $conn->query("SELECT * FROM `foto_mkn` WHERE id_mkn = $id");
        $act = 0;
        while ($foto_mkn = $foto->fetch_assoc()) {
            $active = "";
            if($act == 0)
              $active = "active";
            echo "<div class=\"item ".$active."\">
              <img src=\"img/menu/".$foto_mkn['nama_foto']."\">
            </div>";
            $act++;
        }
      echo "</div>
          <a class=\"carousel-control left\" href=\"#MyCarousel\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-menu-left\"></span></a>
          <a class=\"carousel-control right\" href=\"#MyCarousel\" data-slide=\"next\"><span class=\"glyphicon glyphicon-menu-right\"></span></a>
        </div>";
     ?>
  </div>
  <div class="col-md-12 menu-review">
    <table class="table table-responsive" style="border: 1px solid #BAB6B6; background: rgba(203, 212, 251, 0.41);">
      <tbody>
        <tr>
          <td><h1>Harga</h1></td>
          <td>:</td>
          <td><h1>IDR <?php echo $makanan['harga']; ?></h1></td>
        </tr>
        <tr>
          <td>Potongan</td>
          <td>:</td>
          <td>IDR <?php echo $makanan['potongan']; ?></td>
        </tr>
        <tr>
          <td>Deskripsi</td>
          <td>:</td>
          <td style="text-align: justify;"><?php echo $makanan['deskripsi']; ?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3">
            <?php
            if(cek_session("email") != "") {
              echo "<form style=\"display: inline; float:right\" method=\"POST\" action=\"aksi.php?aksi=pesan&id=".$makanan['id']."\">
                <input style=\"width: 50px;height: 35px;\" type=\"text\" name=\"jumlah\" placeholder=\"0\">
                <input type=\"submit\" class=\"btn btn-lg btn-success\" role=\"button\" value=\"Pesan\">
                  </form>";
            }
            elseif (cek_session("email") == "") {
              echo "<button onclick=\"alert('Anda belum login atau anda tidak login sebagai pelanggan')\"  class=\"btn btn-lg btn-success\" role=\"button\">Pesan</button>";
            }
            ?>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
