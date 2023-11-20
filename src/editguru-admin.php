<?php
session_start();
require('db.php');
if (!isset($_SESSION["admin"])) {
    echo "<script>location='login.php'</script>";
    exit;
}
$admin = $_SESSION["admin"]["nip"];
$ambil_admin = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '$admin'");
$data_admin = mysqli_fetch_array($ambil_admin);

// Mengambil NIP guru dari URL
if (isset($_GET['nip'])) {
    $nip_guru = $_GET['nip'];
} else {
    echo "<script>alert('NIP guru tidak ditemukan!'); window.location='daftarguru-admin.php';</script>";
    exit;
}

// Query untuk mengambil data guru
$query_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = '$nip_guru'");
$data_guru = mysqli_fetch_array($query_guru);

if (!$data_guru) {
    echo "<script>alert('Data guru tidak ditemukan!'); window.location='daftarguru-admin.php';</script>";
    exit;
}

// Definisi variabel untuk validasi
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
                        <input type="text" name="nama" value="<?php echo $data_guru['nama'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="nisn">NIP :</label>
                        <input type="text" name="nip" value="<?php echo $data_guru['nip'] ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label for="tempat-lahir">Tempat Lahir :</label>
                        <input type="text" name="tempat_lahir" value="<?php echo $data_guru['tempat_lahir'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="no-hp">No HP :</label>
                        <input type="text" name="no_hp" value="<?php echo $data_guru['no_hp'] ?>" />
                    </div>

                </div>
                <div class="column">
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="text" name="email" value="<?php echo $data_guru['email'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="tanggal-lahir">Tanggal Lahir :</label>
                        <input type="text" name="tanggal_lahir" value="<?php echo $data_guru['tanggal_lahir'] ?>" />
                    </div>
                    <div class="form-group">
                    <label for="jenis-kelamin">Jenis Kelamin :</label>
                    <select name="jenis_kelamin" id="jenis-kelamin">
                            <option value="Laki-Laki" <?php if($data_guru['jenis_kelamin'] == 'Laki-Laki') echo 'selected'; ?>>Laki-Laki</option>
                            <option value="Perempuan" <?php if($data_guru['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama :</label>
                        <select name="agama" id="agama">
                            <option value="Islam" <?php if($data_guru['agama'] == 'Islam') echo 'selected'; ?>>Islam</option>
                            <option value="Kristen" <?php if($data_guru['agama'] == 'Kristen') echo 'selected'; ?>>Kristen</option>
                            <option value="Katholik" <?php if($data_guru['agama'] == 'Katholik') echo 'selected'; ?>>Katholik</option>
                            <option value="Hindu" <?php if($data_guru['agama'] == 'Hindu') echo 'selected'; ?>>Hindu</option>
                            <option value="Budha" <?php if($data_guru['agama'] == 'Budha') echo 'selected'; ?>>Budha</option>
                            <option value="Kong Hu Chu" <?php if($data_guru['agama'] == 'Kong Hu Chu') echo 'selected'; ?>>Kong Hu Chu</option>
                        </select>
                    </div>
                    <div class="form-group" style="border-bottom: none">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" value="<?php echo $data_guru['alamat'] ?>" />
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
    $tempat_lahir = $_POST['tempat_lahir'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];

    // Validasi data
    $error_message = "";
    // Tambahkan validasi lainnya jika perlu

    // Penanganan upload foto
    if ($_FILES['foto']['error'] == 0) {
        $filename = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_type = $_FILES['foto']['type'];
        $file_size = $_FILES['foto']['size'];

        $allowed_types = array('image/jpeg', 'image/png', 'image/jpg');
        if (in_array($file_type, $allowed_types) && $file_size <= 1000000) {
            $destination = "image/" . $filename;
            move_uploaded_file($file_tmp, $destination);
        } else {
            $error_message .= "File tidak valid atau terlalu besar. ";
        }
    } else {
        $filename = $data_guru['foto'];
    }

    if (empty($error_message)) {
        $update_query = "UPDATE guru SET 
                        nama = '$nama',
                        tempat_lahir = '$tempat_lahir',
                        no_hp = '$no_hp',
                        email = '$email',
                        tanggal_lahir = '$tanggal_lahir',
                        jenis_kelamin = '$jenis_kelamin',
                        agama = '$agama',
                        alamat = '$alamat',
                        foto = '$filename'
                        WHERE nip = '$nip_guru'";

        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "<script>alert('Data berhasil diupdate!'); window.location='daftarguru-admin.php';</script>";
        } else {
            echo "<script>alert('Update gagal: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('$error_message');</script>";
    }
}
?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>