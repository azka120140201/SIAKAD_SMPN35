<?php
session_start();
require('db.php');
if (!isset($_SESSION["admin"])) {
  echo "<script>location='login.php'</script>";
}
$admin = $_SESSION["admin"]["nip"];
$ambil_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '$admin'");
$data = mysqli_fetch_array($ambil_admin);

// Query untuk mengambil semua mata pelajaran
$query_mapel = "SELECT * FROM mata_pelajaran";
$hasil_mapel = mysqli_query($conn, $query_mapel);
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
          <a href="datanilai-admin.php"
            ><img src="../assets/transcript.svg" alt="Data-Nilai" />Data Nilai</a
          >
        </li>
        <li>
          <a href="datamodul-admin.php" class="menu-end" style=background-color:#Cff59f><img src="../assets/transcript.svg" alt="Data-Modul" />Data Modul </a
          >
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
                <th>Action</th>
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
    xhr.open('GET', 'getModulByMapel.php?kode_mapel=' + kodeMapel, true);
    xhr.onload = function() {
        if (this.status == 200) {
            var data = JSON.parse(this.responseText);
            var html = '';
            data.forEach(function(modul) {
                html += '<tr>';
                html += '<td>' + modul.nama_file + '</td>';
                html += '<td>' + modul.tanggal_upload + '</td>';
                html += '<td><a href="modul/' + modul.file_upload + '" target="_blank">Preview</a></td>';
                // Tambahkan tombol edit dan hapus
                html += '<td><a href="editModul.php?id_modul=' + modul.id_modul + '">Edit</a> | ';
                html += '<a href="deleteModul.php?id_modul=' + modul.id_modul + '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus modul ini?\')">Hapus</a></td>';
                html += '</tr>';
            });
            document.getElementById('daftarModul').innerHTML = html;
        }
    }
    xhr.send();
});
</script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>