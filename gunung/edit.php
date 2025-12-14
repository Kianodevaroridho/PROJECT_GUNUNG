<?php
include '../config/config.php';

// Validate and sanitize ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: index.php?status=invalid_id");
    exit();
}

// Fetch existing data using prepared statements
$stmt = mysqli_prepare($conn, "SELECT * FROM gunung WHERE id_gunung = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$gunungData = mysqli_stmt_get_result($stmt);
$gunung = mysqli_fetch_assoc($gunungData);
mysqli_stmt_close($stmt);

if (!$gunung) {
    header("Location: index.php?status=not_found");
    exit();
}

$lokasi = mysqli_query($conn, "SELECT * FROM lokasi");

if (isset($_POST['update'])) {
    // Sanitize and validate input
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $tinggi = (int)$_POST['tinggi'];
    $lokasi_id = (int)$_POST['lokasi_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Use prepared statements for update
    $stmt = mysqli_prepare($conn, "UPDATE gunung SET nama = ?, tinggi = ?, lokasi_id = ?, status = ? WHERE id_gunung = ?");
    mysqli_stmt_bind_param($stmt, "siisi", $nama, $tinggi, $lokasi_id, $status, $id);

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
    <title>Edit Gunung</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Gunung</h2>
        <form method="post">
            <div class="form-group">
                <label for="nama">Nama Gunung</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($gunung['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label for="tinggi">Tinggi (mdpl)</label>
                <input type="number" id="tinggi" name="tinggi" value="<?= htmlspecialchars($gunung['tinggi']) ?>" required>
            </div>

            <div class="form-group">
                <label for="lokasi_id">Lokasi</label>
                <select id="lokasi_id" name="lokasi_id" required>
                    <?php if (mysqli_num_rows($lokasi) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($lokasi)) : ?>
                            <option value="<?= $row['id_lokasi'] ?>" <?= ($row['id_lokasi'] == $gunung['lokasi_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['provinsi'] . ' - ' . $row['kabupaten']) ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" id="status" name="status" value="<?= htmlspecialchars($gunung['status']) ?>" required>
            </div>

            <button type="submit" name="update" class="button">Update</button>
            <a href="index.php" class="button">Kembali</a>
        </form>
    </div>
</body>
</html>