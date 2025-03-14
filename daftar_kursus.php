<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "Sistem_Manajemen_Kursus_Online");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data kursus dan instruktur
$result = $conn->query("SELECT k.nama_kursus, i.nama_instruktur FROM kursus k JOIN instruktur i ON k.id_instruktur = i.id_instruktur");

// Simpan data dalam array
$kursus = [];
while ($row = $result->fetch_assoc()) {
    $kursus[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kursus</title>
    <link rel="stylesheet" href="daftar_kursus.css"> <!-- Memanggil file CSS -->
</head>
<body>

<div class="container">
    <h2>Daftar Kursus</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Kursus</th>
                <th>Instruktur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kursus as $k): ?>
                <tr>
                    <td><?= htmlspecialchars($k['nama_kursus']); ?></td>
                    <td><?= htmlspecialchars($k['nama_instruktur']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>