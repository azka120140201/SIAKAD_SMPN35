<?php
session_start();
require('db.php');
if (!isset($_SESSION["guru"])) {
  echo "<script>location='login.php'</script>";
}
$guru = $_SESSION["guru"]["nip"];
$ambil_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = '$guru'");
$data = mysqli_fetch_array($ambil_guru);

// Query untuk mengambil daftar kelas yang diampu oleh guru
$query_kelas = "SELECT DISTINCT k.kode_kelas
                FROM kelas k
                JOIN jadwal_pelajaran jp ON k.kode_kelas = jp.kode_kelas
                JOIN mata_pelajaran mp ON jp.kode_mapel = mp.kode_mapel
                WHERE mp.nip = '$guru'";
$hasil_kelas = mysqli_query($conn, $query_kelas);

$kelas_guru = [];
while ($kelas = mysqli_fetch_assoc($hasil_kelas)) {
    $kelas_guru[] = $kelas['kode_kelas'];
}

$nilai_siswa = [];
if (isset($_GET['kelas'])) {
    $kode_kelas_dipilih = $_GET['kelas'];

    // Query yang dimodifikasi untuk mengambil nilai siswa dari kelas yang dipilih
    // dan hanya untuk mata pelajaran yang diampu oleh guru tersebut
    $query_nilai = "SELECT s.nama, n.kode_mapel_guru, n.nisn, n.ph1, n.ph2, n.uts, n.uas
                    FROM siswa s
                    JOIN nilai n ON s.nisn = n.nisn
                    JOIN jadwal_pelajaran jp ON n.kode_mapel = jp.kode_mapel AND s.kode_kelas = jp.kode_kelas
                    JOIN mata_pelajaran mp ON jp.kode_mapel = mp.kode_mapel
                    WHERE s.kode_kelas = '$kode_kelas_dipilih'
                    AND mp.nip = '$guru'";
    $hasil_nilai = mysqli_query($conn, $query_nilai);


    while ($row = mysqli_fetch_assoc($hasil_nilai)) {
        $nilai_akhir = ($row['ph1'] * 0.2) + ($row['ph2'] * 0.2) + ($row['uts'] * 0.3) + ($row['uas'] * 0.3);
        $nilai_mutu = hitungMutu($nilai_akhir);
        $nilai_siswa[] = array_merge($row, ['nilai_akhir' => $nilai_akhir, 'nilai_mutu' => $nilai_mutu]);
    }
}

function hitungMutu($nilai) {
    if ($nilai >= 85) return 'A';
    elseif ($nilai >= 70) return 'B';
    elseif ($nilai >= 55) return 'C';
    elseif ($nilai >= 40) return 'D';
    else return 'E';
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guru | SMP Negeri 35 Bandar Lampung</title>

  <!-- style vanilla css -->
  <link rel="stylesheet" type="text/css" href="../styles/styles.css" />
  <!-- iconify -->
  <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
  <!-- topbar -->
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
  <!-- /topbar -->

  <!-- sidebar -->
  <nav>
    <ul class="side-menu">
      <li class="menu-disabled"><span>Menu</span></li>
      <li>
        <a href="dashboard-guru.php"><img src="../assets/monitor-dashboard.svg" alt="Dashboard" />Dashboard</a>
      </li>
      <li>
        <a href="#"><img src="../assets/person-rays.svg" alt="Input-Absensi" />Input
          Absensi</a>
      </li>
      <li>
        <a href="lihatsiswa-guru.php"><img src="../assets/person-group.svg" alt="Lihat-Siswa" />Lihat
          Siswa</a>
      </li>
      <li>
        <a href="inputnilai-guru.php" class="active"><img src="../assets/transcript.svg" alt="Input-Nilai" />Input
          Nilai</a>
      </li>
      <li>
        <a href="lihatnilaiakhir-guru.php"><img src="../assets/transcript.svg"
            alt="Lihat-Nilai-Akhir" />Lihat
          Nilai Akhir</a>
      </li>
      <li>
        <a href="#"><img src="../assets/transcript.svg" alt="List-Modul" />List Modul</a>
      </li>
      <li>
        <a href="#" class="menu-end"><img src="../assets/transcript.svg" alt="Tambah-Modul" />Tambah
          Modul</a>
      </li>
    </ul>
  </nav>
  <!-- /sidebar -->

  <!-- Content -->
  <div class="kotak-isi">
    <!-- button pilih kelas -->
    <div class="dropdown container mb-3">
      <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button"
        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        Pilih Kelas
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <?php foreach ($kelas_guru as $kode_kelas): ?>
              <li><a class="dropdown-item" href="inputnilai-guru.php?kelas=<?php echo $kode_kelas; ?>"><?php echo $kode_kelas; ?></a></li>
          <?php endforeach; ?>
      </ul>
  </div>
    <!-- /button pilih kelas -->

    <!-- table -->
    <div class="container">
      <table class="table table-striped table-fixed text-center">
        <caption>Data Siswa</caption>
        <thead style="background-color: #C6D8AF;">
          <tr>
            <th scope="col">Nama Siswa</th>
            <th scope="col">PH 1</th>
            <th scope="col">PH 2</th>
            <th scope="col">Nilai UTS</th>
            <th scope="col">Nilai UAS</th>
            <th scope="col">Nilai Akhir</th>
            <th scope="col">Nilai Mutu</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
              <?php foreach ($nilai_siswa as $nilai): ?>
                  <tr>
                      <td scope="row"><?php echo htmlspecialchars($nilai['nama']); ?></td>
                      <td><?php echo htmlspecialchars($nilai['ph1']); ?></td>
                      <td><?php echo htmlspecialchars($nilai['ph2']); ?></td>
                      <td><?php echo htmlspecialchars($nilai['uts']); ?></td>
                      <td><?php echo htmlspecialchars($nilai['uas']); ?></td>
                      <td><?php echo htmlspecialchars($nilai['nilai_akhir']); ?></td>
                      <td><?php echo htmlspecialchars($nilai['nilai_mutu']); ?></td>
                      <td> <a href="inputnilai.php?nisn=<?php echo $nilai['nisn']; ?>&kode_mapel_guru=<?php echo $nilai['kode_mapel_guru']; ?>"><img src="../assets/edit.svg" alt="edit-button"></a></td>
    </tr>
<?php endforeach; ?>
          </tbody>
      </table>
  </div>
    <!-- /table -->
  </div>
  <!-- /Content -->

  <!-- script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>