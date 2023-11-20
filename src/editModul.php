<?php
session_start();
require('db.php');
if (!isset($_SESSION["admin"])) {
  echo "<script>location='login.php'</script>";
}
$admin = $_SESSION["admin"]["nip"];
$ambil_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '$admin'");
$data = mysqli_fetch_array($ambil_admin);

// Cek apakah ID modul ada di URL
if (!isset($_GET['id_modul'])) {
    echo "<script>alert('ID modul tidak ditemukan.'); window.location='datamodul-admin.php';</script>";
    exit;
}

$query_mapel = "SELECT * FROM mata_pelajaran";
$hasil_mapel = mysqli_query($conn, $query_mapel);
$mata_pelajaran = mysqli_fetch_all($hasil_mapel, MYSQLI_ASSOC);

$id_modul = $_GET['id_modul'];

// Ambil data modul dari database
$query = "SELECT * FROM modul WHERE id_modul = '$id_modul'";
$result = mysqli_query($conn, $query);

if ($result) {
    $modul = mysqli_fetch_assoc($result);
    if (!$modul) {
        echo "<script>alert('Data modul tidak ditemukan.'); window.location='datamodul-admin.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Gagal mengambil data modul.'); window.location='datamodul-admin.php';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $nama_file = $_POST['nama_file'];
    $kode_mapel = $_POST['mata_pelajaran'];
    $file_lama = $modul['file_upload'];

    // Cek apakah file baru diupload
    if ($_FILES['file_upload']['error'] == 0) {
        $filename = $_FILES['file_upload']['name'];
        $file_tmp = $_FILES['file_upload']['tmp_name'];

        // Tempat menyimpan file baru
        $destination = "../modul/" . $filename; // path relatif dari src ke modul

// Pindahkan file baru ke lokasi yang ditentukan
if (move_uploaded_file($file_tmp, $destination)) {
    // Hapus file lama jika ada
    $oldFilePath = "../modul/" . $file_lama; // path relatif dari src ke modul
    if (file_exists($oldFilePath)) {
        unlink($oldFilePath);
    }
} else {
    echo "<script>alert('Gagal mengupload file.'); window.location='editModul.php?id_modul=$id_modul';</script>";
    exit;
}
    } else {
        $filename = $file_lama;
    }

    // Update data modul di database
    $update_query = "UPDATE modul SET 
                        nama_file = '$nama_file', 
                        kode_mapel = '$kode_mapel', // Update kode_mapel
                        file_upload = '$filename' 
                     WHERE id_modul = '$id_modul'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Modul berhasil diperbarui.'); window.location='datamodul-admin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui modul.'); window.location='editModul.php?id_modul=$id_modul';</script>";
    }
}
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
        <div class="form-edit-modul">
            <form action="editModul.php?id_modul=<?php echo $id_modul; ?>" method="post" enctype="multipart/form-data">
                <div class="column">
                    <div class="form-group">
                        <label for="nama_file">Nama Modul:</label>
            <input type="text" name="nama_file" value="<?php echo $modul['nama_file']; ?>"><br>
                    </div>
                    <div class="form-group">
                        <label for="mata_pelajaran">Mata Pelajaran:</label>
                        <select name="mata_pelajaran" required>
    <?php foreach ($mata_pelajaran as $mapel) : ?>
        <option value="<?php echo $mapel['kode_mapel']; ?>" 
            <?php echo ($mapel['kode_mapel'] == $modul['kode_mapel']) ? 'selected' : ''; ?>>
            <?php echo $mapel['nama_mapel']; ?>
        </option>
    <?php endforeach; ?>
</select>
                    </div>
                    <div class="form-group">
                        <label for="file_upload">File Modul:</label>
            <input type="file" name="file_upload"><br>
            <small>File saat ini: <?php echo $modul['file_upload']; ?></small><br>
                    </div>
                </div>


                <div class="edit-profile-buttons">
                    <input type="submit" name="submit" value="Save" id="edit-button">
                </div>
            </form>
        </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>