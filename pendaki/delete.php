<?php
include '../config/config.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM pendaki WHERE id_pendaki='$id'");
header("Location: index.php");
?>
