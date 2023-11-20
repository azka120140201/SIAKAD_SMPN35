<?php
require('db.php');

if (isset($_GET['kode_mapel'])) {
    $kode_mapel = $_GET['kode_mapel'];
    $query = "SELECT * FROM modul WHERE kode_mapel = '$kode_mapel'";
    $result = mysqli_query($conn, $query);
    $modul = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($modul);
}
?>
