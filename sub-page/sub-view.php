<div class="row">
  <div class="col-md-12">
      <div class="title"><span class="title-text">Makanan</span></div>
  </div>
  <div class="menu-order">
    <?php
    $id = $_GET['id'];
    $data = $conn->query("SELECT tmakanan.*, foto_mkn.nama_foto FROM `tmakanan`, `foto_mkn` WHERE tmakanan.id = foto_mkn.id_mkn and (tmakanan.jenis = 'makanan' or tmakanan.jenis like 'minuman') and tmakanan.id = $id");
    $makanan = $data->fetch_assoc();
    echo "<div class=\"col-md-12 menu-item\">
      <div class=\"thumbnail\">
        <img src=\"img/menu/".$makanan['nama_foto']."\" alt=\"Menu RMM\">
        <div class=\"caption\">
          <h3>".$makanan['nama']."</h3>
          <p>".$makanan['deskripsi']."</p>
          <p>
            <a href=\"#\" class=\"btn btn-primary\" role=\"button\">Add Chart</a>
            <a href=\"#\" class=\"btn btn-default\" role=\"button\">Reviw</a>
          </p>
        </div>
      </div>
    </div>";
    ?>
  </div>
</div>
