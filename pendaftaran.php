<?php
include 'koneksi.php';

$id_pengguna = $_GET['id_pengguna'] ?? null;
if (!$id_pengguna) {
    echo "ID pengguna tidak ditemukan!";
    exit();
}

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['daftar_kursus'])) {
    $kursus = $_POST['kursus'] ?? [];

    if (empty($kursus)) {
        $pesan = "<p class='error'>Harus memilih minimal satu kursus!</p>";
    } else {
        foreach ($kursus as $id_kursus) {
            $query = "UPDATE registrasi SET id_kursus = ?, tanggal_registrasi = NOW() WHERE id_pengguna = ? AND id_kursus IS NULL";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $id_kursus, $id_pengguna);
            mysqli_stmt_execute($stmt);
        }
        $pesan = "<p class='success'>Pendaftaran kursus berhasil!</p>";
    }
}

// Ambil daftar kursus dari database
$result = mysqli_query($conn, "SELECT id_kursus, nama_kursus FROM kursus");
$kursus_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Kursus</title>
    <link rel="stylesheet" type="text/css" href="pendaftaran.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
    <h2>Pendaftaran Kursus</h2>

    <div class="message-container">
        <?php echo $pesan; ?>
    </div>

    <form method="POST">
        <input type="hidden" name="daftar_kursus" value="1">
        
        <label for="kursus">Pilih Kursus:</label>
        <select name="kursus[]" id="kursus" multiple required>
            <?php foreach ($kursus_list as $kursus): ?>
                <option value="<?php echo $kursus['id_kursus']; ?>">
                    <?php echo $kursus['nama_kursus']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="submit-btn">Daftar</button>
    </form>
    
    <div class="button-group">
    <button onclick="window.location.href='daftar_kursus.php'">Lihat Daftar Kursus</button>
    <button onclick="window.location.href='mencari_peserta.php'">Cari Peserta Kursus</button>
    <button onclick="window.location.href='jumlah_pendaftar.php'">Jumlah Pendaftar per Kursus</button>
        </div>
    </div>
</body>
</html>
