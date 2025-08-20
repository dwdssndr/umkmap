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

    // Cek status user dulu
    $cek = $conn->query("SELECT status FROM user WHERE id = $id");
    $data = $cek->fetch_assoc();

    if ($data['status'] === 'nonaktif') {
        // Hapus akun, tapi biarkan data UMKM tetap
        $delete = $conn->query("DELETE FROM user WHERE id = $id");

        if ($delete) {
            header("Location: kelolauser.php?msg=akun_dihapus");
            exit();
        } else {
            echo "Gagal menghapus akun: " . $conn->error;
        }
    } else {
        echo "Akun masih aktif. Nonaktifkan dulu sebelum menghapus.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
