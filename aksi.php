<?php
session_start();
include "konfigurasi.php";
@ $aksi = $_GET['aksi'];

if($aksi == "temp_pesan") {
	$email_plg = $_POST['email_plg'];
	$id_mkn = $_POST['id'];
	$jumlah = $_POST['jumlah'];

	$conn->query("INSERT INTO `dbrmm`.`temp_pesan` (`email_plg`, `id_mkn`, `jumlah`) VALUES ('$email_plg', '$id_mkn', '$jumlah'); ");
	echo '<script>alert("Pesanan ditambah ke keranjang"); history.back();</script>';

}
elseif ($aksi == "edit_temp_pesan") {
	$email_plg = $_POST['email_plg'];
	$id_mkn = $_POST['id_mkn'];
	$jumlah = $_POST['jumlah'];

	$conn->query("UPDATE `dbrmm`.`temp_pesan` SET `jumlah` = '$jumlah' WHERE `temp_pesan`.`email_plg` = '$email_plg'");
	echo '<script>history.back();</script>';

}
else if ($aksi == "pesan" ) {
	$email_plg = $_POST['email_plg'];
	$alamat = $_POST['alamat'];
	$no_hp = $_POST['no_hp'];

	$datetime = $conn->query("SELECT now()");
	$datetime = $datetime->fetch_assoc();
	$dt_pesan = $datetime['now()'];

	$conn->query("INSERT INTO `dbrmm`.`tpesanan` (`id`, `email_plg`, `waktu_pesan`, `kirim`) VALUES (NULL, '$email_plg', '$dt_pesan', 'belum');");
	$row_id = $conn->query("SELECT ID from tpesanan WHERE tpesanan.email_plg = '$email_plg' ORDER BY id DESC LIMIT 1");
	$row_id = $row_id->fetch_assoc();
	$id_pesanan = $row_id['ID'];

	$table = $conn->query("SELECT * from temp_pesan WHERE email_plg = '$email_plg';");
	while ($row = $table->fetch_assoc()) {
	  $id_mkn = $row['id_mkn'];
	  $jumlah = $row['jumlah'];
	  $conn->query("INSERT INTO `dbrmm`.`mkn_pesan` (`id_pesanan`, `id_makanan`, `jumlah`) VALUES ('$id_pesanan', '$id_mkn', '$jumlah');");
	}
	$conn->query("DELETE FROM `dbrmm`.`temp_pesan` WHERE `temp_pesan`.`email_plg` = '$email_plg'");
	$conn->query("UPDATE `dbrmm`.`tuser` SET `alamat` = '$alamat', `no_hp`='$no_hp' WHERE `tuser`.`email` = '$email_plg';");
	echo '<script>alert("Pesanan di simpan di nota"); history.back();</script>';

}
elseif ($aksi == "antar") {
	$id_pesanan = $_GET['id'];
	$nama_karyawan = $_SESSION['nama'];

	$now = $conn->query("SELECT now();");
	$now = $now->fetch_assoc();
	$waktu_skrng = $now['now()'];

	$conn->query("INSERT INTO `tpengantaran`(`nama_karyawan`, `id_pesanan`, `waktu_ambil`) VALUES ('$nama_karyawan', $id_pesanan, '$waktu_skrng')");
	$conn->query("UPDATE `dbrmm`.`tpesanan` SET `kirim` = 'sudah' WHERE `tpesanan`.`id` = '$id_pesanan';");
	echo '<script>alert("Anda telah mengambil pesanan\nSegera Antar pesanan setelah anda mengambil di RMM\nWaktu pengantaran 15-60 menit"); history.back();</script>';


}
elseif ($aksi == "bayar") {
		$id_pesanan = $_POST['id_pesanan'];
		$nama_karyawan = $_POST['nama_karyawan'];
		$total_bayar = $_POST['total_bayar'];

		$datetime = $conn->query("SELECT now()");
		$datetime = $datetime->fetch_assoc();
		$dt_bayar = $datetime['now()'];

		$query = "INSERT INTO `dbrmm`.`tpembayaran` (`id_pesanan`, `nama_karyawan`, `waktu_bayar`, `total_bayar`) VALUES ($id_pesanan, '$nama_karyawan', '$dt_bayar', $total_bayar)";
		$conn->query($query);
		echo '<script>alert("Pesanan Anda sudah dibayar\nSelamat menikmati makanan anda !!!"); history.go(-2);</script>';

}
elseif ($aksi =="cetak-makanan") {
	require_once "mpdf/mpdf.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];

	$html = '<h1 style="text-align: center;">LAPORAN MAKANAN</h1>Bulan '.$bulan.'/'.$tahun.
  '<table class="table table-responsive table-bordered">
    <thead>
      <tr>
        <th style="text-align:center;">ID</th>
        <th style="text-align:center;">Nama</th>
        <th style="text-align:center;">Harga</th>
        <th style="text-align:center;">Pesanan</th>
        <th style="text-align:center;">Total Biaya</th>
      </tr>
    </thead>
    <tbody>';
    $query = "SELECT tmakanan.id, tmakanan.nama, tmakanan.harga, sum(mkn_pesan.jumlah) AS Pesanan, sum(mkn_pesan.jumlah*tmakanan.harga) AS omset from tmakanan left outer join mkn_pesan on tmakanan.id = mkn_pesan.id_makanan AND mkn_pesan.id_pesanan in (SELECT id from tpesanan WHERE month(waktu_pesan)=$bulan AND year(waktu_pesan)=$tahun) group by tmakanan.id";
    $data = $conn->query($query);
    while ($makanan = $data->fetch_assoc()) {
      $html .= "<tr class=\"tengah\">
        <td>".$makanan['id']."</td>
        <td>".$makanan['nama']."</td>
        <td class=\"uang\">".$makanan['harga'].",00</td>
        <td class=\"uang\">".$makanan['Pesanan']."x</td>
        <td class=\"uang\">".$makanan['omset'].",00</td>
        </tr>";
    }
    $html .= '</tbody>
					  </table>';

	$mpdf = new mPDF('utf-8', 'A4');
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->list_indent_first_level = 0;
	$stylesheet = file_get_contents('css/bootstrap.css');

	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html,2);
	$mpdf->Output('laporan-dengan-mpdf.pdf','I');
	exit;

}
elseif ($aksi == "cetak-pelanggan") {
	require_once "mpdf/mpdf.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];

	$html = '<h1 style="text-align: center;">LAPORAN PELANGGAN</h1>Bulan '.$bulan.'/'.$tahun.
	'<table class="table table-responsive table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Email</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Total Belanja</th>
			</tr>
		</thead>
		<tbody>';
		$query = "SELECT email, nama, alamat, sum(tpembayaran.total_bayar) as total_belanja from tpembayaran, tuser,tpesanan WHERE tuser.email = tpesanan.email_plg AND tpembayaran.id_pesanan = tpesanan.id AND tuser.akses='pelanggan' AND month(waktu_pesan)=$bulan AND year(waktu_pesan)=$tahun group by email ORDER BY total_belanja DESC";
		$data = $conn->query($query);
		$i = 1;
		while ($pelanggan = $data->fetch_assoc()) {
				$html .= "<tr class=\"tengah\">
				<td>".$i."</td>
				<td>".$pelanggan['email']."</td>
				<td>".$pelanggan['nama']."</td>
				<td>".$pelanggan['alamat']."</td>
				<td class=\"uang\">IDR ".$pelanggan['total_belanja'].",00</td>
			</tr>";
			$i++;
		}
		$html .= '</tbody>
						</table>';

	$mpdf = new mPDF('utf-8', 'A4');
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->list_indent_first_level = 0;
	$stylesheet = file_get_contents('css/bootstrap.css');

	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html,2);
	$mpdf->Output('laporan-dengan-mpdf.pdf','I');
	exit;
}
?>
