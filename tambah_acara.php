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

		$tambah_acara = mysqli_query($koneksi, "INSERT INTO acara VALUES ('', '$nama_acara', '$tanggal_acara', '$tempat_acara', '$id_user')");

		if ($tambah_acara) {
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

		  	<button type="submit" class="button align-right" name="btnTambah">Tambah Acara</button>
		</form>
	</div>
	<?php include_once 'navbar.php'; ?>

	<script>
	</script>
</body>
</html>