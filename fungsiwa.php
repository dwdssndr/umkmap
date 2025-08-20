<?php
function kirimNotifikasiWA($nomorTujuan, $pesan) {
  $apiKey    = "c21363a78cb9e9c4014f6b17e8baad5e";  // API KEY kamu
  $deviceID  = "888686047738";                     // Device ID kamu
  $endpoint  = "https://api.alatwa.com/send/text";

  // Header sesuai spesifikasi AlatWA
  $header = [
    "Content-Type: application/json",
    "Authorization: $apiKey"
  ];

  // Body request
  $data = [
    "device"  => $deviceID,
    "phone"   => $nomorTujuan,
    "message" => $pesan
  ];

  // Encode JSON
  $param_post = json_encode($data, JSON_PRETTY_PRINT);

  // Eksekusi cURL
  $curl = curl_init($endpoint);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $param_post);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0); 
  curl_setopt($curl, CURLOPT_TIMEOUT, 10);
  $response = curl_exec($curl);
  curl_close($curl);

  // Proses hasil respons
  $responseData = json_decode($response, true);
  $status       = $responseData['status']     ?? 'gagal';
  $message_id   = $responseData['message_id'] ?? '-';
  $error_msg    = $responseData['message']    ?? '-';

  // Log hasil
  $log = date('Y-m-d H:i:s') . 
         " | Status: $status | To: $nomorTujuan | Message ID: $message_id | Response: $error_msg\n";
  file_put_contents('log_pengiriman.txt', $log, FILE_APPEND);
  file_put_contents('log_raw_wa.txt', $response . "\n", FILE_APPEND);

  return [
    'status'     => $status,
    'message_id' => $message_id,
    'error_msg'  => $error_msg,
    'raw'        => $response
  ];
}
?>
