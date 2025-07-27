<?php
session_start();

// Gatekeeper: Hanya admin yang boleh mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak. Halaman ini hanya untuk Admin.");
}

require_once '../../main/config_db.php';

// Ambil semua user dari database untuk ditampilkan
$sql = "SELECT id, username, nama_lengkap, role FROM user ORDER BY nama_lengkap ASC";
$result = mysqli_query($conn, $sql);

// Ambil pesan status dari URL (jika ada, setelah update)
$status = $_GET['status'] ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h1 class="mb-0">Manajemen User</h1>
            </div>
            <div class="card-body">
                <?php if ($status == 'success'): ?>
                    <div class="alert alert-success">Role user berhasil diperbarui!</div>
                <?php elseif (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role Saat Ini</th>
                                <th style="width: 250px;">Ubah Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while($user = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td>
                                        <?php if ($user['role'] == 'admin'): ?>
                                            <span class="badge bg-success">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Operator</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                            <span class="text-muted fst-italic">Tidak bisa mengubah role sendiri</span>
                                        <?php else: ?>
                                            <form action="handle_update_role.php" method="POST" class="d-flex">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <select name="new_role" class="form-select form-select-sm me-2">
                                                    <option value="operator" <?= ($user['role'] == 'operator') ? 'selected' : '' ?>>Operator</option>
                                                    <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <a href="../../index.php" class="btn btn-secondary mt-3">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>