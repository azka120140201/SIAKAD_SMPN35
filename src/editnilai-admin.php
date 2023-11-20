<?php
session_start();
require('db.php'); // Menggunakan file koneksi db.php

if (!isset($_SESSION["admin"])) {
  echo "<script>location='login.php'</script>";
}
$admin = $_SESSION["admin"]["nip"];
$ambil_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '$admin'");
$data = mysqli_fetch_array($ambil_admin);

if (!isset($_GET['nisn'])) {
    // Redirect atau tampilkan pesan error jika NISN tidak ada
    echo "NISN tidak ditemukan";
    exit;
}

$nisn = $_GET['nisn'];

$query_nilai = "SELECT mata_pelajaran.nama_mapel, nilai.* FROM nilai 
                JOIN mata_pelajaran ON nilai.kode_mapel = mata_pelajaran.kode_mapel
                WHERE nilai.nisn = '$nisn'";
$nilai_result = mysqli_query($conn, $query_nilai);

$query_siswa = "SELECT nama FROM siswa WHERE nisn = '$nisn'";
$siswa_result = mysqli_query($conn, $query_siswa);
$data_siswa = mysqli_fetch_assoc($siswa_result);
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
          <a href="daftarsiswa-admin.php"
            ><img src="../assets/person-group.svg" alt="Daftar-Siswa" />Daftar Siswa</a
          >
        </li>
        <li>
          <a href="datanilai-admin.php" class="active"
            ><img src="../assets/transcript.svg" alt="Data-Nilai" />Data Nilai</a
          >
        </li>
        <li>
          <a href="datamodul-admin.php" class="menu-end"><img src="../assets/transcript.svg" alt="Data-Modul" />Data Modul </a
          >
        </li>
      </ul>
    </nav>

    <!-- content -->
    <div class="kotak-isi">
        <div class="container">
    <p class="fw-bold"><?php echo $data_siswa['nama']; ?></p>
    <table class="table table-striped text-center">
        <thead style="background-color: #C6D8AF;">
            <tr>
                <th scope="col">Mata Pelajaran</th>
                <th scope="col">Penilaian Harian 1</th>
                <th scope="col">Penliaian Harian 2</th>
                <th scope="col">Nilai UTS</th>
                <th scope="col">Nilai UAS</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($nilai_result)): ?>
            <tr>
                <td><?php echo $row['nama_mapel']; ?></td>
                <td><?php echo $row['ph1']; ?></td>
                <td><?php echo $row['ph2']; ?></td>
                <td><?php echo $row['uts']; ?></td>
                <td><?php echo $row['uas']; ?></td>
                <td>
                    <a href="formeditnilai.php?nisn=<?php echo $nisn; ?>&kode_mapel=<?php echo $row['kode_mapel']; ?>">
                        <button class="btn btn-primary">Edit</button>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
            <!-- /table -->

        </div>
    </div>
    <!-- /content -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>