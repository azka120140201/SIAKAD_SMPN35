<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'fkftaskm_skd35';

$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
  //session_destroy();
}
