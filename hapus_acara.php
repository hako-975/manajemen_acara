<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_acara = $_GET['id_acara'];
	$acara = mysqli_query($koneksi, "SELECT * FROM acara INNER JOIN user ON acara.id_user = user.id_user WHERE id_acara = '$id_acara'");
	$data_acara = mysqli_fetch_assoc($acara);
	$acaraKu = false;
	if (isset($_SESSION['id_user'])) {
		$id_user = $_SESSION['id_user'];

		// cek apakah data acara termasuk acara ku
		if ($data_acara['id_user'] == $id_user) {
			$acaraKu = true;
		}
	}

	if ($acaraKu) {
		$hapus_acara = mysqli_query($koneksi, "DELETE FROM acara WHERE id_acara = '$id_acara' && id_user = '$id_user'");

		if ($hapus_acara) {
			echo "
				<script>
					alert('acara berhasil dihapus!')
					window.location.href='index.php'
				</script>
			";
			exit;
		} else {
			echo "
				<script>
					alert('acara gagal dihapus!')
					window.history.back()
				</script>
			";
			exit;
		}
	} else {
		echo "
			<script>
				alert('acara gagal dihapus!')
				window.history.back()
			</script>
		";
		exit;
	}
?>