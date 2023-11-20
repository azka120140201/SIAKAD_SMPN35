<?php
require('db.php');
session_start(); // Pastikan baris ini ada untuk memulai sesi

if (!isset($_SESSION["siswa"])) {
    // Handle kasus dimana sesi siswa tidak ada atau telah habis
    echo "Sesi tidak ditemukan.";
    exit; // Keluar dari script untuk menghindari eksekusi lebih lanjut
}

$nisn_siswa = $_SESSION["siswa"]["nisn"];

if(isset($_GET['kode_mapel'])) {
    $kode_mapel = $_GET['kode_mapel'];
    $query = "SELECT * FROM absensi WHERE kode_mapel = '$kode_mapel' AND nisn = '$nisn_siswa'";
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row['pertemuan_ke'] . "</td><td>" . $row['keterangan'] . "</td><td>" . $row['tanggal'] . "</td><td>" . $row['waktu_input'] . "</td></tr>";
    }
}
?>
