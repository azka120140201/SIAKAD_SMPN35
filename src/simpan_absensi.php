<?php
session_start();
require('db.php');

if (isset($_POST['status_kehadiran'])) {
    $kelas = $_POST['kelas'];
    $pertemuan = $_POST['pertemuan'];

    foreach ($_POST['status_kehadiran'] as $nisn => $status) {
        // Simpan ke database
        $query_simpan = "INSERT INTO absensi (id_jadwal, pertemuan_ke, kode_mapel, nisn, keterangan, tanggal, waktu_input) VALUES (/* Sesuaikan dengan struktur data Anda */, '$pertemuan', '/* kode_mapel */', '$nisn', '$status', CURDATE(), NOW())";
        mysqli_query($conn, $query_simpan);
    }
    echo "Absensi berhasil disimpan";
    // Redirect ke halaman sebelumnya atau tampilkan pesan sukses
}
?>
