<?php
session_start();
include "../konfigurasi.php";
@ $aksi = $_GET['aksi'];
@ $n_data = $_GET['n_data'];
if ($aksi == "tambah") {
  if($n_data == "makanan"){
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $potongan = $_POST['potongan'];
    $jenis = $_POST['jenis'];
    $posted = $_POST['posted'];

    $now = $conn->query("SELECT now();");
    $now = $now->fetch_assoc();
    $post = $now['now()'];
    $update = NULL;

    $query = "INSERT INTO `dbrmm`.`tmakanan` (`id`, `nama`, `deskripsi`, `harga`, `potongan`, `post`, `update`, `posted`, `jenis`) VALUES (NULL, '$nama', '$deskripsi', '$harga', '$potongan', '$post', '$update', '$posted', '$jenis');";
    $conn->query($query);
    echo '<script>alert("Data berhasil di ditambah");window.location = "../admin.php?page=makanan";</script>';
  } else if ($n_data == "foto_mkn") {
    $id = $_POST['id'];
		$lokasiFile = $_FILES['foto-mkn']['tmp_name'];
		$tipeFile = $_FILES['foto-mkn']['type'];
		$namaFile = $_FILES['foto-mkn']['name'];
		move_uploaded_file($lokasiFile, '../img/menu/'.$namaFile);
		if($_FILES['foto-mkn']['name'] == "") {
				echo '<script>alert("Belum Ada Gambar Di Pilih");window.location = "edit-makanan.php?id='.$id.'";</script>';
		}
		elseif ($_FILES['foto-mkn']['name'] != "") {
			$conn->query("INSERT INTO `dbrmm`.`foto_mkn` (`id_mkn`, `nama_foto`) VALUES ('$id', '$namaFile');");
			echo '<script>alert("Gambar berhasil di ditambah");window.location = "edit-makanan.php?id='.$id.'";</script>';
		}
  }
} else if($aksi == "edit") {
  if ($n_data == "makanan") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $potongan = $_POST['potongan'];
    $post = $_POST['post'];

    $now = $conn->query("SELECT now();");
    $now = $now->fetch_assoc();
    $update = $now['now()'];
    $posted = $_POST['posted'];
    $jenis = $_POST['jenis'];
    $query = "UPDATE `dbrmm`.`tmakanan` SET `nama` = '$nama', `deskripsi` = '$deskripsi', `harga`= $harga, `potongan`= $potongan, `post`='$post', `update` = '$update', `posted` = '$posted', jenis = '$jenis' WHERE id = $id";
    $conn->query($query);
    echo '<script>alert("Data berhasil di UPDATE");window.location = "../admin.php?page=makanan";</script>';
  }
} else if($aksi == "hapus") {
  if($n_data == 'makanan') {
		$id = $_GET['id'];
		$hapus = $conn->query("SELECT * FROM foto_mkn WHERE id_mkn = $id");
		while ($dtHapus = $hapus->fetch_assoc()) {
			unlink('../img/menu/'.$dtHapus['nama_foto']);
		}
		$conn->query("DELETE from foto_mkn WHERE id_mkn = $id");
		$conn->query("DELETE from tmakanan WHERE id = $id");
		echo '<script>alert("Data berhasil di hapus");window.location = "../admin.php?page=makanan";</script>';
	}
	elseif ($n_data == 'foto-mkn') {
		$id = $_GET['id'];
		$gambar = $_GET['foto'];
		$conn->query("DELETE FROM foto_mkn WHERE id_mkn = $id AND nama_foto = '$gambar'");
		unlink('../img/menu/'.$gambar);
		echo '<script>alert("Gambar berhasil di hapus");window.location = "edit-makanan.php?id='.$id.'";</script>';
	}
  
} else if ($aksi == "cetak-makanan") {
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	//mengambil data dari tabel
	$query = "SELECT tmakanan.id, tmakanan.nama, tmakanan.harga, sum(mkn_pesan.jumlah) AS Pesanan, sum(mkn_pesan.jumlah*tmakanan.harga) AS omset from tmakanan left outer join mkn_pesan on tmakanan.id = mkn_pesan.id_makanan AND mkn_pesan.id_pesanan in (SELECT id from tpesanan WHERE month(waktu_pesan)=$bulan AND year(waktu_pesan)=$tahun) group by tmakanan.id";
	$query = $conn->query($query);
	$data = array();
	while ($row = $query->fetch_assoc()) {
	    array_push($data, $row);
	}

	//mengisi judul dan header tabel
	$judul = "LAPORAN MAKANAN (Bln: ".$bulan."/".$tahun.")";
	$header = array(
		array("label"=>"ID", "length"=>20, "align"=>"L"),
		array("label"=>"Nama", "length"=>75, "align"=>"L"),
		array("label"=>"Harga", "length"=>30, "align"=>"L"),
		array("label"=>"Jumlah di Pesan", "length"=>35, "align"=>"L"),
		array("label"=>"Omset", "length"=>30, "align"=>"L"),
	);

	//memanggil fpdf
	require_once ("fpdf/fpdf.php");
	$pdf = new FPDF();
	$pdf->AddPage();

	//tampilan Judul Laporan
	$pdf->SetFont('Arial','B','16'); //Font Arial, Tebal/Bold, ukuran font 16
	$pdf->Cell(0, 20, $judul, '0', 1, 'C');

	//Header Table
	$pdf->SetFont('Arial','','12');
	$pdf->SetFillColor(139, 69, 19); //warna dalam kolom header
	$pdf->SetTextColor(255); //warna tulisan putih
	$pdf->SetDrawColor(222, 184, 135); //warna border
	foreach ($header as $kolom) {
	    $pdf->Cell($kolom['length'], 5, $kolom['label'], 1, '0', 'C', true);
	}
	$pdf->Ln();

	//menampilkan data table
	$pdf->SetFillColor(245, 222, 179); //warna dalam kolom data
	$pdf->SetTextColor(0); //warna tulisan hitam
	$pdf->SetFont('');
	$fill=false;
	foreach ($data as $baris) {
		$i = 0;
		foreach ($baris as $cell) {
			$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $kolom['align'], $fill);
			$i++;
		}
		$fill = !$fill;
		$pdf->Ln();
	}

	//output file pdf
	$pdf->Output();
}
