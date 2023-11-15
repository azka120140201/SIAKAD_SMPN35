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
                <a href="listmodul-guru.php"><img src="../assets/transcript.svg" alt="List-Modul" />List Modul</a>
            </li>
            <li>
                <a href="tambahmodul-guru.php" class="menu-end" style=background-color:#Cff59f><img src="../assets/transcript.svg" alt="Tambah-Modul" />Tambah
                    Modul</a>
            </li>
        </ul>
    </nav>
    <!-- /sidebar -->

    <!-- container -->
    <div class="kotak-isi">
        <div class="form-edit-modul">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="column">
                    <div class="form-group">
                        <label for="nama_modul">Nama Modul:</label>
                        <input type="text" name="nama_modul" required />
                    </div>
                    <div class="form-group">
                        <label for="mata_pelajaran">Mata Pelajaran:</label>
                        <select name="mata_pelajaran" required>
                            <?php foreach ($mata_pelajaran as $mapel) : ?>
                                <option value="<?php echo $mapel['id']; ?>"><?php echo $mapel['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_modul">Upload File Modul:</label>
                        <input type="file" name="file_modul" required />
                    </div>
                </div>


                <div class="edit-profile-buttons">
                    <input type="submit" name="submit" value="Save" id="edit-button">
                </div>
            </form>
        </div>
        <div class="" style="position:absolute; z-index:999">
            <?php
            if (isset($_POST['submit'])) {
                $nama_modul = $_POST['nama_modul'];
                $id_mata_pelajaran = $_POST['mata_pelajaran'];

                // Upload file modul
                $filename_modul = $_FILES['file_modul']['name'];
                $tmp_name_modul = $_FILES['file_modul']['tmp_name'];
                $ukuran_modul = $_FILES['file_modul']['size'];
                $type_modul = explode('.', $filename_modul);
                $type_modul = end($type_modul);
                $newname_modul = time() . '.' . $type_modul;
                $tipe_diizinkan = array('pdf', 'doc', 'docx', 'ppt', 'pptx');

                if (in_array($type_modul, $tipe_diizinkan)) {
                    $dest_modul = "modul/" . $newname_modul;
                    move_uploaded_file($tmp_name_modul, './modul/' . $newname_modul);

                    $insert_modul = mysqli_query($conn, "INSERT INTO modul (nama_modul, id_mata_pelajaran, file_modul) VALUES ('$nama_modul', '$id_mata_pelajaran', '$newname_modul')");

                    if ($insert_modul) {
                        echo
                        '<script>
                    window.location="listmodul-guru.php";
                    alert("Modul berhasil ditambahkan");
                    </script>';
                    } else {
                        echo 'gagal ' . mysqli_error($conn);
                    }
                } else {
                    echo '<script>alert("Format file tidak diizinkan. Hanya file PDF, DOC, DOCX, PPT, dan PPTX yang diizinkan.");</script>';
                }
            }
            ?>
        </div>
    </div>
    <!-- /container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>