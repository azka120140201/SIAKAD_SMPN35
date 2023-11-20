<?php
session_start();
require('db.php');
if (!isset($_SESSION["admin"])) {
  echo "<script>location='login.php'</script>";
}
$admin = $_SESSION["admin"]["nip"];
$ambil_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '$admin'");
$data = mysqli_fetch_array($ambil_admin);

$query_guru = "SELECT COUNT(*) AS total_guru FROM guru";
$result_guru = mysqli_query($conn, $query_guru);
$data_guru = mysqli_fetch_assoc($result_guru);

$query_siswa = "SELECT COUNT(*) AS total_siswa FROM siswa";
$result_siswa = mysqli_query($conn, $query_siswa);
$data_siswa = mysqli_fetch_assoc($result_siswa);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | SMP Negeri 35 Bandar Lampung</title>
    <!-- style vanilla css -->
    <link rel="stylesheet" type="text/css" href="../styles/styles.css" />
    <!-- iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>

  <body>
    <header>
      <div class="logo-text">
        <a href="dashboard-admin.php">
          <img src="../assets/LogoSMPN35.png" alt="LogoSMPN35" width="80px" />
        </a>
      </div>
      <div class="title-text">
        <a href="dashboard-admin.php">
          <h1>SIAKAD | Admin</h1>
          <span>SMP Negeri 35 Bandar Lampung</span>
        </a>
      </div>
      <div class="profile-button">
        <a href="profile-admin.php"><iconify-icon icon="material-symbols:person" width="30" class="align-middle p-3"></iconify-icon><?php echo $data['nama'] ?></a>
      </div>
      <div class="logout-button">
        <a href="login.php"><iconify-icon icon="material-symbols:logout" width="30" class="align-middle p-3"></iconify-icon>Logout</a>
      </div>
    </header>

    <nav>
      <ul class="side-menu">
        <li class="menu-disabled"><span>Menu</span></li>
        <li>
          <a href="dashboard-admin.php" class="active"
            ><img
              src="../assets/monitor-dashboard.svg"
              alt="Dashboard"
            />Dashboard</a
          >
        </li>
        <li>
          <a href="daftarguru-admin.php"
            ><img src="../assets/person-rays.svg" alt="Daftar-Guru" />Daftar Guru</a
          >
        </li>
        <li>
          <a href="daftarsiswa-admin.php"
            ><img src="../assets/person-group.svg" alt="Daftar-Siswa" />Daftar Siswa</a
          >
        </li>
        <li>
          <a href="datanilai-admin.php"
            ><img src="../assets/transcript.svg" alt="Data-Nilai" />Data Nilai</a
          >
        </li>
        <li>
          <a href="datamodul-admin.php" class="menu-end"><img src="../assets/transcript.svg" alt="Data-Modul" />Data Modul </a
          >
        </li>
      </ul>
    </nav>

    <div class="kotak-isi">
      <div class="kelas-box">
        <h1>Jumlah Guru</h1>
        <span><?php echo $data_guru['total_guru']; ?></span>
      </div>
      <div class="kotak-hijau-kelas"></div>

      <div class="nilai-box">
        <h1>Jumlah Siswa</h1>
        <span><?php echo $data_siswa['total_siswa']; ?></span>
      </div>
      <div class="kotak-hijau-nilai-rata-rata"></div>

      <div class="data-diri-dashboard">
        <div class="column">
          <div class="data-item">
            <label for="nama">Nama :</label>
            <span id="nama"><?php echo $data['nama'] ?></span>
          </div>
          <div class="data-item">
            <label for="nip">NIP :</label>
            <span id="nisn"><?php echo $data['nip'] ?></span>
          </div>
          <div class="data-item">
            <label for="tempat-lahir">Tempat Lahir :</label>
            <span id="tempat-lahir"><?php echo $data['tempat_lahir'] ?></span>
          </div>
        </div>
        <div class="column">
          <div class="data-item">
            <label for="tanggal-lahir">Tanggal Lahir :</label>
            <span id="tanggal-lahir"><?php echo $data['tanggal_lahir'] ?></span>
          </div>
          <div class="data-item">
            <label for="jenis-kelamin">Jenis Kelamin :</label>
            <span id="jenis-kelamin"><?php echo $data['jenis_kelamin'] ?></span>
          </div>
          <div class="data-item">
            <label for="agama">Agama :</label>
            <span id="agama"><?php echo $data['agama'] ?></span>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
