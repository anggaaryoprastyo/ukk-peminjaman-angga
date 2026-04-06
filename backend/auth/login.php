<?php
session_start();

require_once "../app.php";

$error = "";

if (isset($_POST['login'])) {
    $username = escapeString($koneksi, $_POST['username']);
    $password = escapeString($koneksi, $_POST['password']);
    $role     = escapeString($koneksi, $_POST['role']);

    $query = mysqli_query(
        $koneksi,
        "SELECT u.*, r.nama_role
         FROM users u
         JOIN roles r ON u.id_role = r.id_role
         WHERE u.username='$username'"
    );

    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);

       if ($password === $user['password']) {

            $_SESSION['login']   = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['nama_role'];

            // LOGIKA PENGALIHAN BERDASARKAN ROLE
            if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'petugas') {
                // Admin & Petugas masuk ke Dashboard
                header("Location: ../pages/dashboard/index.php");
            } else {
                // User/Peminjam langsung ke halaman depan (Index Utama)
                header("Location: /ukk/index.php");
            }
            exit;
            
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username atau role tidak sesuai!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login | Peminjaman Rebana</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        
        .card-login {
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(139, 69, 19, 0.2);
            overflow: hidden;
            z-index: 10;
            position: relative;
            background: rgba(255, 255, 255, 0.95);
        }
        
        .card-header-login {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 25px 20px;
            text-align: center;
            border-bottom: 5px solid var(--accent-color);
        }
        
        .card-header-login h3 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 1.2rem;
        }
        
        .card-header-login i {
            color: var(--accent-color);
            margin-right: 10px;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(210, 105, 30, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: linear-gradient(to right, #6e3810, #a8521a);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
            color: white;
        }
        
        .floating-rebana {
            position: absolute;
            opacity: 0.7;
            z-index: 1;
        }
        
        .rebana-1 { width: 120px; height: 120px; top: 10%; left: 5%; animation: float 15s infinite ease-in-out; filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1)); }
        .rebana-2 { width: 80px; height: 80px; top: 70%; right: 8%; animation: float 12s infinite ease-in-out reverse; animation-delay: 2s; }
        .rebana-3 { width: 100px; height: 100px; bottom: 15%; left: 10%; animation: float 18s infinite ease-in-out; animation-delay: 4s; }
        .rebana-4 { width: 60px; height: 60px; top: 15%; right: 12%; animation: float 10s infinite ease-in-out reverse; animation-delay: 1s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(5deg); }
            66% { transform: translateY(10px) rotate(-5deg); }
        }
        
        .pulse { animation: pulse 2s infinite; }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .login-title {
            color: var(--primary-color);
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .login-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background: var(--accent-color);
            bottom: -5px;
            left: 25%;
            border-radius: 3px;
        }
        
        .footer-login {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .rebana-icon {
            color: var(--primary-color);
            margin-right: 8px;
        }
        
        .music-note {
            position: absolute;
            color: var(--accent-color);
            font-size: 24px;
            opacity: 0.7;
            z-index: 2;
        }
        
        .note-1 { top: 20%; left: 15%; animation: noteFloat 8s infinite linear; }
        .note-2 { top: 60%; right: 20%; animation: noteFloat 10s infinite linear; animation-delay: 1s; }
        .note-3 { bottom: 30%; left: 20%; animation: noteFloat 12s infinite linear; animation-delay: 2s; }
        
        @keyframes noteFloat {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 0.7; }
            90% { opacity: 0.7; }
            100% { transform: translateY(-100px) translateX(50px); opacity: 0; }
        }
        
        @media (max-width: 768px) {
            .floating-rebana, .music-note { display: none; }
            .card-login { margin: 20px; }
        }
    </style>
</head>

<body>
    <div class="floating-rebana rebana-1"><svg viewBox="0 0 100 100"><circle cx="50" cy="50" r="45" fill="#8B4513" stroke="#D2691E" stroke-width="3"/><circle cx="50" cy="50" r="35" fill="#F4A460" stroke="#D2691E" stroke-width="2"/><circle cx="50" cy="50" r="15" fill="#8B4513" stroke="#D2691E" stroke-width="2"/><circle cx="50" cy="50" r="8" fill="#F4A460"/><line x1="50" y1="10" x2="50" y2="90" stroke="#D2691E" stroke-width="1.5"/><line x1="10" y1="50" x2="90" y2="50" stroke="#D2691E" stroke-width="1.5"/></svg></div>
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="card card-login pulse">
                        <div class="card-header-login">
                            <h3><i class="fas fa-drum"></i> PUSAT PEMINJAMAN REBANA YOGYAKARTA</h3>
                        </div>
                        <div class="card-body">
                            <h4 class="login-title"><i class="fas fa-sign-in-alt rebana-icon"></i> LOGIN</h4>
                            <p class="text-center text-muted mb-4">Masukkan username dan password untuk mengakses sistem</p>

                            <?php if ($error != ""): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i> <?= $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-user rebana-icon"></i> Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-lock rebana-icon"></i> Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label"><i class="fas fa-user-tag rebana-icon"></i> Login Sebagai</label>
                                    <select name="role" class="form-control" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin">Admin</option>
                                        <option value="petugas">Petugas</option>
                                        <option value="peminjaman">User</option>
                                    </select>
                                </div>

                                <button type="submit" name="login" class="btn btn-login w-100 text-white mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </form>

                            <div class="text-center mt-3">
                                <p class="text-muted mb-0">Belum punya akun?</p>
                                <a href="register.php" class="fw-bold text-decoration-none" style="color: var(--secondary-color);">
                                    <i class="fas fa-user-plus me-1"></i> Daftar Akun Sekarang
                                </a>
                            </div>

                            <div class="footer-login">
                                <p class="mb-0"><i class="fas fa-drum rebana-icon"></i> Pusat Peminjaman Rebana YOGYAKARTA &copy; <?= date('Y'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../template/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>