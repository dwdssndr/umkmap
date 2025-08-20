<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  echo "unauthorized";
  exit;
}

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $user_id = $_SESSION['user_id'];

  // Validasi bahwa notifikasi milik user
  $stmt = $conn->prepare("DELETE FROM notifikasi WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $id, $user_id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "success";
  } else {
    echo "failed";
  }
} else {
  echo "invalid";
}
?>
