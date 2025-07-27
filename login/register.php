<?php
session_start();

// Gatekeeper: Hanya admin yang boleh mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Jika bukan admin, tendang ke halaman utama atau tampilkan pesan error
    die("Akses ditolak. Anda harus login sebagai admin untuk mengakses halaman ini.");
}

// Ambil pesan status dari URL (jika ada)
$status = $_GET['status'] ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi User Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow" style="max-width: 600px; margin: auto;">
            <div class="card-header bg-primary text-white">
                <h1 class="mb-0">Form Registrasi User Baru</h1>
            </div>
            <div class="card-body">
                <?php if ($status == 'success'): ?>
                    <div class="alert alert-success">User baru berhasil dibuat!</div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="handle_register.php" method="post">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrasi User</button>
                </form>
                <a href="../Main/index.php" class="btn btn-secondary w-100 mt-2">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
</body>
</html>