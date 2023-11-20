<?php
session_start();
require('db.php');
if (!isset($_SESSION["siswa"])) {
    echo "<script>location='login.php'</script>";
}
$siswa = $_SESSION["siswa"]["nisn"];
$ambil_siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = $siswa");
$data = mysqli_fetch_array($ambil_siswa);

// Query untuk mendapatkan mata pelajaran berdasarkan jadwal pelajaran siswa
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
                <select class="form-select border-dark" id="mataPelajaranSelect" name="mata_pelajaran" onchange="tampilkanModul(this.value);">
    <option selected disabled>Pilih Mata Pelajaran</option>
    <?php while($mapel = mysqli_fetch_assoc($hasil_mapel)): ?>
        <option value="<?php echo $mapel['kode_mapel']; ?>"><?php echo $mapel['nama_mapel']; ?></option>
    <?php endwhile; ?>
</select>
            </div>
        </div>
        <!-- /button pilih mata pelajaran -->
        <!-- list item table -->
        <div class="container">
      <table class="table table-striped table-fixed text-center">
          <thead style="background-color: #C6D8AF;">
            <tr>
                <th>Nama Modul</th>
                <th>Tanggal Upload</th>
                <th>Link Akses</th>
            </tr>
        </thead>
        <tbody id="daftarModul">
            <!-- Daftar modul akan dimuat di sini -->
        </tbody>
    </table>
</div>
        <!-- /list item table -->
    </div>
    <!-- /container -->
    
    <script>
document.getElementById('mataPelajaranSelect').addEventListener('change', function() {
    var kodeMapel = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'getModul.php?kode_mapel=' + kodeMapel, true);
    xhr.onload = function() {
        if (this.status == 200) {
            var data = JSON.parse(this.responseText);
            var html = '';
            data.forEach(function(modul) {
                html += '<tr>';
                html += '<td>' + modul.nama_modul + '</td>';
                html += '<td>' + modul.tanggal_upload + '</td>';
                html += '<td><a href="#" onclick="previewModul(\'' + modul.file_url + '\')">Preview</a></td>';
                html += '</tr>';
            });
            document.getElementById('daftarModul').innerHTML = html;
        }
    }
    xhr.send();
});

function previewModul(fileUrl) {
    window.open(fileUrl, '_blank'); // Membuka modul dalam tab baru
}
</script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>