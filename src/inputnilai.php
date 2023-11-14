<?php
session_start();
require('db.php');
if (!isset($_SESSION["guru"])) {
    echo "<script>location='login.php'</script>";
}
$guru = $_SESSION["guru"]["nip"];
$ambil_guru = mysqli_query($conn, "SELECT * FROM guru WHERE nip = $guru");
$data = mysqli_fetch_array($ambil_guru);

// Pastikan parameter NISN tersedia
if (!isset($_GET['nisn'])) {
    echo "<script>alert('Parameter NISN tidak ditemukan.'); window.location='inputnilai-guru.php';</script>";
    exit();
}

$nisn = mysqli_real_escape_string($conn, $_GET['nisn']);

// Query untuk mengambil data siswa berdasarkan NISN
$query_siswa = "SELECT * FROM siswa WHERE nisn = '$nisn'";
$result_siswa = mysqli_query($conn, $query_siswa);

// Pastikan siswa dengan NISN tersebut ada
if (mysqli_num_rows($result_siswa) === 0) {
    echo "<script>alert('Siswa dengan NISN tersebut tidak ditemukan.'); window.location='inputnilai-guru.php';</script>";
    exit();
}

$data_siswa = mysqli_fetch_assoc($result_siswa);

// Query untuk mengambil nilai dari database jika sudah ada
$query_nilai = "SELECT * FROM nilai WHERE nisn = '$nisn'";
$result_nilai = mysqli_query($conn, $query_nilai);

// Inisialisasi nilai default
$nilai_default = ['ph1' => '', 'ph2' => '', 'uts' => '', 'uas' => ''];

// Jika nilai sudah ada, ambil nilai dari database
if (mysqli_num_rows($result_nilai) > 0) {
    $data_nilai = mysqli_fetch_assoc($result_nilai);
    $nilai_default = [
        'ph1' => $data_nilai['ph1'],
        'ph2' => $data_nilai['ph2'],
        'uts' => $data_nilai['uts'],
        'uas' => $data_nilai['uas']
    ];
}

// Tambahkan logika untuk menyimpan nilai yang diinput oleh guru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai-nilai yang diinput
    $ph1 = $_POST['ph1'];
    $ph2 = $_POST['ph2'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];

    // Lakukan validasi input nilai jika diperlukan

    // Query untuk menyimpan atau mengupdate nilai ke database
    if (mysqli_num_rows($result_nilai) > 0) {
        // Jika nilai sudah ada, lakukan update
        $query_update_nilai = "UPDATE nilai SET ph1='$ph1', ph2='$ph2', uts='$uts', uas='$uas' WHERE nisn='$nisn'";
        $result_update_nilai = mysqli_query($conn, $query_update_nilai);

        if ($result_update_nilai) {
            echo "<script>alert('Nilai berhasil diupdate.'); window.location='inputnilai-guru.php?kelas=" . $data_siswa['kode_kelas'] . "';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal mengupdate nilai.'); window.location='inputnilai-guru.php?kelas=" . $data_siswa['kode_kelas'] . "';</script>";
            exit();
        }
    } else {
        // Jika belum ada, lakukan insert
        $query_input_nilai = "INSERT INTO nilai (nisn, ph1, ph2, uts, uas) VALUES ('$nisn', '$ph1', '$ph2', '$uts', '$uas')";
        $result_input_nilai = mysqli_query($conn, $query_input_nilai);

        if ($result_input_nilai) {
            echo "<script>alert('Nilai berhasil diinput.'); window.location='inputnilai-guru.php?kelas=" . $data_siswa['kode_kelas'] . "';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal menyimpan nilai.'); window.location='inputnilai-guru.php?kelas=" . $data_siswa['kode_kelas'] . "';</script>";
            exit();
        }
    }
}
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
            <a href="profile-guru.php"><iconify-icon icon="material-symbols:person" width="30" class="align-middle p-3"></iconify-icon><a href="profile-guru.php"><?php echo $data['nama'] ?></a>
        </div>
        <div class="logout-button">
            <a href="login.php"><iconify-icon icon="material-symbols:logout" width="30" class="align-middle p-3"></iconify-icon>Logout</a>
        </div>
    </header>

    <!-- Content -->
    <div class="form-inputnilai">
        <h2><?php echo $data_siswa['nama']; ?></h2>
        <form action="" method="POST">
            <!-- Tambahkan formulir untuk input nilai sesuai kebutuhan -->
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="ph1">PH1</label>
                        <input type="number" name="ph1" required autocomplete="off" value="<?php echo $nilai_default['ph1']; ?>">
                    </div>
                    <div class="col">
                        <label for="ph2">PH2</label>
                        <input type="number" name="ph2" required autocomplete="off" value="<?php echo $nilai_default['ph2']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="uts">Nilai UTS</label>
                        <input type="number" name="uts" required autocomplete="off" value="<?php echo $nilai_default['uts']; ?>">
                    </div>
                    <div class="col">
                        <label for="uas">Nilai UAS</label>
                        <input type="number" name="uas" required autocomplete="off" value="<?php echo $nilai_default['uas']; ?>">
                    </div>
                </div>
            </div>
            <button type="submit" id="edit-button">Save</button>
        </form>
    </div>
    <!-- /Content -->

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
