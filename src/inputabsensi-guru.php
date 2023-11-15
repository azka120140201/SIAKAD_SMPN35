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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Topbar -->
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
            <a href="profile-guru.php"><iconify-icon icon="material-symbols:person" width="30"
                    class="align-middle p-3"></iconify-icon><a href="profile-guru.php">
                    <?php echo $data['nama'] ?>
                </a>
        </div>
        <div class="logout-button">
            <a href="login.php"><iconify-icon icon="material-symbols:logout" width="30"
                    class="align-middle p-3"></iconify-icon>Logout</a>
        </div>
    </header>
    <!-- /Topbar -->

    <!-- sidebar -->
    <nav>
        <ul class="side-menu">
            <li class="menu-disabled"><span>Menu</span></li>
            <li>
                <a href="dashboard-guru.php"><img src="../assets/monitor-dashboard.svg" alt="Dashboard" />Dashboard</a>
            </li>
            <li>
                <a href="inputabsensi-guru.php" class="active"><img src="../assets/person-rays.svg"
                        alt="Input-Absensi" />Input
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
                <a href="#"><img src="../assets/transcript.svg" alt="List-Modul" />List Modul</a>
            </li>
            <li>
                <a href="#" class="menu-end"><img src="../assets/transcript.svg" alt="Tambah-Modul" />Tambah
                    Modul</a>
            </li>
        </ul>
    </nav>
    <!-- /sidebar -->

    <!-- container -->
    <div class="kotak-isi">
        <!-- button group -->
        <div class="btn-group mb-3">
            <!-- button pilih kelas -->
            <div class="dropdown container mb-3">
                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button"
                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Pilih Kelas
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php foreach ($kelas_guru as $kode_kelas): ?>
                        <li><a class="dropdown-item" href="lihatnilaiakhir-guru.php?kelas=<?php echo $kode_kelas; ?>">
                                <?php echo $kode_kelas; ?>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- /button pilih kelas -->

            <!-- button pertemuan -->
            <div class="dropdown container ml-3 mb-3">
                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button"
                    id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Pertemuan
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                    <?php foreach ($kelas_guru as $kode_kelas): ?>
                        <li><a class="dropdown-item" href="lihatnilaiakhir-guru.php?kelas=<?php echo $kode_kelas; ?>">
                                <?php echo $kode_kelas; ?>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- /button pertemuan -->
        </div>
        <!-- button group -->

        <!-- table -->
        <div class="container p-3">
            <table class="table">
                <tbody>
                    <tr>
                        <div class="row">
                        <td class="col-lg-11" scope="row">Siswa</td>
                        <td class="col-lg-1">
                            <div class="dropdown">
                                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button" id="action"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Alpa
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="action">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                        <td class="col-lg-11" scope="row">Siswa</td>
                        <td class="col-lg-1">
                            <div class="dropdown">
                                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button" id="action"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Alpa
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="action">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                        <td class="col-lg-11" scope="row">Siswa</td>
                        <td class="col-lg-1">
                            <div class="dropdown">
                                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button" id="action"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Alpa
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="action">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                        <td class="col-lg-11" scope="row">Siswa</td>
                        <td class="col-lg-1">
                            <div class="dropdown">
                                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button" id="action"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Alpa
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="action">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                        <td class="col-lg-11" scope="row">Siswa</td>
                        <td class="col-lg-1">
                            <div class="dropdown">
                                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button" id="action"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Alpa
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="action">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                        <td class="col-lg-11" scope="row">Siswa</td>
                        <td class="col-lg-1">
                            <div class="dropdown">
                                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button" id="action"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Alpa
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="action">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                        <td class="col-lg-11" scope="row">Siswa</td>
                        <td class="col-lg-1">
                            <div class="dropdown">
                                <button class="btn border-dark dropdown-toggle" style="background-color: #C6D8AF;" type="button" id="action"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Alpa
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="action">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </td>
                        </div>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /table -->
    </div>

</body>

</html>