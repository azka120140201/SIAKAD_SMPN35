<?php
session_start();
require('db.php'); // Menggunakan file koneksi db.php

if (!isset($_SESSION["admin"])) {
  echo "<script>location='login.php'</script>";
}
$admin = $_SESSION["admin"]["nip"];
$ambil_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '$admin'");
$data = mysqli_fetch_array($ambil_admin);

// Query untuk mengambil semua kelas
$query_kelas = "SELECT * FROM kelas";
$kelas_result = mysqli_query($conn, $query_kelas);
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
          <a href="dashboard-admin.php"
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
          <a href="daftarsiswa-admin.php" class="active"
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
        <!-- Bagian Dropdown Kelas -->
        <div class="d-flex justify-content-between mb-3">
            <div class="text-start">
                <p class="fw-bold">Data Siswa</p>
            </div>
            <div class="text-end">
                <select class="form-select border-dark" id="kelasselect" name="kode_kelas" onchange="fetchDataListSiswa(this.value)">
                    <option selected disabled>Pilih Kelas</option>
                    <?php 
                    while($kelas = mysqli_fetch_assoc($kelas_result)): ?>
                        <option value="<?php echo $kelas['kode_kelas']; ?>"><?php echo $kelas['nama_kelas']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- Bagian Tabel Siswa -->
        <div class="container" id="dataSiswa">
            <!-- Data siswa akan dimuat di sini -->
        </div>
    </div>
        <!-- /dropdown kelas -->

    <script>
    function fetchDataListSiswa(kodeKelas) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("dataSiswa").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "fetchDataListSiswa.php?kode_kelas=" + kodeKelas, true);
        xhttp.send();
    }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>