<?php
session_start();
require_once "../app.php";

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $nama     = escapeString($koneksi, $_POST['nama']);
    $username = escapeString($koneksi, $_POST['username']);
    $password = escapeString($koneksi, $_POST['password']);
    
    // 1. Cek apakah username sudah ada di database
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        $error = "Username sudah terdaftar! Silakan gunakan username lain.";
    } else {
        // 2. OTOMATIS ROLE USER (Peminjaman)
        // Mencari ID role yang memiliki nama 'peminjaman' atau 'user'
        $role_query = mysqli_query($koneksi, "SELECT id_role FROM roles WHERE nama_role='peminjaman' OR nama_role='user' LIMIT 1");
        $role_data  = mysqli_fetch_assoc($role_query);
        
        // Jika di database tidak ditemukan nama_role tersebut, kita beri default ID (biasanya 3 untuk user)
        $id_role = ($role_data) ? $role_data['id_role'] : 3; 

        // 3. Simpan data ke tabel users
        $query_insert = "INSERT INTO users (nama, username, password, id_role) 
                         VALUES ('$nama', '$username', '$password', '$id_role')";
        
        $insert = mysqli_query($koneksi, $query_insert);
        
        if ($insert) {
            $success = "Registrasi berhasil! Sekarang Anda adalah anggota. Silakan login.";
        } else {
            $error = "Gagal mendaftar: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Register | Peminjaman Rebana</title>
    <link rel="stylesheet" href="../template/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2691E;
            --accent-color: #F4A460;
        }
        body {
            background: linear-gradient(135deg, #f5e8d0 0%, #e6d2b5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card-register {
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(139, 69, 19, 0.2);
            background: rgba(255, 255, 255, 0.95);
            overflow: hidden;
        }
        .card-header-register {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 5px solid var(--accent-color);
        }
        .form-control { border-radius: 10px; padding: 12px; }
        .btn-register {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: 0.3s;
        }
        .btn-register:hover { opacity: 0.9; transform: translateY(-2px); color: white; }
        .rebana-icon { color: var(--primary-color); margin-right: 8px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="card card-register">
                    <div class="card-header-register">
                        <h3 class="mb-0"><i class="fas fa-user-plus"></i> Gabung Member</h3>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-center text-muted mb-4">Daftar sekarang untuk meminjam alat musik rebana</p>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error; ?></div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success"><?= $success; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-id-card rebana-icon"></i> Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Contoh: Ahmad Fauzi" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user rebana-icon"></i> Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Buat username unik" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-lock rebana-icon"></i> Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Buat password aman" required>
                            </div>

                            <button type="submit" name="register" class="btn btn-register w-100 mb-3">
                                <i class="fas fa-check-circle me-2"></i> Konfirmasi Pendaftaran
                            </button>
                            
                            <div class="text-center">
                                <span class="text-muted">Sudah punya akun?</span> 
                                <a href="login.php" class="fw-bold text-decoration-none" style="color: var(--secondary-color)">Login Sekarang</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../template/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>