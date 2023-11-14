<?php
session_start();
require('db.php');
if (!isset($_SESSION["siswa"])) {
    echo "<script>location='login.php'</script>";
}
$siswa = $_SESSION["siswa"]["nisn"];
$ambil_siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = $siswa");
$data = mysqli_fetch_array($ambil_siswa);
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
            <a href="profile-siswa.php"><iconify-icon icon="material-symbols:person" width="35" class="align-middle p-3"></iconify-icon><?php echo $data['nama'] ?></a>
        </div>
        <div class="logout-button">
            <a href="login.php"><iconify-icon icon="material-symbols:logout" width="35" class="align-middle p-3"></iconify-icon>Logout</a>
        </div>
    </header>

    <div class="form-edit-profil">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="profile-picture">
                <img id="profile-image" src="../assets/default-profile-picture.jpg" alt="Profile Picture" />
                <div class="form-group">
                    <label>Upload Foto:</label>
                    <input type="file" name="foto" />
                </div>
            </div>

            <div class="data-diri-profile-edit" style="border: none;">
                <div class="column">
                    <div class="form-group">
                        <label for="nama">Nama :</label>
                        <input type="text" name="nama" value="<?php echo $data['nama'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="nisn">NISN :</label>
                        <input type="text" name="nisn" value="<?php echo $data['nisn'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas :</label>
                        <input type="text" name="kode_kelas" value="<?php echo $data['kode_kelas'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="tempat-lahir">Tempat Lahir :</label>
                        <input type="text" name="tempat_lahir" value="<?php echo $data['tempat_lahir'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="angkatan">Angkatan :</label>
                        <input type="text" name="angkatan" value="<?php echo $data['angkatan'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="no-hp">No HP :</label>
                        <input type="text" name="no_hp" value="<?php echo $data['no_hp'] ?>" />
                    </div>

                </div>
                <div class="column">
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="text" name="email" value="<?php echo $data['email'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="tanggal-lahir">Tanggal Lahir :</label>
                        <input type="text" name="tanggal_lahir" value="<?php echo $data['tanggal_lahir'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="jenis-kelamin">Jenis Kelamin :</label>
                        <input type="text" name="jenis_kelamin" value="<?php echo $data['jenis_kelamin'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama :</label>
                        <input type="text" name="agama" value="<?php echo $data['agama'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="nama-wali">Nama Wali :</label>
                        <input type="text" name="nama_wali" value="<?php echo $data['nama_wali'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="no-wali">Nomor Telepon Wali :</label>
                        <input type="text" name="no_telepon_wali" value="<?php echo $data['no_telepon_wali'] ?>" />
                    </div>
                    <div class="form-group" style="border-bottom: none">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" value="<?php echo $data['alamat'] ?>" />
                    </div>
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
            $nama = $_POST['nama'];
            $nisn = $_POST['nisn'];
            $kode_kelas = $_POST['kode_kelas'];
            $tempat_lahir = $_POST['tempat_lahir'];
            $angkatan = $_POST['angkatan'];
            $no_hp = $_POST['no_hp'];
            $email = $_POST['email'];
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $agama = $_POST['agama'];
            $nama_wali = $_POST['nama_wali'];
            $no_telepon_wali = $_POST['no_telepon_wali'];
            $alamat = $_POST['alamat'];

            $filename1 = $_FILES['foto']['name'];
            $tmp_name1 = $_FILES['foto']['tmp_name'];
            $ukuran1 = $_FILES['foto']['size'];
            $type1 = explode('.', $filename1); // file kegiatan pembelajaran
            $type2 = $type1[1];
            $newname1 = time() . '.' . $type2;
            $tipe_diizinkan = array('jpg', 'jpeg', 'png', '');

            $dest = "image/" . $_FILES['foto']['name'];
            move_uploaded_file($tmp_name1, './image/' . $newname1);

            $update = mysqli_query($conn, "UPDATE siswa SET 
                nama = '$nama',
                nisn = '$nisn',
                kode_kelas = '$kode_kelas',
                tempat_lahir = '$tempat_lahir',
                angkatan = '$angkatan',
                no_hp = '$no_hp',
                email = '$email',
                tanggal_lahir = '$tanggal_lahir',
                jenis_kelamin = '$jenis_kelamin',
                agama = '$agama',
                nama_wali = '$nama_wali',
                no_telepon_wali = '$no_telepon_wali',
                alamat = '$alamat',
                foto = '$newname1'
                WHERE nisn = '$siswa'");
            if ($update) {
                echo
                '<script>
                  window.location="profile-siswa.php";
                  alert("data berhasil di update");
                  </script>';
            } else {
                echo 'gagal ' . mysqli_error($conn);
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>