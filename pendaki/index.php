<?php
include '../config/config.php';
$pendaki = mysqli_query($conn, "SELECT p.*, g.nama AS gunung FROM pendaki p LEFT JOIN gunung g ON p.gunung_id=g.id_gunung");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Pendaki</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<div class="container">
    <h2>Data Pendaki</h2>
    <div>
        <a href="add.php" class="button">Tambah Pendaki</a>
        <a href="../index.php" class="button">Menu Utama</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>Gunung</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($pendaki)){ ?>
            <tr>
                <td><?= $row['id_pendaki'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['umur'] ?></td>
                <td><?= $row['gunung'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_pendaki'] ?>" class="button small">Edit</a>
                    <a href="delete.php?id=<?= $row['id_pendaki'] ?>" class="button delete small" onclick="return confirm('Yakin ingin dihapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
