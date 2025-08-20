<?php
include 'koneksi.php';

// Validasi ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  echo "<script>alert('Tidak ada data yang diubah.'); window.location='../index.php';</script>";
  exit;
}

// Ambil data dengan prepared statement
$stmt = $conn->prepare("SELECT * FROM umkm WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Jika data tidak ditemukan
if (!$row) {
  echo "<script>alert('Data tidak ditemukan.'); window.location='../index.php';</script>";
  exit;
}

// Konversi sektor ke array
$selectedSektor = explode(',', $row['sektor']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit UMKM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-4">Edit Data UMKM</h3>
        <form action="updateumkm.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
          <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($row['foto']) ?>">

          <!-- Nama UMKM -->
          <div class="mb-3">
            <label for="nama" class="form-label">Nama UMKM</label>
            <input type="text" name="nama" id="nama" class="form-control"
              placeholder="Contoh: Warung Sate Bu Siti" value="<?= htmlspecialchars($row['nama']) ?>" required>
          </div>

          <!-- Nama Pengusaha -->
          <div class="mb-3">
            <label for="nama_pengusaha" class="form-label">Nama Pengusaha</label>
            <input type="text" name="nama_pengusaha" id="nama_pengusaha" class="form-control"
              placeholder="Contoh: Siti Aminah" value="<?= htmlspecialchars($row['nama_pengusaha']) ?>" required>
          </div>

          <!-- Nomor HP -->
          <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control"
              placeholder="Contoh: 081234567890" value="<?= htmlspecialchars($row['no_hp']) ?>" required>
          </div>

          <!-- Alamat Lengkap -->
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3"
              placeholder="Contoh: Jl. Trunojoyo No. 45, Sumenep" required><?= htmlspecialchars($row['alamat']) ?></textarea>
          </div>

          <!-- Kecamatan -->
          <div class="mb-3">
            <label for="kecamatan" class="form-label">Kecamatan</label>
            <select name="kecamatan" id="kecamatan" class="form-select" required>
              <option value="">-- Pilih Kecamatan --</option>
              <?php
              $listKecamatan = [
                "Ambunten", "Arjasa", "Batang Batang", "Batuan", "Batuputih", "Bluto", "Dasuk", "Dungkek",
                "Ganding", "Gapura", "Gayam", "Giligenting", "Guluk-Guluk", "Kalianget", "Kangayan",
                "Kota Sumenep", "Lenteng", "Manding", "Masalembu", "Nonggunong", "Pasongsongan",
                "Pragaan", "Raas", "Rubaru", "Sapeken", "Saronggi", "Talango"
              ];
              foreach ($listKecamatan as $kc) {
                $selected = ($row['kecamatan'] == $kc) ? 'selected' : '';
                echo "<option value=\"$kc\" $selected>$kc</option>";
              }
              ?>
            </select>
          </div>

          <!-- Sektor Usaha -->
          <div class="mb-3">
            <label for="sektor" class="form-label">Sektor Usaha</label>
            <select name="sektor[]" id="sektor" class="form-select" multiple required>
              <?php
              $sektorList = ["Jasa", "Pengolahan", "Perdagangan", "Pertanian", "Kerajinan", "Perikanan", "Peternakan"];
              foreach ($sektorList as $ss) {
                $selected = in_array($ss, $selectedSektor) ? 'selected' : '';
                echo "<option value=\"$ss\" $selected>$ss</option>";
              }
              ?>
            </select>
          </div>

          <!-- Foto -->
          <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control">
            <?php if (!empty($row['foto'])): ?>
              <div class="mb-2">
                <img src="../uploads/<?= htmlspecialchars($row['foto']) ?>" alt="Foto UMKM" class="img-thumbnail" width="200">
              </div>
              <small class="text-muted">Foto saat ini: <?= htmlspecialchars($row['foto']) ?></small>
            <?php endif; ?>
          </div>

          <!-- Koordinat -->
          <!-- Tombol Deteksi Lokasi -->
<button type="button" class="btn btn-outline-primary mb-3" onclick="getLocation()">Deteksi Lokasi Saya</button>

<!-- Input Latitude & Longitude -->
<div class="row mb-3">
  <div class="col-md-6">
    <label>Latitude</label>
    <input type="text" name="latitude" id="latitude" class="form-control" readonly required>
  </div>
  <div class="col-md-6">
    <label>Longitude</label>
    <input type="text" name="longitude" id="longitude" class="form-control" readonly required>
  </div>
</div>
<!-- Peta -->
<div id="map" style="height: 400px;" class="mb-4"></div>

          <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="../index.php" class="btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JavaScript & Select2 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#sektor').select2({
        placeholder: "Pilih subsektor usaha...",
        allowClear: true,
        width: '100%'
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  let map, marker;

  function initMap() {
    const lat = parseFloat(document.getElementById("latitude").value) || -7.016;
    const lng = parseFloat(document.getElementById("longitude").value) || 113.874;
    const defaultLocation = { lat: lat, lng: lng };

    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 12,
      center: defaultLocation,
    });

    marker = new google.maps.Marker({
      position: defaultLocation,
      map: map,
    });

    map.addListener("click", function (e) {
      const lat = e.latLng.lat();
      const lng = e.latLng.lng();

      document.getElementById("latitude").value = lat;
      document.getElementById("longitude").value = lng;

      if (marker) marker.setMap(null);
      marker = new google.maps.Marker({
        position: e.latLng,
        map: map,
      });
    });
  }

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;

        map.setCenter({ lat: lat, lng: lng });

        if (marker) marker.setMap(null);
        marker = new google.maps.Marker({
          position: { lat: lat, lng: lng },
          map: map,
        });
      }, function() {
        alert("Gagal mendeteksi lokasi.");
      });
    } else {
      alert("Browser tidak mendukung geolokasi.");
    }
  }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6cJA-U10w8ArbOVYWJ56Iojo-RBT7a8I&callback=initMap" async defer></script>
</body>
</html>
