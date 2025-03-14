<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "Sistem_Manajemen_Kursus_Online");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk menghitung jumlah pendaftar per kursus
$result = $conn->query("
    SELECT k.nama_kursus, COUNT(r.id_pengguna) AS total_pendaftar 
    FROM kursus k 
    LEFT JOIN registrasi r ON k.id_kursus = r.id_kursus 
    GROUP BY k.id_kursus
");

$kursus_list = [];
while ($row = $result->fetch_assoc()) {
    $kursus_list[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jumlah Pendaftar per Kursus</title>
    <link rel="stylesheet" href="jumlah_pendaftar.css">
</head>
<body>

<div class="container">
    <h2>Jumlah Pendaftar per Kursus</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Kursus</th>
                <th>Jumlah Pendaftar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($kursus_list)): ?>
                <?php foreach ($kursus_list as $kursus): ?>
                    <tr>
                        <td><?= htmlspecialchars($kursus['nama_kursus']); ?></td>
                        <td><?= $kursus['total_pendaftar']; ?> pendaftar</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="no-data">Belum ada pendaftar</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>