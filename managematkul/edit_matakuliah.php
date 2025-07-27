<?php
session_start();

// Gatekeeper: Hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect ke halaman utama dengan pesan error akses ditolak
    header('Location: ../index.php?error=access_denied');
    exit();
}

// ---- Kode asli halaman dimulai dari sini ----
require_once '../Main/config_db.php'; 
// ...dan seterusnya...
?>
<?php
require_once '../main/config_db.php'; // Memuat koneksi database

$message = '';
$entry = null; // Untuk menyimpan data mata kuliah yang akan diedit
$kode_mk_edit = isset($_GET['kode_mk']) ? mysqli_real_escape_string($conn, $_GET['kode_mk']) : null;

// Ambil daftar Prodi untuk dropdown
$prodi_options = [];
$sql_prodi_list = "SELECT id_prodi, nama_prodi FROM prodi ORDER BY nama_prodi ASC";
$result_prodi_list = mysqli_query($conn, $sql_prodi_list);
if ($result_prodi_list) {
    while ($row_prodi = mysqli_fetch_assoc($result_prodi_list)) {
        $prodi_options[] = $row_prodi;
    }
}

// Jika ada kode_mk dan bukan request POST (untuk menampilkan data awal)
if ($kode_mk_edit && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $sql_select = "SELECT kode_mk, id_prodi, nama_mk, sks FROM matakuliah WHERE kode_mk = ?";
    $stmt_select = mysqli_prepare($conn, $sql_select);
    mysqli_stmt_bind_param($stmt_select, "s", $kode_mk_edit);
    mysqli_stmt_execute($stmt_select);
    $result = mysqli_stmt_get_result($stmt_select);
    $entry = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt_select);

    if (!$entry) {
        $message = '<div class="alert alert-danger">Data mata kuliah tidak ditemukan.</div>';
        $kode_mk_edit = null; // Reset kode_mk agar form tidak tampil jika data tak ada
    }
}

// Proses penyimpanan hasil edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $kode_mk_edit) {
    $id_prodi_new = mysqli_real_escape_string($conn, $_POST['id_prodi']);
    $nama_mk_new = mysqli_real_escape_string($conn, $_POST['nama_mk']);
    $sks_new = (int)$_POST['sks'];
    // kode_mk yang sedang diedit tidak diubah nilainya (biasanya primary key tidak diubah)
    // Jika Anda ingin mengizinkan perubahan kode_mk juga, querynya perlu disesuaikan dan ada validasi tambahan.

    $update_sql = "UPDATE matakuliah SET id_prodi = ?, nama_mk = ?, sks = ? WHERE kode_mk = ?";
    $stmt_update = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt_update, "ssis", $id_prodi_new, $nama_mk_new, $sks_new, $kode_mk_edit);

    if (mysqli_stmt_execute($stmt_update)) {
        mysqli_stmt_close($stmt_update);
        // Redirect kembali ke halaman manage_matakuliah dengan pesan sukses
        header("Location: manage_matakuliah.php?status=edited&kode_mk=" . urlencode($kode_mk_edit));
        exit();
    } else {
        $message = '<div class="alert alert-danger">Error: Gagal memperbarui data. ' . mysqli_error($conn) . '</div>';
        // Untuk menampilkan kembali data yang gagal diupdate di form
        $entry = [
            'kode_mk' => $kode_mk_edit,
            'id_prodi' => $id_prodi_new,
            'nama_mk' => $nama_mk_new,
            'sks' => $sks_new
        ];
    }
     if(isset($stmt_update)) mysqli_stmt_close($stmt_update); // Pastikan ditutup jika gagal
}

// Ambil status dari redirect untuk pesan
if (isset($_GET['status']) && $_GET['status'] === 'edited_error') {
    $message = '<div class="alert alert-danger">Gagal memperbarui data mata kuliah ' . (isset($_GET['kode_mk']) ? htmlspecialchars($_GET['kode_mk']) : '') . '.</div>';
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Edit Data Mata Kuliah</h1>
            <a href="manage_matakuliah.php" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>

        <?= $message ?>

        <?php if ($kode_mk_edit && $entry): ?>
            <form method="POST" action="edit_matakuliah.php?kode_mk=<?= htmlspecialchars($kode_mk_edit) ?>">
                <div class="mb-3">
                    <label for="kode_mk_display" class="form-label">Kode Mata Kuliah</label>
                    <input type="text" class="form-control" id="kode_mk_display" value="<?= htmlspecialchars($entry['kode_mk']) ?>" readonly>
                    </div>
                <div class="mb-3">
                    <label for="id_prodi_edit" class="form-label">Program Studi</label>
                    <select class="form-select" id="id_prodi_edit" name="id_prodi" required>
                        <option value="">-- Pilih Prodi --</option>
                        <?php foreach ($prodi_options as $prodi): ?>
                            <option value="<?= htmlspecialchars($prodi['id_prodi']) ?>" <?= ($entry['id_prodi'] === $prodi['id_prodi'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($prodi['nama_prodi']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama_mk_edit" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" class="form-control" id="nama_mk_edit" name="nama_mk" value="<?= htmlspecialchars($entry['nama_mk']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="sks_edit" class="form-label">SKS</label>
                    <input type="number" class="form-control" id="sks_edit" name="sks" value="<?= htmlspecialchars($entry['sks']) ?>" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        <?php elseif(!$kode_mk_edit): ?>
            <div class="alert alert-warning">Tidak ada kode mata kuliah yang dipilih untuk diedit.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php mysqli_close($conn); // Tutup koneksi ?>
</body>
</html>