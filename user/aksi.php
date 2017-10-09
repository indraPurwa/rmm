<?php
session_start();
include "../konfigurasi.php";
@ $aksi = $_GET['aksi'];

if ($aksi == "tambah") {
		$email = $_POST['email'];
		$nama = $_POST['nama'];
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$password = $_POST['password'];
    $akses = $_POST['akses'];

		$query = "INSERT INTO `dbrmm`.`tuser` (`nama`, `email`, `alamat`, `no_hp`, `password`, `akses`) VALUES ('$nama', '$email', '$alamat', '$no_hp', '$password', '$akses');";
		$conn->query($query);
		echo '<script>alert("Data berhasil di ditambah");window.location = "../admin.php?page=user";</script>';
} else if($aksi == "edit") {
		$email = $_POST['email'];
		$nama = $_POST['nama'];
		$alamat = $_POST['alamat'];
		$hp = $_POST['no_hp'];
		$password = $_POST['password'];
		$akses = $_POST['akses'];

		$query="UPDATE tuser SET nama='$nama', alamat='$alamat', no_hp='$hp', password='$password', akses='$akses' WHERE email = '$email'";
		$conn->query($query);
		echo '<script>alert("Data berhasil di UPDATE");window.location = "../admin.php?page=user";</script>';
} else if($aksi == "hapus") {
  $email = $_GET['id'];
  $conn->query("DELETE from tuser WHERE email = '$email'");
  echo '<script>alert("Data berhasil di hapus");window.location = "../admin.php?page=user";</script>';
}
