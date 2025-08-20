<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
$q = $conn->prepare("DELETE FROM umkm WHERE id = ?");
$q->bind_param("i", $id);
$q->execute();
header("Location: dataumkm.php");
?>
