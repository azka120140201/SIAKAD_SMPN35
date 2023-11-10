<?php
require('db.php');
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>LOGIN | SMP Negeri 35 Bandar Lampung</title>
  <link rel="stylesheet" type="text/css" href="../styles/styles.css" />
</head>

<body>
  <div class="left-half"></div>
  <div class="top-left">
    <img src="../assets/LogoSMPN35.png" alt="SMPN 35" class="logo" />
    <h1>Sistem Informasi Akademik <br />SMP Negeri 35 Bandar Lampung</h1>
  </div>
  <div class="right-half">
    <div class="login-container">
      <h1>Masuk Ke <b>SIAKAD</b></h1>
      <form id="loginForm" method="POST">
        <div class="atasbawah">
          <div class="atas">
            <p class="atas2">NISN/NIP:</p>
            <input type="text" id="username" name="username" placeholder="NISN/NIP" required autocomplete="off" />
          </div>
          <div class="bawah">
            <p class="bawah2">Kata Sandi:</p>
            <input type="password" id="password" name="password" placeholder="Password" required autocomplete="off" />
          </div>
        </div>
        <button type="submit" name="submit">Masuk</button>
      </form>
      <?php
      // include_once("db.php");
      if (isset($_POST["submit"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username != "" && $password != "") {
          $get_akun = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = '$username' AND password = '$password'");
          $get_akun_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = '$username' AND password = '$password'");
          $akun = mysqli_num_rows($get_akun);
          $get_akun_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '$username' AND password = '$password'");
          $akun = mysqli_num_rows($get_akun);
          $akun_admin = mysqli_num_rows($get_akun_admin);
          $akun_guru = mysqli_num_rows($get_akun_guru);
          if ($akun == 1) {
            $siswa = $get_akun->fetch_assoc();
            $_SESSION["siswa"] = $siswa;
            echo "<script>location='dashboard-siswa.php';</script>";
          } else if ($akun_guru == 1) {
            $kadis = $get_akun_guru->fetch_assoc();
            $_SESSION["guru"] = $kadis;
            echo "<script>location='dashboard-guru.php';</script>";
          } else if ($akun_admin == 1) {
            $admin = $get_akun_admin->fetch_assoc();
            $_SESSION["admin"] = $admin;
            echo "<script>location='dashboard-admin.php';</script>";
          } else {
            echo "data tidak ditemukan";
          }
        }
      }
      ?>
      <p id="loginMessage"></p>
    </div>
  </div>

  <footer>
    <p>&copy; SMP Negeri 35 Bandar Lampung</p>
  </footer>
</body>

</html>