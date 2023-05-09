<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_acara = $_GET['id_acara'];
	$acara = mysqli_query($koneksi, "SELECT * FROM acara INNER JOIN user ON acara.id_user = user.id_user WHERE acara.id_acara = '$id_acara' && acara.id_user = '$id_user'");
	$data_acara = mysqli_fetch_assoc($acara);

	$acaraKu = false;
	if (isset($_SESSION['id_user'])) {
	    $id_user = $_SESSION['id_user'];

	    // cek apakah data acara termasuk acara ku
	    if ($data_acara) {
	        if ($data_acara['id_user'] == $id_user) {
	            $acaraKu = true;
	        }
	    }
	}

	if ($acaraKu == false) {
	    echo "
	        <script>
	            alert('acara gagal diubah!')
	            window.history.back()
	        </script>
	    ";
	    exit;
	}


	if (isset($_POST['btnUbah'])) {
		$nama_acara = htmlspecialchars($_POST['nama_acara']);
		$tanggal_acara = htmlspecialchars($_POST['tanggal_acara']);
		$tempat_acara = htmlspecialchars(nl2br($_POST['tempat_acara']));

		$ubah_acara = mysqli_query($koneksi, "UPDATE acara SET nama_acara = '$nama_acara', tanggal_acara = '$tanggal_acara', tempat_acara = '$tempat_acara' WHERE id_acara = '$id_acara' && id_user = '$id_user'");

		if ($ubah_acara) {
        echo "
            <script>
                alert('Acara berhasil diubah!')
                window.location.href='index.php'
            </script>
        ";
        exit;
    } else {
        echo "
            <script>
                alert('Acara gagal diubah!')
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
	<title>Ubah Acara - <?= $data_acara['nama_acara']; ?></title>
</head>
<body>
	<div class="container">
		<h1 class="heading-title">Ubah Acara - <?= $data_acara['nama_acara']; ?></h1>
		<form method="post" class="form form-left">
		  	<label class="label" for="nama_acara">Nama Acara</label>
		  	<input class="input" type="text" id="nama_acara" name="nama_acara" placeholder="Enter Nama Acara" value="<?= $data_acara['nama_acara']; ?>" required>

		  	<label class="label" for="tanggal_acara">Tanggal Acara</label>
		  	<input class="input" type="datetime-local" id="tanggal_acara" name="tanggal_acara" placeholder="Enter Tanggal Acara" value="<?= $data_acara['tanggal_acara']; ?>" required>

		  	<label class="label" for="tempat_acara">Tempat Acara</label>
		  	<textarea class="input" id="tempat_acara" name="tempat_acara" placeholder="Enter Tempat Acara" required><?= strip_tags(htmlspecialchars_decode($data_acara['tempat_acara'])); ?></textarea>

		  	<button type="submit" class="button align-right" name="btnUbah">Ubah Acara</button>
		</form>
	</div>
	<?php include_once 'navbar.php'; ?>

	<script>
	</script>
</body>
</html>