<?php
session_start();
include 'WEBGIS/koneksi.php';

// 🔐 Cek login dan role
$isLogin = isset($_SESSION['username']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$role = $_SESSION['role'] ?? 'guest';
$user_id = $_SESSION['user_id'] ?? null;

// 📊 Data sektor untuk chart (hanya UMKM aktif)
$qSektor = "SELECT sektor, COUNT(*) AS total FROM umkm WHERE status = 'aktif' GROUP BY sektor";
$resSektor = $conn->query($qSektor);

$labels = [];
$values = [];
while ($row = $resSektor->fetch_assoc()) {
  $labels[] = $row['sektor'];
  $values[] = $row['total'];
}

// 🧠 Inisialisasi jumlah per sektor
$jumlahJasa = 0;
$jumlahPengolahan = 0;
$jumlahPerdagangan = 0;
$jumlahPertanian = 0;
$jumlahKerajinan = 0;
$jumlahPerikanan = 0;
$jumlahPeternakan = 0;

foreach ($labels as $i => $sektor) {
  switch (strtolower($sektor)) {
    case 'jasa':
      $jumlahJasa = $values[$i]; break;
    case 'pengolahan':
      $jumlahPengolahan = $values[$i]; break;
    case 'perdagangan':
      $jumlahPerdagangan = $values[$i]; break;
    case 'pertanian':
      $jumlahPertanian = $values[$i]; break;
    case 'kerajinan':
      $jumlahKerajinan = $values[$i]; break;
    case 'perikanan':
      $jumlahPerikanan = $values[$i]; break;
    case 'peternakan':
      $jumlahPeternakan = $values[$i]; break;
  }
}

// 📍 Daftar kecamatan
$kecamatanList = [
  "Ambunten", "Arjasa", "Batang Batang", "Batuan", "Batuputih", "Bluto", "Dasuk", "Dungkek",
  "Ganding", "Gapura", "Gayam", "Giligenting", "Guluk-Guluk", "Kalianget", "Kangayan",
  "Kota Sumenep", "Lenteng", "Manding", "Masalembu", "Nonggunong", "Pasongsongan",
  "Pragaan", "Raas", "Rubaru", "Sapeken", "Saronggi", "Talango"
];

// 📊 Statistik per kecamatan (hanya UMKM aktif)
$dataJumlah = [];
foreach ($kecamatanList as $kc) {
  $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM umkm WHERE kecamatan = ? AND status = 'aktif'");
  $stmt->bind_param("s", $kc);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  $dataJumlah[] = (int)($result['total'] ?? 0);
  $stmt->close();
}

// 🔔 Jumlah notifikasi belum dibaca
$jumlahNotif = 0;
if ($user_id) {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM notifikasi WHERE user_id = ? AND status = 'belum dibaca'");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result($jumlahNotif);
  $stmt->fetch();
  $stmt->close();
}
// 👁️ Data untuk publik → hanya UMKM aktif
$qPublik = "SELECT * FROM umkm WHERE status = 'aktif' ORDER BY nama ASC";
$resPublik = $conn->query($qPublik);

// 🧑‍💼 Admin login → tampilkan semua UMKM dan status-nya
if ($isAdmin) {
  $queryUMKM = "SELECT umkm.*, user.username FROM umkm 
                JOIN user ON umkm.user_id = user.id 
                ORDER BY status DESC, nama ASC";
  $resultUMKM = $conn->query($queryUMKM);

  $qMenunggu = "SELECT * FROM umkm WHERE status = 'menunggu'";
  $resMenunggu = $conn->query($qMenunggu);

  $qAktif = "SELECT * FROM umkm WHERE status = 'aktif' ORDER BY nama ASC";
  $resAktif = $conn->query($qAktif);
}

// 🙋 User login biasa → tampilkan UMKM miliknya yang sudah divalidasi
if ($isLogin && !$isAdmin) {
  $username = $_SESSION['username'];

  // Ambil user_id
  $stmtUser = $conn->prepare("SELECT id FROM user WHERE username = ?");
  $stmtUser->bind_param("s", $username);
  $stmtUser->execute();
  $resUser = $stmtUser->get_result();

  if ($resUser->num_rows > 0) {
    $user = $resUser->fetch_assoc();
    $user_id = $user['id'];

    // Ambil UMKM milik user sendiri, apapun status-nya
    $qUserUMKM = "SELECT * FROM umkm WHERE user_id = ? ORDER BY FIELD(status, 'menunggu', 'aktif')";
    $stmtUMKM = $conn->prepare($qUserUMKM);
    $stmtUMKM->bind_param("i", $user_id);
    $stmtUMKM->execute();
    $resUserUMKM = $stmtUMKM->get_result();
  }
}
$user_id = null;
if ($isLogin && !$isAdmin) {
  $stmt = $conn->prepare("SELECT id FROM user WHERE username = ?");
  $stmt->bind_param("s", $_SESSION['username']);
  $stmt->execute();
  $resUser = $stmt->get_result();
  if ($resUser->num_rows > 0) {
    $user_id = $resUser->fetch_assoc()['id'];
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Sistem Informasi Geografis Pemetaan UMKM Kabupaten Sumenep</title>

   <!-- STYLES -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/unicons.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.theme.default.min.css">
<link rel="stylesheet" href="css/tooplate-style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha512-o8I/z+8V4xNV4J5x0vuMf5qzSGf2KgwSBD2D3qz4L9jGKl2qJXrkH3uRtx7FtErfXH5sXyArU+4TKzK+0U1Gcg==" crossorigin=""/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

<!-- SCRIPTS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha512-CmrD8ujZzB1Lcdlv35AKRMxzZy2UyGpThn6raJzZoqj2A3WPRC38r6BBQmhHaV3mLsD8cZbF9yyR3c1PXClB0A==" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <body>
 
    <!-- MENU -->
    <nav class="navbar navbar-expand-sm navbar-light">
        <a class="navbar-brand" href="index.php">
  <img src="images/logosmp.jpeg" alt="Logo Sumenep" class="logo-sumenep">
  <span class="text-umkmap">UMKMap</span>
</a>
   <style>
  .navbar-brand {
  display: flex;
  align-items: center;
  font-family: 'Poppins', sans-serif;
  font-weight: bold;
  font-size: 2.5rem;
  color: #203A43;
  text-decoration: none;
}

.logo-sumenep {
  height: 50px;
  margin-right: 10px;
}
.text-umkmap {
  display: inline-block;
}
 .btn-outline-primary {
  color: #2c7be5;
  border: 2px solid #2c7be5;
  padding: 10px 24px;
  font-size: 15px;
  font-weight: 600;
  border-radius: 999px; /* bentuk kapsul */
  background-color: transparent;
  transition: 0.3s ease;
}

.btn-outline-primary:hover {
  background-color: #2c7be5;
  color: white;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
.nav-link {
  font-weight: bold;
  font-size: 20px !important;;
  overflow: hidden;
}
</style>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>

             <!-- NAVBAR -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a href="#home" class="nav-link"><span data-hover="Home">Home</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#peta" class="nav-link"><span data-hover="Peta">Peta</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="WEBGIS/dataumkm.php" class="nav-link"><span data-hover="Data UMKM">Data UMKM</span></a>
                    </li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                    <li class="nav-item">
                        <a href="WEBGIS/daftarumkm.php" class="nav-link"><span data-hover="Daftar UMKM">Daftar UMKM</span></a>
                    <?php endif; ?>
                    </li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
  <li class="nav-item">
    <a href="WEBGIS/kelolauser.php" class="nav-link"><span data-hover="Kelola Akun">Kelola Akun</span></a>
  </li>
<?php endif; ?>
                </ul>
                <?php if (isset($_SESSION['user_id'])): ?>
  <a href="WEBGIS/notifikasi.php" class="btn position-relative me-3">
    <i class="bi bi-bell fs-5 text-dark"></i>
    <?php if ($jumlahNotif > 0): ?>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        <?= $jumlahNotif ?>
      </span>
    <?php endif; ?>
  </a>
<?php endif; ?>

<div class="d-flex justify-content-end align-items-center px-4 py-3">
  <?php if (isset($_SESSION['username'])): ?>
    <div class="dropdown">
      <button class="btn bg-transparent border-0 d-flex align-items-center gap-2 dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">        
        <img src="images/user.png" alt="User" width="32" height="32" class="rounded-circle border">
        <span class="fw-semibold text-dark">Hi, <?= htmlspecialchars($_SESSION['nama']); ?></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="WEBGIS/ubahpassword.php"><i class="bi bi-person-circle me-2"></i> Ubah Password</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="WEBGIS/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
      </ul>
    </div>
  <?php else: ?>
    <a href="WEBGIS/login.php" class="btn btn-outline-primary fw-semibold">Login</a>
  <?php endif; ?>
</div>
                <ul class="navbar-nav ml-lg-auto">
                    <div class="ml-lg-4">
                      <div class="color-mode d-lg-flex justify-content-center align-items-center">
                        <i class="color-mode-icon"></i>
                        Color mode
                      </div>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
<!-- HOME -->
<section class="home d-flex align-items-center justify-content-center" id="home"
  style="min-height: 100vh;">
      <div class="col-lg-10">
<h4 class="text-muted mb-2" style="letter-spacing: 2px;">SELAMAT DATANG</h4>

          <h1 class="animated animated-text mb-3" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #2c3e50;">
            Sistem Informasi Geografis UMKM <br>
            <span class="text-primary">Kabupaten Sumenep</span>
            <div class="animated-info mt-2">
              <span class="animated-item">Perdagangan</span>
              <span class="animated-item">Pengolahan</span>
              <span class="animated-item">Jasa</span>
           </div>
          </h1>
          <p class="lead text-secondary mt-3 mb-4">
            Jelajahi potensi Usaha Mikro, Kecil, dan Menengah di Kabupaten Sumenep melalui sistem peta interaktif. Sistem ini menyajikan data lokasi, jenis usaha, serta profil UMKM secara akurat dan terintegrasi dalam satu tampilan geografis.
             UMKMap dirancang untuk mendukung pengambilan keputusan, mendorong pertumbuhan ekonomi lokal, dan memperluas akses informasi bagi masyarakat serta pemangku kepentingan.</p>
<div class="custom-btn-group mt-4">
  <a href="#statistik" class="btn custom-btn custom-btn-bg custom-btn-link">Explore</a>
</div>
      </div>
  </div>
</section>
<!-- STATISTIK UMKM -->
<section id="statistik" class="py-5 bg-body">
            <center><h2 class="mb-4">Statistik UMKM </h2></center>
    <div class="row">
      <!-- Kolom Kiri: Sektor -->
      <div class="col-lg-6 mb-4">
        <div class="bg-body-tertiary p-4 rounded-4">
          <h5 class="text-center mb-3">Sektor</h5>
          <canvas id="chartSektor" height="180"></canvas>
        </div>
      </div>
      <!-- Kolom Kanan: Kecamatan -->
      <div class="col-lg-6 mb-4">
        <div class="bg-body-tertiary p-4 rounded-4">
          <h5 class="text-center mb-3">Kecamatan</h5>
          <canvas id="chartKecamatan" height="180"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- PETA -->
    <section class="peta py-5 d-lg-flex justify-content-center align-items-center" id="peta">
        <div class="container">
            <center><h2 class="mb-4">Peta Persebaran UMKM </h2></center>
            <iframe src="WEBGIS\leaflet.php" width="100%" height="500"></iframe>     
        </div>
    </section>
  </div>
</section>

                        
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- FOOTER -->
     <footer class="footer py-5">
          <div class="container">
               <div class="row">
                    <div class="col-lg-12 col-12">                                
                        <p class="copyright-text text-center">Copyright &copy; 2025 Diskoperindag Sumenep</p>
                    </div>
                    
               </div>
          </div>
     </footer>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Headroom.js"></script>
    <script src="js/jQuery.headroom.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    // Inisialisasi peta
    var map = L.map('map').setView([-7.015, 113.864], 10); // Koordinat Kabupaten Sumenep

    // Tambahkan tile dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Tambahkan marker di pusat Sumenep
   L.marker([-7.015, 113.864], {
  icon: L.divIcon({
    html: `
      <div style="background-color: #6610f2; border-radius: 8px; padding: 4px;">
        <i class="fas fa-star" style="color:white; font-size:20px;"></i>
      </div>
    `,
    iconSize: [24, 36],
    iconAnchor: [12, 36],
    popupAnchor: [0, -36]
  })
}).addTo(map).bindPopup("Pusat Kabupaten Sumenep");
  </script>
 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const ctx = document.getElementById('chartKecamatan')?.getContext('2d');
  if (!ctx) return;

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($kecamatanList) ?>,
      datasets: [{
        label: 'Jumlah UMKM',
        data: <?= json_encode($dataJumlah) ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderRadius: 6
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Jumlah UMKM per Kecamatan',
          font: { size: 18 }
        },
        legend: { display: false }
      },
      scales: {
        x: {
          beginAtZero: true,
          ticks: { precision: 0 }
        }
      }
    }
  });
});
</script>

