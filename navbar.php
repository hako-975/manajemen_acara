<footer class="navbar navbar-fixed-bottom">
  <div class="footer-container">
    <a class="navbar-title" href="index.php"><img src="img/logo.png"> <span>Manajemen Acara</span></a>
    <ul class="nav navbar-nav">
      <?php if (isset($_SESSION['id_user'])): ?>
        <li><a class="button" href="profile.php">Profile</a></li>
        <li><a class="button" href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a class="button" href="registrasi.php">Registrasi</a></li>
        <li><a class="button" href="login.php">Login</a></li>
      <?php endif ?>
    </ul>
  </div>
</footer>
