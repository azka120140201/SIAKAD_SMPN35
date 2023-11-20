<?php
require('db.php');

if (isset($_GET['kode_mapel'])) {
    $kode_mapel = $_GET['kode_mapel'];
    // Query untuk mengambil data guru berdasarkan mata pelajaran
    $query = "SELECT guru.nama, guru.nip FROM guru JOIN mata_pelajaran ON guru.nip = mata_pelajaran.nip WHERE mata_pelajaran.kode_mapel = '$kode_mapel'";
    $result = mysqli_query($conn, $query);

    echo "<table class='table table-striped table-fixed text-center'>";
    echo "<thead style='background-color: #C6D8AF;'>";
    echo "<tr><th>Nama Guru</th><th>NIP</th><th>Action</th></tr></thead>";
    echo "<tbody>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row['nama']."</td><td>".$row['nip']."</td>";
        echo "<td><a href='editguru-admin.php?nip=".$row['nip']."'><button class='btn btn-primary'><iconify-icon icon='bxs:edit'></iconify-icon></button></a></td></tr>";
    }

    echo "</tbody></table>";
}
?>
