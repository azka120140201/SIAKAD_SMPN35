<?php
session_start();
require('db.php');
if (!isset($_SESSION["siswa"])) {
    echo "<script>location='login.php'</script>";
}
$siswa = $_SESSION["siswa"]["nisn"];
$ambil_siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = $siswa");
$data = mysqli_fetch_array($ambil_siswa);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
            <a href="profile-siswa.php"><iconify-icon icon="material-symbols:person" width="35" class="align-middle p-3"></iconify-icon>
                <?php echo $data['nama'] ?>
            </a>
        </div>
        <div class="logout-button">
            <a href="login.php"><iconify-icon icon="material-symbols:logout" width="35" class="align-middle p-3"></iconify-icon>Logout</a>
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
                <a href="lihatabsensi-siswa.php"><img src="../assets/person-rays.svg" alt="Absensi" />Absensi</a>
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
                <a href="lihatmodul-siswa.php" class="menu-end" style=background-color:#Cff59f;><img src="../assets/transcript.svg" alt="Lihat-Modul" />Lihat
                    Modul</a>
            </li>
        </ul>
    </nav>
    <!-- /sidebar -->

    <!-- container -->
    <div class="kotak-isi">
        <!-- button pilih mata pelajaran -->
        <!-- Grid untuk menempatkan judul dan dropdown di sisi yang berlawanan -->
        <div class="d-flex justify-content-between mb-3">
            <!-- Teks di sebelah kiri -->
            <div class="text-start">
                <p class="fw-bold">List Modul</p>
            </div>
            <!-- Dropdown di sebelah kanan -->
            <div class="text-end">
                <select class="form-select border-dark"  id="mataPelajaranSelect" name="mata_pelajaran">
                    <option selected disabled>Mata Pelajaran</option>
                    <option value="IPA">IPA</option>
                    <option value="IPS">IPS</option>
                    <option value="MTK">MTK</option>
                </select>
            </div>
        </div>
        <!-- /button pilih mata pelajaran -->
        <!-- list item table -->
        <div class="container p-3">
            <table class="table">
                <tbody>
                    <tr>
                        <div class="row">
                            <td class="col-lg-11" scope="row"><a href="">Modul 1</a></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                            <td class="col-lg-11" scope="row"><a href="">Modul 2</a></td>
                        </div>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /list item table -->
    </div>
    <!-- /container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>