<pre>
<?= $jumlahJasa ?> -
<?= $jumlahPengolahan ?> -
<?= $jumlahPerdagangan ?> -
<?= $jumlahPertanian ?> -
<?= $jumlahKerajinan ?> -
<?= $jumlahPerikanan ?> -
<?= $jumlahPeternakan ?>
</pre>
<script>
const ctxSektor = document.getElementById('chartSektor')?.getContext('2d');
if (ctxSektor) {
  new Chart(ctxSektor, {
    type: 'bar',
    data: {
      labels: ['Jasa', 'Pengolahan', 'Perdagangan', 'Pertanian', 'Kerajinan', 'Perikanan', 'Peternakan'],
      datasets: [{
        label: 'Jumlah UMKM',
        data: [
          <?= $jumlahJasa ?? 0 ?>,
          <?= $jumlahPengolahan ?? 0 ?>,
          <?= $jumlahPerdagangan ?? 0 ?>,
          <?= $jumlahPertanian ?? 0 ?>,
          <?= $jumlahKerajinan ?? 0 ?>,
          <?= $jumlahPerikanan ?? 0 ?>,
          <?= $jumlahPeternakan ?? 0 ?>
        ],
        backgroundColor: [
          '#2E86C1', '#28B463', '#F39C12',
          '#E74C3C', '#8E44AD', '#1ABC9C', '#D35400'
        ],
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Distribusi UMKM Berdasarkan Sektor',
          font: { size: 18 }
        },
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString()} UMKM`
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { precision: 0 }
        }
      }
    }
  });
}
</script>
</body>
</html>