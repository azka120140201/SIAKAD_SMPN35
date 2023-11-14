<?php
session_start();
require('db.php');
if (!isset($_SESSION["guru"])) {
  echo "<script>location='login.php'</script>";
}
$guru = $_SESSION["guru"]["nip"];
$ambil_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = $guru");
$data = mysqli_fetch_array($ambil_guru);
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <header>
    <div class="logo-text">
      <a href="dashboard-guru.php">
        <img src="../assets/LogoSMPN35.png" alt="LogoSMPN35" width="80px"/>
      </a>
    </div>
    <div class="title-text">
      <a href="dashboard-guru.php">
        <h1>SIAKAD | Guru</h1>
        <span>SMP Negeri 35 Bandar Lampung</span>
      </a>
    </div>
    <div class="profile-button">
      <a href="profile-guru.php"><iconify-icon icon="material-symbols:person" width="30" class="align-middle p-3"></iconify-icon><a href="profile-guru.php"><?php echo $data['nama'] ?></a>
    </div>
    <div class="logout-button">
      <a href="login.php"><iconify-icon icon="material-symbols:logout" width="30" class="align-middle p-3"></iconify-icon>Logout</a>
    </div>
  </header>

  <div class="kotak-isi-profile">
        <div class="profile-picture">
            <img id="profile-image" src="image/<?php echo $data['foto'] ?>" alt="Profile Picture" />

            <div class="data-diri-profile">
                <div class="column">
                    <div class="data-item">
                        <label for="nama">Nama :</label>
                        <span id="nisn"><?php echo $data['nama'] ?></span>
                    </div>
                    <div class="data-item">
                        <label for="nisn">NIP :</label>
                        <span id="nisn"><?php echo $data['nip'] ?></span>
                    </div>
                    <div class="data-item">
                        <label for="tempat-lahir">Tempat Lahir :</label>
                        <span id="tempat-lahir"><?php echo $data['tempat_lahir'] ?></span>
                    </div>
                    <div class="data-item">
                        <label for="no-hp">No HP :</label>
                        <span id="no-hp"><?php echo $data['no_hp'] ?></span>
                    </div>

                </div>
                <div class="column">
                    <div class="data-item">
                        <label for="email">Email :</label>
                        <span id="email"><?php echo $data['email'] ?></span>
                    </div>
                    <div class="data-item">
                        <label for="tanggal-lahir">Tanggal Lahir :</label>
                        <span id="tanggal-lahir"><?php echo $data['tanggal_lahir'] ?></span>
                    </div>
                    <div class="data-item">
                        <label for="jenis-kelamin">Jenis Kelamin :</label>
                        <span id="jenis-kelamin"><?php echo $data['jenis_kelamin'] ?></span>
                    </div>
                    <div class="data-item">
                        <label for="agama">Agama :</label>
                        <span id="agama"><?php echo $data['agama'] ?></span>
                    </div>
                    <div class="data-item">
                        <label for="alamat">Alamat Lengkap :</label>
                        <span id="alamat"><?php echo $data['alamat'] ?></span>
                    </div>
                </div>
            </div>

            <div class="edit-profile-buttons">
                <a href="edit-guru.php" id="edit-button">Edit</a>
                <button id="save-button" style="display: none;">Simpan</button>
            </div>
        </div>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>