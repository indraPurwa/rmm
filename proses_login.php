<!DOCTYPE html>
<html>
  <head>
    <title>RUMAH MAKAN MAHASISWA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shotchut icon" href="img/favicon.png">
    <link href="css/bootstrap.css" rel="stylesheet">
	</head>
	<body style="background:black;">
<?php
@ session_start();
require_once "konfigurasi.php";
$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM tuser WHERE email='$email' AND password='$password';";
$result = $conn->query($query);
if($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$_SESSION['email'] = $row['email'];
	$_SESSION['nama'] = $row['nama'];
  $akses = $row['akses'];

  if($akses == "pelanggan") {
	   $_SESSION['akses'] = "pelanggan";
   } else if($akses == 'karyawan') {
     $_SESSION['akses'] = "karyawan";
   } else if($akses == 'admin') {
     $_SESSION['akses'] = "admin";
   }
   header("location:index.php");
} else {
	echo '<script>alert("Username dan Password Salah"); history.back();</script>';
}
?>
</body>
</html>
