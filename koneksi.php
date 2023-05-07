<?php 
	session_start();
	date_default_timezone_set("Asia/Jakarta");
	
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$database = 'manajemen_acara';

	$koneksi = mysqli_connect($host, $user, $pass, $database);

	if ($koneksi) {
		// echo "berhasil terkoneksi";
	}


 ?>