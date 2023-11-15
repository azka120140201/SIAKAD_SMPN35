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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
            <a href="profile-admin.php"><iconify-icon icon="material-symbols:person" width="35"
                    class="align-middle p-3"></iconify-icon>
                Admin
            </a>
        </div>
        <div class="logout-button">
            <a href="login.php"><iconify-icon icon="material-symbols:logout" width="35"
                    class="align-middle p-3"></iconify-icon>Logout</a>
        </div>
    </header>

  <nav>
    <ul class="side-menu">
      <li class="menu-disabled"><span>Menu</span></li>
      <li>
        <a href="#"><img src="../assets/transcript.svg" alt="Daftar-Guru" />Daftar
          Guru</a>
      </li>
      <li>
        <a href="#"><img src="../assets/transcript.svg" alt="Daftar-Siswa" />Daftar
          Siswa</a>
      </li>
      <li>
        <a href="datanilai-admin.php"><img src="../assets/transcript.svg" alt="Data-Nilai" />Data Nilai</a>
      </li>
      <li>
        <a href="#" class="menu-end"><img src="../assets/transcript.svg" alt="Edit-Modul" />Edit Modul</a>
      </li>
    </ul>
  </nav>

  <div class="kotak-isi"></div>
</body>

</html>