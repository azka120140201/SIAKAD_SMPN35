<?php
session_start();
require('db.php');
if (!isset($_SESSION["guru"])) {
    echo "<script>location='login.php'</script>";
}
$guru = $_SESSION["guru"]["nip"];
$ambil_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = '$guru'");
$data = mysqli_fetch_array($ambil_guru);

$nip_guru = $data['nip'];
$query_mapel = "SELECT * FROM mata_pelajaran WHERE nip = '$nip_guru' AND aktif='Ya'";
$hasil_mapel = mysqli_query($conn, $query_mapel);
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
                <select class="form-select border-dark" id="mataPelajaranSelect" name="mata_pelajaran">
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