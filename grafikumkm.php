<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
  echo "<script>alert('Silakan login dahulu'); window.location='login.php';</script>";
  exit;
}

$listKecamatan = [
  "Ambunten", "Arjasa", "Batang Batang", "Batuan", "Batuputih", "Bluto", "Dasuk", "Dungkek",
  "Ganding", "Gapura", "Gayam", "Giligenting", "Guluk-Guluk", "Kalianget", "Kangayan",
  "Kota Sumenep", "Lenteng", "Manding", "Masalembu", "Nonggunong", "Pasongsongan",
  "Pragaan", "Raas", "Rubaru", "Sapeken", "Saronggi", "Talango"
];

$dataJumlah = [];

foreach ($kecamatanList as $kc) {
  $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM umkm WHERE kecamatan = ?");
  $stmt->bind_param("s", $kc);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  $dataJumlah[] = (int)($result['total'] ?? 0);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Grafik Jumlah UMKM</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h3 class="text-center text-primary mb-4">📍 Jumlah UMKM Terdaftar per Kecamatan</h3>
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <canvas id="chartKecamatan" height="160"></canvas>
      </div>
    </div>
  </div>

  <script>
    const ctx = document.getElementById('chartKecamatan').getContext('2d');

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
            text: 'Jumlah UMKM Terdaftar per Kecamatan',
            font: { size: 18 }
          },
          tooltip: { enabled: true },
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
  </script>
</body>
</html>
