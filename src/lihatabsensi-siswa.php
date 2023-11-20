<?php
session_start();
require('db.php');
if (!isset($_SESSION["siswa"])) {
    echo "<script>location='login.php'</script>";
}
$siswa = $_SESSION["siswa"]["nisn"];
$ambil_siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = $siswa");
$data = mysqli_fetch_array($ambil_siswa);

$kode_kelas_siswa = $data['kode_kelas'];
$query_mapel = "SELECT DISTINCT jadwal_pelajaran.kode_mapel, mata_pelajaran.nama_mapel FROM jadwal_pelajaran JOIN mata_pelajaran ON jadwal_pelajaran.kode_mapel = mata_pelajaran.kode_mapel WHERE jadwal_pelajaran.kode_kelas = '$kode_kelas_siswa' AND mata_pelajaran.aktif='Ya'";
$hasil_mapel = mysqli_query($conn, $query_mapel);
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
    <!-- topbar -->
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
            <a href="profile-siswa.php"><iconify-icon icon="material-symbols:person" width="35"
                    class="align-middle p-3"></iconify-icon>
                <?php echo $data['nama'] ?>
            </a>
        </div>
        <div class="logout-button">
            <a href="login.php"><iconify-icon icon="material-symbols:logout" width="35"
                    class="align-middle p-3"></iconify-icon>Logout</a>
        </div>
    </header>
    <!-- /Topbar -->

    <!-- sidebar -->
    <nav>
        <ul class="side-menu">
            <li class="menu-disabled"><span>Menu</span></li>
            <li>
                <a href="dashboard-siswa.php"><img src="../assets/monitor-dashboard.svg" alt="Dashboard" />Dashboard</a>
            </li>
            <li>
                <a href="jadwalpelajaran-siswa.php"><img src="../assets/schedule.svg" alt="Jadwal-Pelajaran" />Jadwal
                    Pelajaran</a>
            </li>
            <li>
                <a href="lihatabsensi-siswa.php" class="active"><img src="../assets/person-rays.svg" alt="Absensi" />Absensi</a>
            </li>
            <li>
                <a href="lihatnilaiakhir-siswa.php"><img src="../assets/transcript.svg" alt="Lihat-Nilai-Akhir" />Lihat
                    Nilai Akhir</a>
            </li>
            <li>
                <a href="rinciannilai-siswa.php"><img src="../assets/transcript.svg" alt="Lihat-RIncian-Nilai" />Lihat
                    Rincian Nilai</a>
            </li>
            <li>
                <a href="lihatmodul-siswa.php" class="menu-end"><img src="../assets/transcript.svg" alt="Lihat-Modul" />Lihat
                    Modul</a>
            </li>
        </ul>
    </nav>
    <!-- /sidebar -->

    <!-- container -->
    <div class="kotak-isi">
        <!-- dropdown mapel -->
        <div class="dropdown container ml-3 mb-3">
    <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button"
        id="mapel" data-bs-toggle="dropdown" aria-expanded="false">
        Mata Pelajaran
    </button>
    <ul class="dropdown-menu" aria-labelledby="mapel">
        <?php while($mapel = mysqli_fetch_assoc($hasil_mapel)): ?>
            <li class="dropdown-item" onclick="showAbsensi('<?php echo $mapel['kode_mapel']; ?>')"><?php echo $mapel['nama_mapel']; ?></li>
        <?php endwhile; ?>
    </ul>
</div>
        <!-- /dropdown mapel -->

        <!-- Table -->
        <div class="container">
    <table class="table table-striped table-fixed text-center" id="absensiTable">
        <thead style="background-color: #C6D8AF;">
            <tr>
                <th scope="col">Pertemuan</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Waktu Absensi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Absensi akan dimuat di sini -->
        </tbody>
    </table>
</div>
        <!-- /table -->
    </div>
    <!-- /container -->
    
    <script>
function showAbsensi(kodeMapel) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'getAbsensi.php?kode_mapel=' + kodeMapel, true);
    xhr.onload = function() {
        if (this.status == 200) {
            // Hanya update <tbody> dari tabel
            document.getElementById('absensiTable').getElementsByTagName('tbody')[0].innerHTML = this.responseText;
        }
    }
    xhr.send();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>