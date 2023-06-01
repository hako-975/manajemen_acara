<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$acara = mysqli_query($koneksi, "SELECT * FROM acara INNER JOIN keuangan ON keuangan.id_acara = acara.id_acara WHERE id_user = '$id_user' ORDER BY tanggal_acara DESC");

	$total_keuangan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT
    SUM(CASE WHEN jenis_keuangan = 'PENGELUARAN' THEN -jumlah ELSE jumlah END) AS total_keuangan
	FROM
	    acara
	INNER JOIN
	    keuangan ON keuangan.id_acara = acara.id_acara
	WHERE
	    id_user = '$id_user'"))['total_keuangan'];

	if (isset($_POST['btnCari'])) {
		$cari = $_POST['cari'];
		$acara = mysqli_query($koneksi, "SELECT * FROM acara INNER JOIN keuangan ON keuangan.id_acara = acara.id_acara INNER JOIN user ON acara.id_user = user.id_user WHERE acara.id_user = '$id_user' 
	        AND user.id_user = '$id_user' 
	        AND (nama_acara LIKE '%$cari%' 
	        OR tanggal_acara LIKE '%$cari%'
	        OR tempat_acara LIKE '%$cari%')
			ORDER BY tanggal_acara DESC");
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
        <div class="card">
        	<h3>Total Keuangan: Rp. <?= str_replace(",", ".", number_format($total_keuangan)); ?></h3>
        </div>
		<?php if (mysqli_num_rows($acara)): ?>
			<?php foreach ($acara as $data_acara): ?>
				<div class="card">
					<h3>Tanggal Acara:</h3>
					<h3 class="mb-0"><?= date("d-m-Y \j\a\m H:i", strtotime($data_acara['tanggal_acara'])); ?></h3>
					<div class="row">
						<div class="col">
							<h4>Nama Acara:</h4>
							<p><?= $data_acara['nama_acara']; ?></p>
							<h4>Tempat Acara:</h4>
							<p><?= htmlspecialchars_decode(strip_tags($data_acara['tempat_acara'])); ?></p>
						</div>
						<div class="col">
							<h4>Jenis Keuangan:</h4>
							<p><?= $data_acara['jenis_keuangan']; ?></p>
							<h4>Jumlah:</h4>
							<p>Rp. <?= str_replace(",", ".", number_format($data_acara['jumlah'])); ?></p>
						</div>
					</div>
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