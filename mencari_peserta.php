<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "Sistem_Manajemen_Kursus_Online");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil daftar kursus untuk dropdown
$kursus_query = $conn->query("SELECT id_kursus, nama_kursus FROM kursus");
$kursus_list = [];
while ($row = $kursus_query->fetch_assoc()) {
    $kursus_list[] = $row;
}

// Ambil ID kursus dari parameter GET atau default ke kursus pertama
$kursus_id = $_GET['id_kursus'] ?? ($kursus_list[0]['id_kursus'] ?? 1);

// Ambil data peserta berdasarkan kursus yang dipilih
$result = $conn->query("SELECT p.nama_lengkap, p.email, k.nama_kursus 
                        FROM pengguna p 
                        JOIN registrasi r ON p.id_pengguna = r.id_pengguna 
                        JOIN kursus k ON r.id_kursus = k.id_kursus 
                        WHERE k.id_kursus = '$kursus_id'");

$peserta = [];
while ($row = $result->fetch_assoc()) {
    $peserta[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peserta Kursus</title>
    <link rel="stylesheet" href="mencari_peserta.css">
</head>
<body>

<div class="container">
    <h2>Daftar Peserta Kursus</h2>

    <form method="GET">
        <label for="id_kursus">Pilih Kursus:</label>
        <select name="id_kursus" id="id_kursus" onchange="this.form.submit()">
            <?php foreach ($kursus_list as $kursus): ?>
                <option value="<?= $kursus['id_kursus']; ?>" <?= ($kursus_id == $kursus['id_kursus']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($kursus['nama_kursus']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Kursus</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($peserta)): ?>
                <?php foreach ($peserta as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['nama_lengkap']); ?></td>
                        <td><?= htmlspecialchars($p['email']); ?></td>
                        <td><?= htmlspecialchars($p['nama_kursus']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="no-data">Tidak ada peserta terdaftar</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>