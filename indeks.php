<?php
session_start();
include 'WEBGIS/koneksi.php';

// Cek apakah user login dan berperan admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if ($isAdmin) {
  $qMenunggu = "SELECT * FROM umkm WHERE status = 'menunggu'";
  $resMenunggu = $conn->query($qMenunggu);
}
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="./resources/ol.css">
        <link rel="stylesheet" href="./resources/ol3-layerswitcher.css">
        <link rel="stylesheet" href="./resources/qgis2web.css">
        <style>
        html, body {
            background-color: #ffffff;
        }
        </style>
        <style>
        html, body, #map {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }
        </style>
        <title></title>
    </head>
    <body>
        <div id="map">
            <div id="popup" class="ol-popup">
                <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                <div id="popup-content"></div>
            </div>
        </div>
        <script src="resources/qgis2web_expressions.js"></script>
        <script src="resources/polyfills.js"></script>
        <script src="./resources/functions.js"></script>
        <script src="./resources/ol.js"></script>
        <script src="./resources/ol3-layerswitcher.js"></script>
        <script src="layers/SMK_0.js"></script><script src="layers/SMA_1.js"></script><script src="layers/SMP_2.js"></script><script src="layers/SD_3.js"></script>
        <script src="styles/SMK_0_style.js"></script><script src="styles/SMA_1_style.js"></script><script src="styles/SMP_2_style.js"></script><script src="styles/SD_3_style.js"></script>
        <script src="./layers/layers.js" type="text/javascript"></script> 
        <script src="./resources/qgis2web.js"></script>
        <script src="./resources/Autolinker.min.js"></script>
        <script>
  // Inisialisasi peta
  var map = L.map('map').setView([-7.015, 113.864], 10);

  // Tambahkan tile dari OpenStreetMap
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
  }).addTo(map);

  // Tambahkan marker pusat Sumenep
  L.marker([-7.015, 113.864])
    .addTo(map)
    .bindPopup('Ini adalah pusat Kabupaten Sumenep.')
    .openPopup();

  // Tambahkan layer batas wilayah dari GeoJSON
  // Tambahkan layer batas wilayah Sumenep dari GeoJSON
fetch('sumenep-kecamatan.geojson')
  .then(res => res.json())
  .then(data => {
    L.geoJSON(data, {
      style: function (feature) {
        return {
          color: "#ff0000",       // warna garis batas
          weight: 2,
          opacity: 1,
          fillColor: "#ffcccc",   // warna isi wilayah
          fillOpacity: 0.3
        };
      },
      onEachFeature: function (feature, layer) {
        if (feature.properties && feature.properties.NAME_2) {
          layer.bindPopup("Wilayah: " + feature.properties.NAME_2);
        }
      }
    }).addTo(map);
  })
  .catch(err => console.error("Gagal memuat GeoJSON:", err));
</script>
    </body>
</html>
