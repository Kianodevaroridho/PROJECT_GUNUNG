<?php
include '../config/config.php';
$id = $_GET['id'];
$dataPendaki = mysqli_query($conn, "SELECT * FROM pendaki WHERE id_pendaki='$id'");
$pendaki = mysqli_fetch_assoc($dataPendaki);
$gunung = mysqli_query($conn, "SELECT * FROM gunung");

if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $gunung_id = $_POST['gunung_id'];
    $tanggal = $_POST['tanggal'];
    mysqli_query($conn, "UPDATE pendaki SET nama='$nama', umur='$umur', gunung_id='$gunung_id', tanggal='$tanggal' WHERE id_pendaki='$id'");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Pendaki</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<div class="container">
    <h2>Edit Pendaki</h2>
    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $pendaki['nama'] ?>" required>

        <label>Umur</label>
        <input type="number" name="umur" value="<?= $pendaki['umur'] ?>" required>

        <label>Gunung</label>
        <select name="gunung_id" required>
            <?php while($row = mysqli_fetch_assoc($gunung)){ ?>
                <option value="<?= $row['id_gunung'] ?>" <?= $row['id_gunung']==$pendaki['gunung_id']?'selected':'' ?>>
                    <?= $row['nama'] ?>
                </option>
            <?php } ?>
        </select>

        <label>Tanggal Naik</label>
        <input type="date" name="tanggal" value="<?= $pendaki['tanggal'] ?>" required>

        <button type="submit" name="update" class="button">Update</button>
    </form>
    <a href="index.php" class="button">Kembali</a>
</div>
</body>
</html>
