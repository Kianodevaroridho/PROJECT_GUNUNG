<?php
include '../config/config.php';

// Validate and sanitize ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: index.php?status=invalid_id");
    exit();
}

// Fetch existing data using prepared statements
$stmt = mysqli_prepare($conn, "SELECT * FROM lokasi WHERE id_lokasi = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    header("Location: index.php?status=not_found");
    exit();
}

if (isset($_POST['update'])) {
    // Sanitize and validate input
    $provinsi = mysqli_real_escape_string($conn, $_POST['provinsi']);
    $kabupaten = mysqli_real_escape_string($conn, $_POST['kabupaten']);

    // Use prepared statements for update
    $stmt = mysqli_prepare($conn, "UPDATE lokasi SET provinsi = ?, kabupaten = ? WHERE id_lokasi = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $provinsi, $kabupaten, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?status=update_success");
    } else {
        header("Location: index.php?status=update_error");
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
    <title>Edit Lokasi</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Lokasi</h2>
        <form method="post">
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input type="text" id="provinsi" name="provinsi" value="<?= htmlspecialchars($row['provinsi']) ?>" required>
            </div>

            <div class="form-group">
                <label for="kabupaten">Kabupaten</label>
                <input type="text" id="kabupaten" name="kabupaten" value="<?= htmlspecialchars($row['kabupaten']) ?>" required>
            </div>

            <button type="submit" name="update" class="button">Update</button>
            <a href="index.php" class="button">Kembali</a>
        </form>
    </div>
</body>
</html>