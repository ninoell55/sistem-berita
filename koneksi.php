<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbnm = "data_berita";

// Membuat koneksi dengan MySQLi
$conn = mysqli_connect($host, $user, $pass, $dbnm);

// Cek koneksi
if (!$conn) {   
    die("Koneksi ke server MySQL gagal: " . mysqli_connect_error());
}

echo "";
?>