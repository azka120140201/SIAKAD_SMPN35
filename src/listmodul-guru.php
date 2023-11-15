<?php
session_start();
require('db.php');
if (!isset($_SESSION["guru"])) {
    echo "<script>location='login.php'</script>";
}
$guru = $_SESSION["guru"]["nip"];
$ambil_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = '$guru'");
$data = mysqli_fetch_array($ambil_guru);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                <a href="inputabsensi-guru.php"><img src="../assets/person-rays.svg" alt="Input-Absensi" />Input
                    Absensi</a>
            </li>
            <li>
                <a href="lihatsiswa-guru.php"><img src="../assets/person-group.svg" alt="Lihat-Siswa" />Lihat
                    Siswa</a>
            </li>
            <li>
                <a href="inputnilai-guru.php"><img src="../assets/transcript.svg" alt="Input-Nilai" />Input
                    Nilai</a>
            </li>
            <li>
                <a href="lihatnilaiakhir-guru.php"><img src="../assets/transcript.svg" alt="Lihat-Nilai-Akhir" />Lihat
                    Nilai Akhir</a>
            </li>
            <li>
                <a href="listmodul-guru.php" class="active"><img src="../assets/transcript.svg" alt="List-Modul" />List Modul</a>
            </li>
            <li>
                <a href="tambahmodul-guru.php" class="menu-end"><img src="../assets/transcript.svg" alt="Tambah-Modul" />Tambah
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