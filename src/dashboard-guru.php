<?php
session_start();
require('db.php');
if (!isset($_SESSION["guru"])) {
  echo "<script>location='login.php'</script>";
}
$guru = $_SESSION["guru"]["nip"];
$ambil_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = '$guru'");
$data = mysqli_fetch_array($ambil_guru);

// Menghitung jumlah kelas yang diampu
$query_jumlah_kelas = "SELECT COUNT(DISTINCT kode_kelas) AS jumlah_kelas FROM jadwal_pelajaran WHERE nip = '$guru'";
$result_jumlah_kelas = mysqli_query($conn, $query_jumlah_kelas);
$data_jumlah_kelas = mysqli_fetch_assoc($result_jumlah_kelas);
$jumlah_kelas = $data_jumlah_kelas['jumlah_kelas'];

// Menghitung jumlah siswa di kelas yang diampu
$query_jumlah_siswa = "SELECT COUNT(DISTINCT siswa.id_siswa) AS jumlah_siswa 
                       FROM siswa 
                       JOIN jadwal_pelajaran ON siswa.kode_kelas = jadwal_pelajaran.kode_kelas
                       JOIN mata_pelajaran ON jadwal_pelajaran.kode_mapel = mata_pelajaran.kode_mapel
                       WHERE mata_pelajaran.nip = '$guru'";
$result_jumlah_siswa = mysqli_query($conn, $query_jumlah_siswa);
$data_jumlah_siswa = mysqli_fetch_assoc($result_jumlah_siswa);
$jumlah_siswa = $data_jumlah_siswa['jumlah_siswa'];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guru | SMP Negeri 35 Bandar Lampung</title>
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
        <a href="dashboard-guru.php">
          <img src="../assets/LogoSMPN35.png" alt="LogoSMPN35" width="80px" />
        </a>
      </div>
      <div class="title-text">
        <a href="dashboard-guru.php">
          <h1>SIAKAD | Guru</h1>
          <span>SMP Negeri 35 Bandar Lampung</span>
        </a>
      </div>
      <div class="profile-button">
        <a href="profile-guru.php"><iconify-icon icon="material-symbols:person" width="30" class="align-middle p-3"></iconify-icon><?php echo $data['nama'] ?></a>
      </div>
      <div class="logout-button">
        <a href="login.php"><iconify-icon icon="material-symbols:logout" width="30" class="align-middle p-3"></iconify-icon>Logout</a>
      </div>
    </header>

    <nav>
      <ul class="side-menu">
        <li class="menu-disabled"><span>Menu</span></li>
        <li>
          <a href="dashboard-guru.php" class="active"
            ><img
              src="../assets/monitor-dashboard.svg"
              alt="Dashboard"
            />Dashboard</a
          >
        </li>
        <li>
          <a href="#"
            ><img src="../assets/person-rays.svg" alt="Input-Absensi" />Input
            Absensi</a
          >
        </li>
        <li>
          <a href="lihatsiswa-guru.php"
            ><img src="../assets/person-group.svg" alt="Lihat-Siswa" />Lihat
            Siswa</a
          >
        </li>
        <li>
          <a href="#"
            ><img src="../assets/transcript.svg" alt="Input-Nilai" />Input
            Nilai</a
          >
        </li>
        <li>
          <a href="lihatnilaiakhir-guru.php"
            ><img src="../assets/transcript.svg" alt="Lihat-Nilai-Akhir" />Lihat
            Nilai Akhir</a
          >
        </li>
        <li>
          <a href="#"
            ><img src="../assets/transcript.svg" alt="List-Modul" />List Modul</a
          >
        </li>
        <li>
          <a href="#" class="menu-end"
            ><img src="../assets/transcript.svg" alt="Tambah-Modul" />Tambah
            Modul</a
          >
        </li>
      </ul>
    </nav>

    <div class="kotak-isi">
      <div class="kelas-box">
        <h1>Jumlah Kelas Yang Diampu</h1>
        <span><?php echo $jumlah_kelas; ?></span>
      </div>
      <div class="kotak-hijau-kelas"></div>

      <div class="nilai-box">
        <h1>Jumlah Siswa Yang Diampu</h1>
        <span><?php echo $jumlah_siswa; ?></span>
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
