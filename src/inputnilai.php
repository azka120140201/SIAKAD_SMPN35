<?php
session_start();
require('db.php');
if (!isset($_SESSION["guru"])) {
    echo "<script>location='login.php'</script>";
}
$guru = $_SESSION["guru"]["nip"];

// Memastikan parameter NISN dan kode_mapel_guru tersedia
if (!isset($_GET['nisn']) || !isset($_GET['kode_mapel_guru'])) {
    echo "<script>alert('Parameter tidak lengkap.'); window.location='inputnilai-guru.php';</script>";
    exit();
}

$nisn = mysqli_real_escape_string($conn, $_GET['nisn']);
$kode_mapel_guru = mysqli_real_escape_string($conn, $_GET['kode_mapel_guru']);

// Validasi guru dan mata pelajaran
$query_validasi = "SELECT * FROM mata_pelajaran WHERE nip = '$guru' AND kode_mapel_guru = '$kode_mapel_guru'";
$result_validasi = mysqli_query($conn, $query_validasi);
if (mysqli_num_rows($result_validasi) === 0) {
    echo "<script>alert('Anda tidak mengampu mata pelajaran ini.'); window.location='inputnilai-guru.php';</script>";
    exit();
}

// Query untuk mengambil data siswa dan nilai
$query_siswa = "SELECT * FROM siswa WHERE nisn = '$nisn'";
$result_siswa = mysqli_query($conn, $query_siswa);

if (mysqli_num_rows($result_siswa) === 0) {
    echo "<script>alert('Siswa dengan NISN tersebut tidak ditemukan.'); window.location='inputnilai-guru.php';</script>";
    exit();
}

$data_siswa = mysqli_fetch_assoc($result_siswa);

// Inisialisasi nilai default
$nilai_default = ['ph1' => '', 'ph2' => '', 'uts' => '', 'uas' => ''];

// Query untuk mengambil nilai dari database jika sudah ada
$query_nilai = "SELECT * FROM nilai WHERE nisn = '$nisn' AND kode_mapel_guru = '$kode_mapel_guru'";
$result_nilai = mysqli_query($conn, $query_nilai);

if (mysqli_num_rows($result_nilai) > 0) {
    $data_nilai = mysqli_fetch_assoc($result_nilai);
    $nilai_default = [
        'ph1' => $data_nilai['ph1'],
        'ph2' => $data_nilai['ph2'],
        'uts' => $data_nilai['uts'],
        'uas' => $data_nilai['uas']
    ];
}

// Logika untuk menyimpan nilai yang diinput oleh guru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil nilai-nilai yang diinput
    $ph1 = mysqli_real_escape_string($conn, $_POST['ph1']);
    $ph2 = mysqli_real_escape_string($conn, $_POST['ph2']);
    $uts = mysqli_real_escape_string($conn, $_POST['uts']);
    $uas = mysqli_real_escape_string($conn, $_POST['uas']);

    // Validasi nilai input

    // Query untuk menyimpan atau mengupdate nilai ke database
    if (mysqli_num_rows($result_nilai) > 0) {
        $query_update_nilai = "UPDATE nilai SET ph1='$ph1', ph2='$ph2', uts='$uts', uas='$uas' WHERE nisn='$nisn' AND kode_mapel_guru='$kode_mapel_guru'";
    } else {
        $query_update_nilai = "INSERT INTO nilai (nisn, kode_mapel_guru, ph1, ph2, uts, uas) VALUES ('$nisn', '$kode_mapel_guru', '$ph1', '$ph2', '$uts', '$uas')";
    }
    $result_update_nilai = mysqli_query($conn, $query_update_nilai);

    if ($result_update_nilai) {
        echo "<script>alert('Nilai berhasil disimpan.'); window.location='inputnilai-guru.php?kelas=" . $data_siswa['kode_kelas'] . "';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan nilai.'); window.location='inputnilai-guru.php?kelas=" . $data_siswa['kode_kelas'] . "';</script>";
        exit();
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
