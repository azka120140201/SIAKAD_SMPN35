<?php
session_start();
require('db.php');
if (!isset($_SESSION["siswa"])) {
  echo "<script>location='login.php'</script>";
}
$siswa = $_SESSION["siswa"]["nisn"];
$ambil_siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = '$siswa'");
$data = mysqli_fetch_array($ambil_siswa);

// NISN siswa yang login
$nisn_siswa = $data['nisn'];

// Query untuk mengambil nilai
$query_nilai = "SELECT mp.nama_mapel, n.ph1, n.ph2, n.uts, n.uas
                FROM nilai n
                JOIN mata_pelajaran mp ON n.kode_mapel = mp.kode_mapel
                WHERE n.nisn = '$nisn_siswa'";
$hasil_nilai = mysqli_query($conn, $query_nilai);

$nilai_pelajaran = [];
while ($row = mysqli_fetch_assoc($hasil_nilai)) {
    $nilai_pelajaran[] = $row;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Siswa | SMP Negeri 35 Bandar Lampung</title>
    <!-- style vanilla css -->
    <link rel="stylesheet" type="text/css" href="../styles/styles.css" />
    <!-- iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <header>
      <div class="logo-text">
        <a href="dashboard-siswa.php">
          <img src="../assets/LogoSMPN35.png" alt="LogoSMPN35" width="80px" />
        </a>
      </div>
      <div class="title-text">
        <a href="dashboard-siswa.php">
          <h1>SIAKAD | Siswa</h1>
          <span>SMP Negeri 35 Bandar Lampung</span>
        </a>
      </div>
      <div class="profile-button">
        <a href="profile-siswa.php"><iconify-icon icon="material-symbols:person" width="30" class="align-middle p-3"></iconify-icon><?php echo $data['nama'] ?></a>
      </div>
      <div class="logout-button">
        <a href="src/login.php"><iconify-icon icon="material-symbols:logout" width="30" class="align-middle p-3"></iconify-icon>Logout</a>
      </div>
    </header>

    <nav>
        <ul class="side-menu">
          <li class="menu-disabled"><span>Menu</span></li>
          <li>
            <a href="dashboard-siswa.php"
              ><img
                src="../assets/monitor-dashboard.svg"
                alt="Dashboard"
              />Dashboard</a
            >
          </li>
          <li>
            <a href="jadwalpelajaran-siswa.php"
              ><img src="../assets/schedule.svg" alt="Jadwal-Pelajaran" />Jadwal
              Pelajaran</a
            >
          </li>
          <li>
            <a href="#"
              ><img src="../assets/person-rays.svg" alt="Absensi" />Absensi</a
            >
          </li>
          <li>
            <a href="lihatnilaiakhir-siswa.php"
              ><img src="../assets/transcript.svg" alt="Lihat-Nilai-Akhir" />Lihat
              Nilai Akhir</a
            >
          </li>
          <li>
            <a href="rinciannilai-siswa.php" class="active"
              ><img src="../assets/transcript.svg" alt="Lihat-RIncian-Nilai" />Lihat
              Rincian Nilai</a
            >
          </li>
          <li>
            <a href="#" class="menu-end"
              ><img src="../assets/transcript.svg" alt="Lihat-Modul" />Lihat
              Modul</a
            >
          </li>
        </ul>
      </nav>

    <!-- content -->
    <div class="kotak-isi">
        <div class="container">
            <p class="fw-bold">Rincian Nilai</p>
            <!-- Bagian tabel rincian nilai -->
<div class="container">
    <table class="table table-striped table-fixed text-center">
        <thead style="background-color: #C6D8AF;">
            <tr>
                <th scope="col">Mata Pelajaran</th>
                <th scope="col">PH 1</th>
                <th scope="col">PH 2</th>
                <th scope="col">Nilai UTS</th>
                <th scope="col">Nilai UAS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nilai_pelajaran as $nilai): ?>
                <tr>
                    <td scope="row"><?php echo htmlspecialchars($nilai['nama_mapel']); ?></td>
                    <td><?php echo htmlspecialchars($nilai['ph1']); ?></td>
                    <td><?php echo htmlspecialchars($nilai['ph2']); ?></td>
                    <td><?php echo htmlspecialchars($nilai['uts']); ?></td>
                    <td><?php echo htmlspecialchars($nilai['uas']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
            <!-- /table -->
        </div>
    </div>
    <!-- /content -->

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>