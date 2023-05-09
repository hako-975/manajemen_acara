<?php
    require_once 'koneksi.php';
    
    if (isset($_SESSION['id_user'])) {
        echo "
            <script>
                window.location='index.php'
            </script>
        ";
        exit;
    }

    if (isset($_POST['btnRegistrasi'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];
        $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
        
        // check username 
        $query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
        
        if (mysqli_num_rows($query_user) > 0) {
            echo "
                <script>
                    alert('Username sudah digunakan!')
                    window.history.back();
                </script>
            ";
            exit;
        }

        if ($password != $re_password) {
            echo "
                <script>
                    alert('Password harus sama dengan Ketik Ulang Password!')
                    window.history.back();
                </script>
            ";
            exit;
        }
        
        $password = password_hash($password, PASSWORD_DEFAULT);

        $insert_user = mysqli_query($koneksi, "INSERT INTO user (username, password, nama_lengkap) VALUES ('$username', '$password', '$nama_lengkap')");
        if ($insert_user) {
            echo "
                <script>
                    alert('Registrasi berhasil!')
                    window.location.href='login.php'
                </script>
            ";
            exit;
        }
    }
?>


<html>
<head>
    <?php include_once 'head.php'; ?>
    <title>Registrasi - Manajemen Acara</title>
</head>
<body>
    <div class="container">
        <form method="post" class="form">
            <img src="img/logo.png" alt="Logo">
            <h2 class="title">Form Registrasi</h2>
            <label class="label" for="username">Username</label>
            <input class="input" type="text" id="username" name="username" placeholder="Enter username" required>

            <label class="label" for="password">Password</label>
            <input class="input" type="password" id="password" name="password" placeholder="Enter Password" required>

            <label class="label" for="re_password">Re-Password</label>
            <input class="input" type="password" id="re_password" name="re_password" placeholder="Enter Re-Password" required>

            <label class="label" for="nama_lengkap">Nama Lengkap</label>
            <input class="input" type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Enter Nama Lengkap" required>

            <button type="submit" class="button align-right" name="btnRegistrasi">Registrasi</button>
        </form>
    </div>
    <?php include_once 'navbar.php'; ?>
</body>
</html>