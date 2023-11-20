<?php
session_start();
require('db.php');

// Cek login guru
if (!isset($_SESSION["guru"])) {
    echo "<script>location='login.php'</script>";
    exit;
}

$guru = $_SESSION["guru"]["nip"];
$ambil_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = '$guru'");
$data = mysqli_fetch_array($ambil_guru);

// Mengambil daftar kelas yang diampu
$query_kelas = "SELECT DISTINCT k.kode_kelas FROM kelas k JOIN jadwal_pelajaran jp ON k.kode_kelas = jp.kode_kelas JOIN mata_pelajaran mp ON jp.kode_mapel = mp.kode_mapel WHERE mp.nip = '$guru'";
$hasil_kelas = mysqli_query($conn, $query_kelas);

$kelas_guru = [];
while ($kelas = mysqli_fetch_assoc($hasil_kelas)) {
    $kelas_guru[] = $kelas['kode_kelas'];
}

// Menangani pemilihan kelas dan pertemuan
$kelas_dipilih = $_GET['kelas'] ?? '';
$pertemuan_ke = $_GET['pertemuan_ke'] ?? '';
$daftar_siswa = [];

// Periksa apakah kelas dan pertemuan sudah dipilih
if ($kelas_dipilih && $pertemuan_ke) {
    $query_siswa = "SELECT s.nama, s.nisn FROM siswa s WHERE s.kode_kelas = '$kelas_dipilih'";
    $hasil_siswa = mysqli_query($conn, $query_siswa);

    while ($row = mysqli_fetch_assoc($hasil_siswa)) {
        $daftar_siswa[] = $row;
    }
}

// Menangani penyimpanan data absensi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kelas_dipilih = mysqli_real_escape_string($conn, $_POST['kelas']);
    $pertemuan_ke = mysqli_real_escape_string($conn, $_POST['pertemuan_ke']);

    // Mendapatkan id_jadwal dan kode_mapel
    $query_jadwal = "SELECT id_jadwal, kode_mapel FROM jadwal_pelajaran WHERE nip = '$guru' AND kode_kelas = '$kelas_dipilih' LIMIT 1";
    $hasil_jadwal = mysqli_query($conn, $query_jadwal);
    $data_jadwal = mysqli_fetch_assoc($hasil_jadwal);

    $id_jadwal = $data_jadwal['id_jadwal'];
    $kode_mapel = $data_jadwal['kode_mapel'];

    foreach ($_POST['absensi'] as $nisn => $keterangan) {
        $nisn = mysqli_real_escape_string($conn, $nisn);
        $keterangan = mysqli_real_escape_string($conn, $keterangan);

        // Simpan data absensi ke database
        $query_simpan = "INSERT INTO absensi (id_jadwal, pertemuan_ke, kode_mapel, nisn, keterangan, tanggal, waktu_input)
                 VALUES ('$id_jadwal', '$pertemuan_ke', '$kode_mapel', '$nisn', '$keterangan', CURDATE(), NOW())";
        mysqli_query($conn, $query_simpan);
    }
    echo "<script>alert('Absensi berhasil disimpan!'); location='inputabsensi-guru.php?kelas=$kelas_dipilih&pertemuan_ke=$pertemuan_ke';</script>";
    exit;
}
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
                <a href="listmodul-guru.php"><img src="../assets/transcript.svg" alt="List-Modul" />List Modul</a>
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
        <li>
            <a class="dropdown-item" href="inputabsensi-guru.php?kelas=<?php echo $kode_kelas; ?>">
                <?php echo $kode_kelas; ?>
            </a>
        </li>
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
    <?php for ($i = 1; $i <= 10; $i++): ?>
        <li>
            <a class="dropdown-item" href="inputabsensi-guru.php?kelas=<?php echo $kelas_dipilih; ?>&pertemuan_ke=<?php echo $i; ?>">
                Pertemuan <?php echo $i; ?>
            </a>
        </li>
    <?php endfor; ?>
</ul>
            </div>
            <!-- /button pertemuan -->
        </div>
        <!-- button group -->

        <!-- table -->
<?php if ($kelas_dipilih && $pertemuan_ke): ?>
    <form action="inputabsensi-guru.php" method="post">
    <input type="hidden" name="kelas" value="<?php echo $kelas_dipilih; ?>">
    <input type="hidden" name="pertemuan_ke" value="<?php echo $pertemuan_ke; ?>">
    <form action="inputabsensi-guru.php?kelas=<?php echo $kelas_dipilih; ?>&pertemuan_ke=<?php echo $pertemuan_ke; ?>" method="post">
            <table class="table table-striped table-fixed text-center">
        <thead style="background-color: #C6D8AF;">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($daftar_siswa as $siswa): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($siswa['nama']); ?></td>
                        <td>
                            <select name="absensi[<?php echo $siswa['nisn']; ?>]">
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Alpa">Alpa</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="edit-profile-buttons">
        <input type="submit" name="submit" value="Save" id="edit-button">
        </div>
    </form>
<?php endif; ?>
        <!-- /table -->
        
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>