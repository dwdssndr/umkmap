<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar UMKM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h3 class="mb-4" style="text-align: center;"><i></i> DAFTAR UMKM</h3>
          <form action="prosesdafumkm.php" method="POST" enctype="multipart/form-data">
          <!-- Nama UMKM -->
          <div class="mb-3">
            <label for="nama" class="form-label">Nama UMKM</label>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Warung Sate Bu Siti" required>
          </div>
 <!-- Nama Pengusaha -->
<div class="mb-3">
  <label for="nama_pengusaha" class="form-label">Nama Pengusaha</label>
  <input type="text" name="nama_pengusaha" id="nama_pengusaha" class="form-control" placeholder="Contoh: Siti Aminah" required>
</div>

<!-- Nomor HP -->
<div class="mb-3">
  <label for="no_hp" class="form-label">Nomor HP</label>
  <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Contoh: 081234567890" required>
</div>
          <!-- Alamat UMKM -->
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Contoh: Jl. Trunojoyo No. 45, Sumenep" required></textarea>
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
                echo "<option value=\"$kc\">$kc</option>";
              }
              ?>
            </select>
          </div>

<div class="mb-3">
  <label for="sektor" class="form-label">Sektor Usaha</label>
  <select name="sektor[]" id="sektor" class="form-select" multiple required>
    <?php
    $sektorList = ["Jasa", "Pengolahan", "Perdagangan", "Pertanian", "Kerajinan", "Perikanan", "Peternakan"
    ];
    foreach ($sektorList as $ss) {
      echo "<option value=\"$ss\">$ss</option>";
    }
    ?>
  </select>
</div>
<!-- Foto -->
          <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control">
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


          <!-- Submit -->
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="bi bi-send-check me-2"></i> Daftarkan UMKM
            </button>
          </div>
        </form>

      </div>
    </div>
    <a href="../index.php" class="btn btn-sm btn-secondary">Kembali</a>
  </div>
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
document.querySelector('form').addEventListener('submit', function(e) {
  const submitBtn = this.querySelector('button[type="submit"]');
  submitBtn.disabled = true;
  submitBtn.innerText = "Mengirim...";
});
</script>
<script>
  let map, marker;

  function initMap() {
    const defaultLocation = { lat: -7.016, lng: 113.874 }; // Sumenep
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 12,
      center: defaultLocation,
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
