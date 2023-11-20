<?php
require('db.php'); // Pastikan jalur ke file db.php benar

if (isset($_GET['kode_kelas'])) {
    $kode_kelas = $_GET['kode_kelas'];
    $query = "SELECT * FROM siswa WHERE kode_kelas = '$kode_kelas'";
    $result = mysqli_query($conn, $query);

    echo "<table class='table table-striped table-fixed text-center'>";
    echo "<thead style='background-color: #C6D8AF;'>";
    echo "<tr><th>Nama Siswa</th><th>NISN</th><th>Action</th></tr></thead>";
    echo "<tbody>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row['nama']."</td><td>".$row['nisn']."</td>";
        echo "<td><a href='editnilai-admin.php?nisn=".$row['nisn']."'><button class='btn btn-primary'><iconify-icon icon='bxs:edit'></iconify-icon></button></a></td></tr>";
    }

    echo "</tbody></table>";
}
?>