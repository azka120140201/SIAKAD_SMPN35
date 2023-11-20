<?php
require('db.php');

$kode_kelas = $_GET['kelas'];
$pertemuan_ke = $_GET['pertemuan'];

// Query untuk mendapatkan data siswa berdasarkan kelas
$query_siswa = "SELECT * FROM siswa WHERE kode_kelas = '$kode_kelas' AND status_siswa='Aktif'";
$hasil_siswa = mysqli_query($conn, $query_siswa);

echo "<form method='POST' action='simpanAbsensi.php'>";
echo "<table class='table'>";
echo "<thead><tr><th>Nama Siswa</th><th>Status</th></tr></thead>";
echo "<tbody>";

while($siswa = mysqli_fetch_assoc($hasil_siswa)) {
    echo "<tr>";
    echo "<td>".$siswa['nama']."</td>";
    echo "<td>";
    echo "<select name='status_".$siswa['nisn']."'>";
    echo "<option value='Hadir'>Hadir</option>";
    echo "<option value='Izin'>Izin</option>";
    echo "<option value='Sakit'>Sakit</option>";
    echo "<option value='Alpa'>Alpa</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
}

echo "</tbody></table>";
echo "<input type='hidden' name='kelas' value='".$kode_kelas."'>";
echo "<input type='hidden' name='pertemuan' value='".$pertemuan_ke."'>";
echo "<input type='submit' value='Simpan'>";
echo "</form>";
?>
