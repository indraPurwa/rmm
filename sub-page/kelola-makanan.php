<div class="col-md-12">
  <center><h1>KELOLA MAKANAN</h1></center>
  <table class="table table-responsive table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Harga</th>
        <th>Potongan</th>
        <th>Post</th>
        <th>Update</th>
        <th>Posted</th>
        <th>Kelola</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "SELECT * from tmakanan";
        $data = $conn->query($query);
        $i = 1;
        while ($makanan = $data->fetch_assoc()) {
          if($i % 2 != 0)
            $class = "success";
          else
            $class = "warning";

          echo "<tr class=\"".$class."\">
              <td>".$makanan['id']."</td>
              <td>".$makanan['nama']."</td>
              <td>".$makanan['deskripsi']."</td>
              <td>".$makanan['harga']."</td>
              <td>".$makanan['potongan']."</td>
              <td>".$makanan['post']."</td>
              <td>".$makanan['update']."</td>
              <td>".$makanan['posted']."</td>
              <td>
              <a class=\"btn btn-primary\" href=\"makanan/edit-makanan.php?id=".$makanan['id']."\">Edit</a>
              <a class=\"btn btn-primary\" href=\"makanan/aksi.php?aksi=hapus&n_data=makanan&id=".$makanan['id']."\">Hapus</a>
              </td>";
          $i++;
        }
      ?>
    </tbody>
    <tfoot>
      <tr class="danger">
        <td colspan="10"><a style="margin-bottom: 15px;" class="btn btn-primary btn-md" href="makanan\tambah-makanan.php">Tambah</a></td>
      </tr>
    </tfoot>
  </table>
</div>
