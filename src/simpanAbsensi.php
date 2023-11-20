<?php
require('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kelas = $_POST['kelas'];
    $pertemuan = $_POST['pertemuan'];

    // Iterasi melalui semua siswa yang diabsen
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'status_') === 0) {
            $nisn = str_replace('status_', '', $key);
            $status = $value;

            // Cek apakah absensi untuk siswa ini sudah ada
            $cek_absensi = "SELECT * FROM absensi WHERE nisn = '$nisn' AND id_jadwal = '$pertemuan'";
            $hasil_cek = mysqli_query($conn, $cek_absensi);

            if (mysqli_num_rows($hasil_cek) > 0) {
                // Update absensi jika sudah ada
                $update_query = "UPDATE absensi SET keterangan = '$status' WHERE nisn = '$nisn' AND id_jadwal = '$pertemuan'";
                mysqli_query($conn, $update_query);
            } else {
                // Insert absensi baru jika belum ada
                $insert_query = "INSERT INTO absensi (id_jadwal, nisn, keterangan) VALUES ('$pertemuan', '$nisn', '$status')";
                mysqli_query($conn, $insert_query);
            }
        }
    }

    // Redirect atau tampilkan pesan setelah selesai
    echo "Absensi berhasil disimpan.";
}
?>
