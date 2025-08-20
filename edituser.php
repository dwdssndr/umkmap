<?php
include 'koneksi.php';
session_start();

// Validasi akses hanya untuk admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}

// Validasi ID user
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tidak valid'); window.location='kelolauser.php';</script>";
    exit();
}

$id = intval($_GET['id']); // Amankan ID
$query = "SELECT * FROM user WHERE id = $id";
$result = $conn->query($query);

// Jika user tidak ditemukan
if ($result->num_rows === 0) {
    echo "<script>alert('Data user tidak ditemukan'); window.location='kelolauser.php';</script>";
    exit();
}

$data = $result->fetch_assoc();

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $telepon  = $_POST['telepon'];
    $role     = $_POST['role'];

    // Bandingkan dengan data lama
    if (
        $username === $data['username'] &&
        $nama     === $data['nama'] &&
        $email    === $data['email'] &&
        $telepon  === $data['telepon'] &&
        $role     === $data['role']
    ) {
        echo "<script>alert('Tidak ada perubahan data'); window.location='kelolauser.php';</script>";
        exit();
    }

    // Jika ada perubahan, baru update
    $stmt = $conn->prepare("UPDATE user SET username=?, nama=?, email=?, telepon=?, role=? WHERE id=?");
    $stmt->bind_param("sssssi", $username, $nama, $email, $telepon, $role, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location='kelolauser.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui: " . $stmt->error . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <meta charset="UTF-8">
  <title>Edit Akun Pengguna</title>
 </head>

  <body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
      <div class="card-body">
        <h3 class="mb-4 text-center text-primary"><i class="bi bi-person-lines-fill me-2"></i>Edit Akun Pengguna</h3>
        <form method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="telepon" class="form-label">No. Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="<?= htmlspecialchars($data['telepon']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
              <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
              <option value="user" <?= $data['role'] === 'user' ? 'selected' : '' ?>>User</option>
            </select>
          </div>

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="bi bi-save me-2"></i> Simpan Perubahan
            </button>
          </div>
        </form>
        <a href="kelolauser.php" class="btn btn-sm btn-secondary mt-3">Kembali</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
