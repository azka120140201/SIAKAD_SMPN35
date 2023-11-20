<?php
session_start();
require('db.php');
if (!isset($_SESSION["admin"])) {
  echo "<script>location='login.php'</script>";
}
$admin = $_SESSION["admin"]["nip"];
$ambil_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '$admin'");
$data = mysqli_fetch_array($ambil_admin);

$nama_max_length = 50;
$tempat_lahir_max_length = 30;
$email_max_length = 30;
$no_hp_max_length = 15;
$alamat_max_length = 100;
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
                        <label for="nisn">NIP :</label>
                        <input type="text" name="nip" value="<?php echo $data['nip'] ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label for="tempat-lahir">Tempat Lahir :</label>
                        <input type="text" name="tempat_lahir" value="<?php echo $data['tempat_lahir'] ?>" />
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
                    <select name="jenis_kelamin" id="jenis-kelamin">
                            <option value="Laki-Laki" <?php if($data['jenis_kelamin'] == 'Laki-Laki') echo 'selected'; ?>>Laki-Laki</option>
                            <option value="Perempuan" <?php if($data['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama :</label>
                        <select name="agama" id="agama">
                            <option value="Islam" <?php if($data['agama'] == 'Islam') echo 'selected'; ?>>Islam</option>
                            <option value="Kristen" <?php if($data['agama'] == 'Kristen') echo 'selected'; ?>>Kristen</option>
                            <option value="Katholik" <?php if($data['agama'] == 'Katholik') echo 'selected'; ?>>Katholik</option>
                            <option value="Hindu" <?php if($data['agama'] == 'Hindu') echo 'selected'; ?>>Hindu</option>
                            <option value="Budha" <?php if($data['agama'] == 'Budha') echo 'selected'; ?>>Budha</option>
                            <option value="Kong Hu Chu" <?php if($data['agama'] == 'Kong Hu Chu') echo 'selected'; ?>>Kong Hu Chu</option>
                        </select>
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
            $nip = $_POST['nip'];
            $tempat_lahir = $_POST['tempat_lahir'];
            $no_hp = $_POST['no_hp'];
            $email = $_POST['email'];
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $agama = $_POST['agama'];
            $alamat = $_POST['alamat'];
            
            $error_message = "";
            if (strlen($nama) > $nama_max_length) {
                $error_message .= "Panjang Nama tidak boleh lebih dari $nama_max_length karakter.\\n";
            }
            if (strlen($tempat_lahir) > $tempat_lahir_max_length) {
                $error_message .= "Panjang Tempat Lahir tidak boleh lebih dari $tempat_lahir_max_length karakter.\\n";
            }
            if (strlen($email) > $email_max_length) {
                $error_message .= "Panjang Email tidak boleh lebih dari $email_max_length karakter.\\n";
            }
            if (strlen($no_hp) > $no_hp_max_length) {
                $error_message .= "Panjang No HP tidak boleh lebih dari $no_hp_max_length karakter.\\n";
            }
            if (strlen($alamat) > $alamat_max_length) {
                $error_message .= "Panjang Alamat tidak boleh lebih dari $alamat_max_length karakter.\\n";
            }
            if ($error_message) {
                echo "<script>alert('$error_message');</script>";
            } else {
            $filename1 = $_FILES['foto']['name'];
            $tmp_name1 = $_FILES['foto']['tmp_name'];
            $ukuran1 = $_FILES['foto']['size'];
            $type1 = explode('.', $filename1); // file kegiatan pembelajaran
            $type2 = $type1[1];
            $newname1 = time() . '.' . $type2;
            $tipe_diizinkan = array('jpg', 'jpeg', 'png', '');

            $dest = "image/" . $_FILES['foto']['name'];
            move_uploaded_file($tmp_name1, './image/' . $newname1);

            $update = mysqli_query($conn, "UPDATE admin SET 
                nama = '$nama',
                nip = '$nip',
                tempat_lahir = '$tempat_lahir',
                no_hp = '$no_hp',
                email = '$email',
                tanggal_lahir = '$tanggal_lahir',
                jenis_kelamin = '$jenis_kelamin',
                agama = '$agama',
                alamat = '$alamat',
                foto = '$newname1'
                WHERE nip = '$admin'");
            if ($update) {
                echo
                '<script>
                  window.location="profile-admin.php";
                  alert("data berhasil di update");
                  </script>';
            } else {
                echo 'gagal ' . mysqli_error($conn);
            }
        }
    }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>