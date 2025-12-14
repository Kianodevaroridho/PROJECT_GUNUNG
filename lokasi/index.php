<?php
include '../config/config.php';
$lokasi = mysqli_query($conn, "SELECT * FROM lokasi");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lokasi</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="container">
        <h2>Data Lokasi</h2>
        <div class="menu">
            <a href="add.php" class="button">Tambah Lokasi</a>
            <a href="../index.php" class="button">Menu Utama</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($lokasi) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($lokasi)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_lokasi']) ?></td>
                            <td><?= htmlspecialchars($row['provinsi']) ?></td>
                            <td><?= htmlspecialchars($row['kabupaten']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id_lokasi'] ?>" class="button edit">Edit</a>
                                <a href="delete.php?id=<?= $row['id_lokasi'] ?>" class="button delete" onclick="return confirm('Yakin ingin dihapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Tidak ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>