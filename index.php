<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$acara = mysqli_query($koneksi, "SELECT * FROM acara WHERE id_user = '$id_user' ORDER BY tanggal_acara ASC");

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
		<?php if (mysqli_num_rows($acara)): ?>
			<?php foreach ($acara as $data_acara): ?>
				<div class="card">
					<h3>Tanggal Acara:</h3>
					<h3><?= date("d-m-Y \j\a\m H:i", strtotime($data_acara['tanggal_acara'])); ?></h3>
					<h4>Nama Acara:</h4>
					<p><?= $data_acara['nama_acara']; ?></p>
					<h4>Tempat Acara:</h4>
					<p><?= htmlspecialchars_decode(strip_tags($data_acara['tempat_acara'])); ?></p>
					<div class="card-button">
						<a href="ubah_acara.php?id_acara=<?= $data_acara['id_acara']; ?>" class="button">Ubah</a>
						<a href="hapus_acara.php?id_acara=<?= $data_acara['id_acara']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Acara <?= $data_acara['nama_acara']; ?>?')" class="button">Hapus</a>
					</div>
				</div>
			<?php endforeach ?>
		<?php else: ?>
			<div class="title">
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