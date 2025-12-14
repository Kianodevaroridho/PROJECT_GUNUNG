<?php
include '../config/config.php';
$gunung = mysqli_query($conn, "SELECT * FROM gunung");

if(isset($_POST['add'])){
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $gunung_id = $_POST['gunung_id'];
    $tanggal = $_POST['tanggal'];
    mysqli_query($conn, "INSERT INTO pendaki(nama,umur,gunung_id,tanggal) VALUES('$nama','$umur','$gunung_id','$tanggal')");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Pendaki</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<div class="container">
    <h2>Tambah Pendaki</h2>
    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" required>

        <label>Umur</label>
        <input type="number" name="umur" required>

        <label>Gunung</label>
        <select name="gunung_id" required>
            <option value="">--Pilih Gunung--</option>
            <?php while($row = mysqli_fetch_assoc($gunung)){ ?>
                <option value="<?= $row['id_gunung'] ?>"><?= $row['nama'] ?></option>
            <?php } ?>
        </select>

        <label>Tanggal Naik</label>
        <input type="date" name="tanggal" required>

        <button type="submit" name="add" class="button">Tambah</button>
    </form>
    <a href="index.php" class="button">Kembali</a>
</div>
</body>
</html>
