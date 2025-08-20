<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Akun UMKM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f0f2f5, #dfe6ed);
      font-family: 'Inter', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .register-card {
      background-color: #ffffff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 420px;
    }
    .register-title {
      font-size: 1.6rem;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
      color: #212529;
    }
    .form-label {
      font-weight: 500;
      color: #495057;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-register {
      background-color: #28a745;
      border: none;
      font-weight: 500;
      border-radius: 8px;
    }
    .btn-register:hover {
      background-color: #218838;
    }
    .footer {
      text-align: center;
      font-size: 0.85rem;
      color: #6c757d;
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <div class="register-card">
  <div class="register-title">Daftar Akun UMKM</div>
  <form method="POST" action="proses_daftar.php" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Nama Lengkap</label>
      <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">No. Telepon</label>
      <input type="text" name="telepon" class="form-control" required>
    </div>
            <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-register w-100 mt-3">Daftar</button>
  </form>
  <div class="text-center mt-3">
    Sudah punya akun? <a href="login.php" class="text-decoration-none text-success fw-semibold">Login di sini</a>
  </div>
  <div class="footer">
    &copy; <?= date('Y'); ?> UMKM Sumenep. All rights reserved.
  </div>
</div>

</body>
</html>
