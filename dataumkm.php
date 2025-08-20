<?php
session_start();
include 'koneksi.php';

// 🔑 Deteksi login dan role
$user_id = $_SESSION['user_id'] ?? null;
$role    = $_SESSION['role'] ?? 'publik';

$isAdmin   = ($role === 'admin');
$isPemilik = ($role === 'user' && $user_id);

if ($isAdmin) {
  $query = "SELECT * FROM umkm ORDER BY FIELD(status, 'menunggu', 'ditolak', 'aktif'), nama ASC";
} elseif ($isPemilik) {
  $query = "SELECT * FROM umkm WHERE user_id = $user_id OR status = 'aktif' ORDER BY FIELD(status, 'menunggu', 'aktif', 'ditolak'), nama ASC";
} else {
  $query = "SELECT * FROM umkm WHERE status = 'aktif' ORDER BY nama ASC";
}

$result = $conn->query($query);
if (!$result) {
  echo "<div class='alert alert-danger text-center mt-3'>Query gagal: " . $conn->error . "</div>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data UMKM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4">Data UMKM</h2>

    <style>
      /* Tabel UMKM */
#tabel-umkm {
  width: 100%;
  border-collapse: collapse;
  font-family: 'inter', sans-serif;
}

#tabel-umkm th, #tabel-umkm td {
  padding: 12px 16px;
  font-size: 15.5px;
  text-align: left;
  vertical-align: middle;
  border-bottom: 1px solid #eee;
}

#tabel-umkm th {
  background-color: #f9fafb;
  color: #333;
  font-weight: 600;
}

/* Badge Status */
.badge {
  display: inline-block;
  padding: 6px 12px;
  font-size: 14px;
  font-weight: 500;
  border-radius: 14px;
  text-transform: capitalize;
  box-shadow: 0 0 0 1px #ccc inset;
}

/* Warna status */
.badge.aktif {
  background-color: #e7f6e7;
  color: #2e7d32;
}

.badge.ditolak {
  background-color: #ffe5e5;
  color: #c62828;
}

.badge.pending {
  background-color: #fffbe6;
  color: #f9a825;
}

    </style>
<?php
  if (!isset($_SESSION['role'])) {
    // Belum login (pengunjung publik)
    $tambahLink = "login.php";
  } else if ($_SESSION['role'] == 'user') {
    // User biasa, diarahkan ke daftar terlebih dulu
    $tambahLink = "daftarumkm.php";
  } else if ($_SESSION['role'] == 'admin') {
    // Admin langsung ke form tambah
    $tambahLink = "tambahumkm.php";
  }
?>
    <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive shadow-sm rounded">
      <table id="tabel-umkm" class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-primary text-center fw-semibold text-uppercase">
          <tr>
            <th>Foto</th>
            <th>Nama UMKM</th>
            <th>Kecamatan</th>
            <th>Sektor</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <?php
            $status = strtolower(trim($row['status'] ?? ''));
            $statusList = ['aktif', 'menunggu', 'ditolak'];
            $statusDisplay = in_array($status, $statusList) ? ucfirst($status) : 'Tidak Diketahui';
            $badgeClass = match ($status) {
              'aktif' => 'success',
              'menunggu' => 'warning text-dark',
              'ditolak' => 'danger',
              default => 'secondary'
            };
            $isUMKMPemilik = ($role === 'user' && $row['user_id'] == $user_id);
            $isEditAllowed = $isAdmin || $isUMKMPemilik || $statusDisplay === 'Tidak Diketahui';
          ?>

          <tr>
            <td class="text-center">
              <img src="../uploads/<?= htmlspecialchars($row['foto'] ?? 'default.jpg'); ?>" width="60" height="60" class="rounded-circle border shadow-sm" alt="">
            </td>
            <td><?= htmlspecialchars($row['nama'] ?? '-'); ?></td>
            <td><?= htmlspecialchars($row['kecamatan'] ?? '-'); ?></td>
            <td><?= htmlspecialchars($row['sektor'] ?? '-'); ?></td>
            <td class="text-center">
              <span class="badge bg-<?= $badgeClass; ?>"><?= $statusDisplay; ?></span>
              <?php if ($row['user_id'] == $user_id && $status === 'menunggu'): ?>
                <div class="small text-muted mt-1 fst-italic">Menunggu Validasi Admin</div>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <!-- Tombol Detail & Lokasi untuk semua -->
              <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info me-1">Detail</a>
              <a href="leaflet.php?lat=<?= $row['latitude']; ?>&lng=<?= $row['longitude']; ?>&nama=<?= urlencode($row['nama']); ?>" class="btn btn-sm btn-outline-success mt-1">Lokasi</a>

              <!-- Tombol Validasi hanya untuk Admin dan status menunggu -->
              <?php if ($isAdmin && $status === 'menunggu'): ?>
                <a href="prosesvalidasi.php?id=<?= $row['id']; ?>&aksi=aktif" class="btn btn-sm btn-outline-success me-1">Validasi</a>
                <a href="prosesvalidasi.php?id=<?= $row['id']; ?>&aksi=tolak" class="btn btn-sm btn-outline-danger">Tolak</a>
              <?php endif; ?>

              <!-- Tombol Edit & Hapus jika diizinkan -->
              <?php if ($isEditAllowed): ?>
                <a href="editumkm.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                <a href="hapusumkm.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin mau hapus data UMKM ini?')">Hapus</a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <a href="../index.php" class="btn btn-sm btn-secondary mt-3">Kembali</a>
<a href="<?= $tambahLink ?>" class="btn btn-primary fw-semibold mt-3">Tambah UMKM</a>
    <?php else: ?>
    <div class="alert alert-warning text-center mt-4">Tidak ada data UMKM yang ditemukan.</div>
    <?php endif; ?>
  </div>

  <script>
    $(document).ready(function () {
      $('#tabel-umkm').DataTable({
        language: {
          url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
      });
    });
  </script>
</body>
</html>
