<?php
include '../config/config.php';

if (isset($_POST['add'])) {
    // Sanitize and validate input
    $provinsi = mysqli_real_escape_string($conn, $_POST['provinsi']);
    $kabupaten = mysqli_real_escape_string($conn, $_POST['kabupaten']);

    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($conn, "INSERT INTO lokasi(provinsi, kabupaten) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $provinsi, $kabupaten);

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
    <title>Tambah Lokasi</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Lokasi</h2>
        <form method="post">
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input type="text" id="provinsi" name="provinsi" required>
            </div>

            <div class="form-group">
                <label for="kabupaten">Kabupaten</label>
                <input type="text" id="kabupaten" name="kabupaten" required>
            </div>

            <button type="submit" name="add" class="button">Tambah</button>
            <a href="index.php" class="button">Kembali</a>
        </form>
    </div>
</body>
</html>