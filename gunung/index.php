<?php
include '../config/config.php';
$gunung = mysqli_query($conn, "SELECT g.*, l.provinsi, l.kabupaten FROM gunung g LEFT JOIN lokasi l ON g.lokasi_id = l.id_lokasi");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Gunung</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="container">
        <h2>Data Gunung</h2>
        <div class="menu">
            <a href="add.php" class="button">Tambah Gunung</a>
            <a href="../index.php" class="button">Menu Utama</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tinggi</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($gunung) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($gunung)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_gunung']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['tinggi']) ?> mdpl</td>
                            <td><?= htmlspecialchars($row['provinsi'] . ' - ' . $row['kabupaten']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id_gunung'] ?>" class="button edit small">Edit</a>
                                <a href="delete.php?id=<?= $row['id_gunung'] ?>" class="button delete small" onclick="return confirm('Yakin ingin dihapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">Tidak ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>