<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$acara = mysqli_query($koneksi, "SELECT * FROM acara WHERE id_user = '$id_user' ORDER BY tanggal_acara ASC");

	if (isset($_POST['btnCari'])) {
		$cari = $_POST['cari'];
		$acara = mysqli_query($koneksi, "SELECT * FROM acara INNER JOIN user ON acara.id_user = user.id_user WHERE acara.id_user = '$id_user' 
	        AND user.id_user = '$id_user' 
	        AND (nama_acara LIKE '%$cari%' 
	        OR tanggal_acara LIKE '%$cari%'
	        OR tempat_acara LIKE '%$cari%')
			ORDER BY tanggal_acara ASC");
	}

?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Daftar Acara - <?= $data_user['username']; ?></title>
</head>
<body>
	<div class="container">
		<h1 class="daftar-acara">Daftar Acara</h1>
        <a class="button tambah-acara" href="tambah_acara.php">Tambah Acara</a>
        <div class="clear">
        	<form method="post" class="form-cari">
		  		<input class="input" type="text" id="cari" name="cari" placeholder="Enter Cari" required value="<?= (isset($_POST['cari'])) ? $_POST['cari'] : ''; ?>">
		  		<button type="submit" class="button align-right" name="btnCari">Cari</button>
        	</form>
        	<?php if (isset($_POST['cari'])): ?>
	        	<h2>Cari: <?= $_POST['cari']; ?></h2>
	        	<button type="button" onclick="return window.location.href='index.php'" class="button">Reset</button>
        	<?php endif ?>
        </div>
		<?php if (mysqli_num_rows($acara)): ?>
			<?php foreach ($acara as $data_acara): ?>
				<div class="card">
					<h3>Tanggal Acara:</h3>
					<h3><?= date("d-m-Y \j\a\m H:i", strtotime($data_acara['tanggal_acara'])); ?></h3>
					<h4>Nama Acara:</h4>
					<p><?= $data_acara['nama_acara']; ?></p>
					<h4>Tempat Acara:</h4>
					<p><?= htmlspecialchars_decode(strip_tags($data_acara['tempat_acara'])); ?></p>
					<hr class="hr">
					<a href="ubah_acara.php?id_acara=<?= $data_acara['id_acara']; ?>" class="button">Ubah</a>
					<a href="hapus_acara.php?id_acara=<?= $data_acara['id_acara']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Acara <?= $data_acara['nama_acara']; ?>?')" class="button">Hapus</a>
				</div>
			<?php endforeach ?>
		<?php else: ?>
			<div class="belum-ada-acara">
				<h2>Belum Ada Acara</h2>
				<a href="tambah_acara.php" class="button">Tambah Acara</a>
			</div>
		<?php endif ?>
	</div>
	<?php include_once 'navbar.php'; ?>

	<script>
	</script>
</body>
</html>