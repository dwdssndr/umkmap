<?php
include 'koneksi.php';
session_start();

// Validasi role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $update = $conn->query("UPDATE user SET status = 'aktif' WHERE id = $id");

    if ($update) {
        header("Location: kelolauser.php?msg=akun_diaktifkan");
        exit();
    } else {
        echo "Gagal mengaktifkan akun: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
