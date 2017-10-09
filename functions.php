<?php
function login($tabel, $username, $password)
{
	global $conn;
	$query = "SELECT * FROM $tabel WHERE username='$username' AND password='$password'";
	$result = $conn->query($query);
	//cek jumlah baris baris yang dikembalikan
	if($result->num_rows > 0)
		return true;
	else
		return false;
}

//fungsi untuk mengecek session
function cek_session($nama_session)
{
	if(isset($_SESSION[$nama_session]))
		return true;
	else
		return false;
}

//fungsi untuk logout
function logout($nama_session)
{
	if(isset($_SESSION[$nama_session]))
	{
		unset($nama_session);
		session_destroy();
		return true;
	}
	else
		return false;
}

function cek_fields($post)
{
	foreach($post as $var)
	{
		if($var == '' || !isset($var))
			return false;
		else
			return true;
	}
}

?>
