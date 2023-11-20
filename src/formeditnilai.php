<?php
require('db.php'); // Pastikan jalur ke file db.php benar

$pesan = ""; // Variabel untuk menyimpan pesan status

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn = $_POST['nisn'];
    $kode_mapel = $_POST['kode_mapel'];
    $ph1 = $_POST['ph1'];
    $ph2 = $_POST['ph2'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];

    $query_update = "UPDATE nilai SET ph1 = '$ph1', ph2 = '$ph2', uts = '$uts', uas = '$uas' 
                     WHERE nisn = '$nisn' AND kode_mapel = '$kode_mapel'";
    if (mysqli_query($conn, $query_update)) {
        $pesan = "Nilai berhasil diperbarui.";
        echo "<script type='text/javascript'>
                alert('$pesan');
                window.location.href = 'https://siakadsmpn35.fkftask.my.id/src/editnilai-admin.php?nisn=" . $nisn . "';
              </script>";
    } else {
        $pesan = "Error: " . mysqli_error($conn);
        echo "<script type='text/javascript'>alert('$pesan');</script>";
    }
}

// Memeriksa apakah NISN dan kode_mapel diterima dari URL
if (!isset($_GET['nisn']) || !isset($_GET['kode_mapel'])) {
    echo "NISN atau kode mata pelajaran tidak ditemukan.";
    exit;
}

$nisn = $_GET['nisn'];
$kode_mapel = $_GET['kode_mapel'];

// Mengambil data nilai siswa
$query = "SELECT * FROM nilai WHERE nisn = '$nisn' AND kode_mapel = '$kode_mapel'";
$result = mysqli_query($conn, $query);
$nilai = mysqli_fetch_assoc($result);

if (!$nilai) {
    echo "Data nilai tidak ditemukan.";
    exit;
}

$query_siswa = "SELECT nama FROM siswa WHERE nisn = '$nisn'";
$siswa_result = mysqli_query($conn, $query_siswa);
$data_siswa = mysqli_fetch_assoc($siswa_result);
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
          <a href="datanilai-admin.php" class="active"
            ><img src="../assets/transcript.svg" alt="Data-Nilai" />Data Nilai</a
          >
        </li>
        <li>
          <a href="datamodul-admin.php" class="menu-end"><img src="../assets/transcript.svg" alt="Data-Modul" />Data Modul </a
          >
        </li>
      </ul>
    </nav>
    
    <!-- content -->
    <div class="kotak-isi">
    <div class="form-inputnilai">
        <h2><?php echo $data_siswa['nama']; ?></h2>
<form action="" method="POST">
    <div class="form-group">
        <!-- Isi formulir -->
        <input type="hidden" name="nisn" value="<?php echo $nisn; ?>">
        <input type="hidden" name="kode_mapel" value="<?php echo $kode_mapel; ?>">
        <div class="row">
                    <div class="col">
                        <label for="ph1">PH1</label>
                        <input type="number" name="ph1" required autocomplete="off" value="<?php echo $nilai['ph1']; ?>">
                    </div>
                    <div class="col">
                        <label for="ph2">PH2</label>
                        <input type="number" name="ph2" required autocomplete="off" value="<?php echo $nilai['ph2']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="uts">Nilai UTS</label>
                        <input type="number" name="uts" required autocomplete="off" value="<?php echo $nilai['uts']; ?>">
                    </div>
                    <div class="col">
                        <label for="uas">Nilai UAS</label>
                        <input type="number" name="uas" required autocomplete="off" value="<?php echo $nilai['uas']; ?>">
                    </div>
                </div>
            </div>
        <button type="submit" id="edit-button">Save</button>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
