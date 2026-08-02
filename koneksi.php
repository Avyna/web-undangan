<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_undangan";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!koneksi){
    die("Koneksi databsae gagal: ".mysqli_connect_error());
}
?>