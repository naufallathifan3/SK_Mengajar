<?php
session_start();

// Jika user sudah login, redirect ke halaman index di folder Main
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php'); // <-- DIUBAH
    exit();
}
$error = $_GET['error'] ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SIM Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f8f9fa; }
        .login-card { width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <div class="card login-card shadow">
        <div class="card-header text-center bg-success text-white">
            <h3 class="mb-0">SK-MENGAJAR</h3>
            <p class="mb-0">Biro Administrasi Akademik UNISSULA</p>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger">Username atau password salah!</div>
            <?php endif; ?>
            <form action="handle_login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>