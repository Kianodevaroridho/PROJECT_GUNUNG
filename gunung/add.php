<?php
include '../config/config.php';

$lokasi = mysqli_query($conn, "SELECT * FROM lokasi");

if (isset($_POST['add'])) {
    // Sanitize and validate input
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $tinggi = (int)$_POST['tinggi'];
    $lokasi_id = (int)$_POST['lokasi_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($conn, "INSERT INTO gunung(nama, tinggi, lokasi_id, status) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "siis", $nama, $tinggi, $lokasi_id, $status);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?status=success");
    } else {
        header("Location: index.php?status=error");
    }
    mysqli_stmt_close($stmt);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gunung</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Gunung</h2>
        <form method="post">
            <div class="form-group">
                <label for="nama">Nama Gunung</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="tinggi">Tinggi (mdpl)</label>
                <input type="number" id="tinggi" name="tinggi" required>
            </div>

            <div class="form-group">
                <label for="lokasi_id">Lokasi</label>
                <select id="lokasi_id" name="lokasi_id" required>
                    <option value="">--Pilih Lokasi--</option>
                    <?php if (mysqli_num_rows($lokasi) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($lokasi)) : ?>
                            <option value="<?= $row['id_lokasi'] ?>"><?= htmlspecialchars($row['provinsi'] . ' - ' . $row['kabupaten']) ?></option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" id="status" name="status" required>
            </div>

            <button type="submit" name="add" class="button">Tambah</button>
            <a href="index.php" class="button">Kembali</a>
        </form>
    </div>
</body>
</html>