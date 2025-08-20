<?php
session_start();
include 'koneksi.php';

// 🔎 Validasi ID UMKM
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<script>alert('ID tidak valid'); window.location.href='dataumkm.php';</script>";
  exit;
}

$id = intval($_GET['id']);

// 🔍 Ambil data UMKM dan user pendaftar
$stmt = $conn->prepare("SELECT u.*, us.nama AS nama_user, us.email AS email_user
                        FROM umkm u
                        JOIN user us ON u.user_id = us.id
                        WHERE u.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// ⚠️ Cek apakah data ditemukan
if ($result->num_rows === 0) {
  echo "<script>alert('UMKM tidak ditemukan'); window.location.href='dataumkm.php';</script>";
  exit;
}

$data = $result->fetch_assoc();

// 🔒 Cek apakah user ini pemilik UMKM dan status ditolak
$sessionUserId  = $_SESSION['user_id'] ?? null;
$isPemilikUMKM  = ($sessionUserId && $sessionUserId == $data['user_id']);
$isDitolak      = ($data['status'] === 'ditolak');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail UMKM - <?= htmlspecialchars($data['nama']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Nunito', sans-serif; }
    .card-header {
      background: linear-gradient(to right, #0d6efd, #3e9dfd);
    }
    .table th {
      width: 30%;
      background-color: #f8f9fa;
    }
    .img-thumb {
      border: 3px solid #dee2e6;
      border-radius: 8px;
    }
  </style>
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="card shadow">
    <div class="card-header text-white">
      <h4 class="mb-0 text-uppercase">Detail UMKM</h4>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4 text-center">
          <img src="../uploads/<?= htmlspecialchars($data['foto']); ?>" alt="" class="img-fluid img-thumb mb-3" style="max-width: 250px;">
        </div>
        <div class="col-md-8">
          <table class="table table-hover align-middle">
            <tr><th> Nama UMKM</th><td><?= htmlspecialchars($data['nama']); ?></td></tr>
            <tr><th> Nama Pengusaha</th><td><?= htmlspecialchars($data['nama_pengusaha']); ?></td></tr>
            <tr><th>Nomor HP</th><td><?= htmlspecialchars($data['no_hp']); ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($data['email_user']); ?></td></tr>           
            <tr><th>Alamat</th><td><?= htmlspecialchars($data['alamat']); ?></td></tr>
            <tr><th>Kecamatan</th><td><?= htmlspecialchars($data['kecamatan']); ?></td></tr>
            <tr><th>Sektor</th><td><?= htmlspecialchars($data['sektor']); ?></td></tr>
            <tr><th>Status</th>
              <td><?php
            $status = strtolower($data['status']);
            $warna = ($status === 'aktif') ? 'success' : (($status === 'menunggu') ? 'warning' : 'danger');
            ?>
            <span class="badge bg-<?= $warna ?>">
            <?= ucfirst($status); ?>
            </span>
            </td>
            </tr>
            <tr><th>Koordinat</th><td><?= $data['latitude']; ?>, <?= $data['longitude']; ?></td></tr>
            <tr><th>Pengaju</th><td><?= htmlspecialchars($data['nama_user']); ?>
          </table>

          <div class="mt-4">
            <a href="leaflet.php?lat=<?= $data['latitude']; ?>&lng=<?= $data['longitude']; ?>&nama=<?= urlencode($data['nama']); ?>" class="btn btn-outline-success me-2">Lihat Lokasi</a>
            <a href="dataumkm.php" class="btn btn-secondary">Kembali</a>
            <?php if ($isPemilikUMKM && $isDitolak): ?>
              <a href="editumkm.php?id=<?= $data['id']; ?>" class="btn btn-warning ms-2">Ajukan Ulang</a>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
