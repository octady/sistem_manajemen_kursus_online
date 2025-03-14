<?php
include 'koneksi.php';?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

<?php
// Form Input Data Pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_pengguna'])) {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    if (empty($nama) || empty($email) || empty($_POST['password'])) {
        echo "Semua field harus diisi!";
    } else {
        // Simpan data ke tabel pengguna
        $query = "INSERT INTO pengguna (nama_lengkap, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $password);
        mysqli_stmt_execute($stmt);
        $id_pengguna = mysqli_insert_id($conn);

        // Simpan id_pengguna ke tabel registrasi (tanpa kursus dan tanggal dulu)
        $query = "INSERT INTO registrasi (id_pengguna, id_kursus, tanggal_registrasi) VALUES (?, NULL, NULL)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_pengguna);
        mysqli_stmt_execute($stmt);

        echo "Registrasi berhasil! Silakan pilih kursus.";
        header("Location: pendaftaran.php?id_pengguna=$id_pengguna");
        exit();
    }
}
?>

<form method="POST">
    <input type="hidden" name="tambah_pengguna" value="1">
    Nama: <input type="text" name="nama" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>