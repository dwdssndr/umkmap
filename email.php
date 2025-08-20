<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function kirimNotifikasi($to, $namaUser, $namaUMKM, $status) {
  $mail = new PHPMailer(true);

  try {
    // 🔧 Konfigurasi SMTP Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dwidesisuandari@gmail.com';      // Ganti dengan email kamu
    $mail->Password   = 'msuy oran sfxx ovox';               // Gunakan App Password Gmail yang valid
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // 📧 Pengaturan pengirim & penerima
    $mail->setFrom('dwidesisuandari@gmail.com', 'UMKMap Sumenep');
    $mail->addAddress($to, $namaUser);
    $mail->isHTML(true);

    // 📝 Subjek & Isi email
    if ($status === 'aktif') {
      $mail->Subject = "Status UMKM Anda Telah Disetujui";
      $mail->Body = "
      <div style='font-family:sans-serif; font-size:14px;'>
        Halo <strong>$namaUser</strong>,<br><br>
        UMKM Anda <strong>$namaUMKM</strong> sudah aktif di sistem <strong>UMKMap Sumenep</strong>.<br>
        Silakan cek dashboard Anda:<br><br>
        <a href='https://umkm-sumenep.my.id' style='color:#007BFF;'>https://umkm-sumenep.my.id</a><br><br>
        Terima kasih atas kontribusi Anda.
      </div>";
    } else {
      $mail->Subject = "UMKM Anda Belum Lolos Validasi";
      $mail->Body = "
      <div style='font-family:sans-serif; font-size:14px;'>
        Halo <strong>$namaUser</strong>,<br><br>
        Mohon maaf, UMKM Anda <strong>$namaUMKM</strong> belum lolos proses validasi oleh tim <strong>UMKMap</strong>.<br>
        Silakan periksa kembali data Anda dan ajukan ulang jika diperlukan.<br><br>
        Semangat terus!
      </div>";
    }

    // 🚀 Kirim email
    $mail->send();
    return true;
  } catch (Exception $e) {
    error_log("Gagal kirim email: " . $mail->ErrorInfo);
    return false;
  }
}
