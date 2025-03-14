<?php
$host = "localhost"; // atau sesuaikan dengan server database kamu
$user = "root"; // default untuk XAMPP biasanya 'root'
$password = ""; // kosongkan jika tidak ada password
$database = "sistem_manajemen_kursus_online"; // sesuaikan dengan nama database kamu

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>