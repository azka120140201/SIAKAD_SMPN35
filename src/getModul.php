<?php
require('db.php');
$kode_mapel = $_GET['kode_mapel'];

$folder_modul = "modul/"; // Path ke folder modul

$query_modul = "SELECT nama_file, file_upload, tanggal_upload FROM modul WHERE kode_mapel = '$kode_mapel'";
$hasil_modul = mysqli_query($conn, $query_modul);

$modul_data = array();

while ($modul = mysqli_fetch_assoc($hasil_modul)) {
    $path_modul = $folder_modul . $modul['file_upload']; // Menggabungkan folder dengan nama file
    $formatted_date_time = date("Y-m-d H:i:s", strtotime($modul['tanggal_upload']));
    
    $modul_item = array(
        "nama_modul" => $modul['nama_file'],
        "file_url" => $path_modul,
        "tanggal_upload" => $formatted_date_time
    );
    
    array_push($modul_data, $modul_item);
}

echo json_encode($modul_data);
?>
