<div class="col-md-12">
  <center><h1>KELOLA PELANGGAN</h1></center>
  <table class="table table-responsive table-striped">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>No Handphone</th>
        <th>Password</th>
        <th>Akses</th>
        <th>Kelola</th>
      </tr>
    </thead>
    <tbody style="text-align:center;">
      <?php
        $query = "SELECT * from tuser";
        $table = $conn->query($query);
        $i = 1;
        while ($user = $table->fetch_assoc()) {
          if($i % 2 != 0)
            $class = "success";
          else
            $class = "warning";
          echo "<tr class=\"".$class."\">
            <td>".$user['nama']."</td>
            <td>".$user['email']."</td>
            <td>".$user['alamat']."</td>
            <td>".$user['no_hp']."</td>
            <td>".$user['password']."</td>
            <td>".$user['akses']."</td>
            <td>
              <a class=\"btn btn-primary\" href=\"user/edit-user.php?id=".$user['email']."\">Edit</a>
              <a class=\"btn btn-primary\" href=\"user/aksi.php?aksi=hapus&&id=".$user['email']."\">Hapus</a>
            </td>
          </tr>";
          $i++;
        }
      ?>
    </tbody>
    <tfoot>
      <tr class="danger">
        <td colspan="8"><a style="margin-bottom: 15px;" class="btn btn-primary btn-md" href="user\tambah-user.php">Tambah</a></td>
      </tr>
    </tfoot>
  </table>
</div>
