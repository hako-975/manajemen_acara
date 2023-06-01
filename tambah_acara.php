<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	if (isset($_POST['btnTambah'])) {
		$nama_acara = htmlspecialchars($_POST['nama_acara']);
		$tanggal_acara = htmlspecialchars($_POST['tanggal_acara']);
		$tempat_acara = htmlspecialchars(nl2br($_POST['tempat_acara']));
		$jenis_keuangan = htmlspecialchars($_POST['jenis_keuangan']);
		$jumlah = htmlspecialchars($_POST['jumlah']);

		$tambah_acara = mysqli_query($koneksi, "INSERT INTO acara VALUES ('', '$nama_acara', '$tanggal_acara', '$tempat_acara', '$id_user')");

		if ($tambah_acara) {
			$id_acara = mysqli_insert_id($koneksi);
			$tambah_keuangan = mysqli_query($koneksi, "INSERT INTO keuangan VALUES ('', '$jenis_keuangan', '$jumlah', '$id_acara')");
	        echo "
	            <script>
	                alert('Acara berhasil ditambahkan!')
	                window.location.href='index.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Acara gagal ditambahkan!')
	                window.history.back()
	            </script>
	        ";
	        exit;
	    }
	}
?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Tambah Acara</title>
</head>
<body>
	<div class="container">
		<h1 class="heading-title">Tambah Acara</h1>
		<form method="post" class="form form-left">
		  	<label class="label" for="nama_acara">Nama Acara</label>
		  	<input class="input" type="text" id="nama_acara" name="nama_acara" placeholder="Enter Nama Acara" required>

		  	<label class="label" for="tanggal_acara">Tanggal Acara</label>
		  	<input class="input" type="datetime-local" id="tanggal_acara" name="tanggal_acara" placeholder="Enter Tanggal Acara" value="<?= date("Y-m-d H:i"); ?>" required>

		  	<label class="label" for="tempat_acara">Tempat Acara</label>
		  	<textarea class="input" id="tempat_acara" name="tempat_acara" placeholder="Enter Tempat Acara" required></textarea>

		  	<label class="label" for="jenis_keuangan">Jenis Keuangan</label>
		  	<select class="input" id="jenis_keuangan" name="jenis_keuangan" placeholder="Enter Jenis Keuangan" required>
		  		<option value="PEMASUKAN">PEMASUKAN</option>
		  		<option value="PENGELUARAN">PENGELUARAN</option>
		  	</select>

		  	<label class="label" for="jumlah">Jumlah</label>
		  	<input class="input" type="number" id="jumlah" name="jumlah" placeholder="Enter Jumlah" min="0" required>


		  	<button type="submit" class="button align-right" name="btnTambah">Tambah Acara</button>
		</form>
	</div>
	<?php include_once 'navbar.php'; ?>

	<script>
	</script>
</body>
</html>