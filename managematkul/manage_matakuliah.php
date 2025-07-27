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

$message = ''; // Untuk pesan sukses atau error

// Handle Aksi (Tambah, Hapus)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $kode_mk = mysqli_real_escape_string($conn, $_POST['kode_mk']);
            $id_prodi = mysqli_real_escape_string($conn, $_POST['id_prodi']);
            $nama_mk = mysqli_real_escape_string($conn, $_POST['nama_mk']);
            $sks = (int)$_POST['sks']; // Pastikan SKS adalah integer

            // Cek apakah kode_mk sudah ada
            $check_sql = "SELECT kode_mk FROM matakuliah WHERE kode_mk = ?";
            $stmt_check = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($stmt_check, "s", $kode_mk);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);

            if (mysqli_stmt_num_rows($stmt_check) > 0) {
                $message = '<div class="alert alert-danger">Error: Kode Mata Kuliah ' . htmlspecialchars($kode_mk) . ' sudah ada.</div>';
            } else {
                $insert_sql = "INSERT INTO matakuliah (kode_mk, id_prodi, nama_mk, sks) VALUES (?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($conn, $insert_sql);
                mysqli_stmt_bind_param($stmt_insert, "sssi", $kode_mk, $id_prodi, $nama_mk, $sks);
                if (mysqli_stmt_execute($stmt_insert)) {
                    $message = '<div class="alert alert-success">Data mata kuliah berhasil ditambahkan.</div>';
                } else {
                    $message = '<div class="alert alert-danger">Error: Gagal menambahkan data. ' . mysqli_error($conn) . '</div>';
                }
                mysqli_stmt_close($stmt_insert);
            }
            mysqli_stmt_close($stmt_check);

        } elseif ($action === 'delete') {
            $kode_mk_delete = mysqli_real_escape_string($conn, $_POST['kode_mk_delete']);
            // Periksa apakah matakuliah digunakan di tabel 'mengajar'
            $check_mengajar_sql = "SELECT kode_mk FROM mengajar WHERE kode_mk = ?";
            $stmt_check_mengajar = mysqli_prepare($conn, $check_mengajar_sql);
            mysqli_stmt_bind_param($stmt_check_mengajar, "s", $kode_mk_delete);
            mysqli_stmt_execute($stmt_check_mengajar);
            mysqli_stmt_store_result($stmt_check_mengajar);

            if (mysqli_stmt_num_rows($stmt_check_mengajar) > 0) {
                $message = '<div class="alert alert-danger">Error: Mata kuliah ' . htmlspecialchars($kode_mk_delete) . ' tidak dapat dihapus karena masih digunakan di data pengajaran.</div>';
            } else {
                $delete_sql = "DELETE FROM matakuliah WHERE kode_mk = ?";
                $stmt_delete = mysqli_prepare($conn, $delete_sql);
                mysqli_stmt_bind_param($stmt_delete, "s", $kode_mk_delete);
                if (mysqli_stmt_execute($stmt_delete)) {
                    $message = '<div class="alert alert-success">Data mata kuliah berhasil dihapus.</div>';
                } else {
                    $message = '<div class="alert alert-danger">Error: Gagal menghapus data. ' . mysqli_error($conn) . '</div>';
                }
                mysqli_stmt_close($stmt_delete);
            }
            mysqli_stmt_close($stmt_check_mengajar);
        }
        // Tidak perlu header redirect agar pesan bisa ditampilkan
    }
}

// Ambil daftar Prodi untuk filter dan form tambah
$prodi_options = [];
$sql_prodi_list = "SELECT id_prodi, nama_prodi FROM prodi ORDER BY nama_prodi ASC";
$result_prodi_list = mysqli_query($conn, $sql_prodi_list);
if ($result_prodi_list) {
    while ($row_prodi = mysqli_fetch_assoc($result_prodi_list)) {
        $prodi_options[] = $row_prodi;
    }
}

// Filter dan Urutan Data
$filter_prodi_val = isset($_GET['filter_prodi']) ? mysqli_real_escape_string($conn, $_GET['filter_prodi']) : '';
$order_val = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';

$sql_matakuliah = "SELECT mk.kode_mk, mk.nama_mk, mk.sks, p.nama_prodi AS nama_prodi_display, mk.id_prodi
                   FROM matakuliah mk
                   JOIN prodi p ON mk.id_prodi = p.id_prodi";

if (!empty($filter_prodi_val)) {
    $sql_matakuliah .= " WHERE mk.id_prodi = '" . $filter_prodi_val . "'";
}
$sql_matakuliah .= " ORDER BY mk.nama_mk " . ($order_val === 'desc' ? 'DESC' : 'ASC');

$result_matakuliah = mysqli_query($conn, $sql_matakuliah);
$matakuliah_data = [];
if ($result_matakuliah) {
    while ($row_mk = mysqli_fetch_assoc($result_matakuliah)) {
        $matakuliah_data[] = $row_mk;
    }
} else {
    $message .= '<div class="alert alert-warning">Gagal mengambil data mata kuliah: ' . mysqli_error($conn) . '</div>';
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Data Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Kelola Data Mata Kuliah</h1>
            <a href="../index.php" class="btn btn-secondary">Kembali ke Index</a>
        </div>

        <?= $message ?>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Tambah Mata Kuliah Baru</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="manage_matakuliah.php">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_mk" class="form-label">Kode Mata Kuliah <small class="text-danger">(Harus Unik)</small></label>
                            <input type="text" class="form-control" id="kode_mk" name="kode_mk" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_prodi_add" class="form-label">Program Studi</label>
                            <select class="form-select" id="id_prodi_add" name="id_prodi" required>
                                <option value="">-- Pilih Prodi --</option>
                                <?php foreach ($prodi_options as $prodi): ?>
                                    <option value="<?= htmlspecialchars($prodi['id_prodi']) ?>">
                                        <?= htmlspecialchars($prodi['nama_prodi']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="nama_mk" name="nama_mk" required>
                    </div>
                    <div class="mb-3">
                        <label for="sks" class="form-label">SKS</label>
                        <input type="number" class="form-control" id="sks" name="sks" min="1" required>
                    </div>
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="btn btn-success">Tambah Data</button>
                </form>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <label for="filter_prodi" class="form-label">Filter Program Studi</label>
                        <select name="filter_prodi" id="filter_prodi" class="form-select">
                            <option value="">-- Semua Prodi --</option>
                            <?php foreach ($prodi_options as $prodi): ?>
                                <option value="<?= htmlspecialchars($prodi['id_prodi']) ?>" <?= (isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === $prodi['id_prodi'] ? 'selected' : '') ?>>
                                    <?= htmlspecialchars($prodi['nama_prodi']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="order" class="form-label">Urutkan berdasarkan Nama MK</label>
                        <select name="order" id="order" class="form-select">
                            <option value="asc" <?= (isset($_GET['order']) && $_GET['order'] === 'asc' ? 'selected' : '') ?>>Ascending (A-Z)</option>
                            <option value="desc" <?= (isset($_GET['order']) && $_GET['order'] === 'desc' ? 'selected' : '') ?>>Descending (Z-A)</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter/Sortir</button>
                    </div>
                </form>
            </div>
        </div>


        <h3>Daftar Mata Kuliah</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Program Studi</th>
                        <th>SKS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($matakuliah_data)): ?>
                        <?php foreach ($matakuliah_data as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['kode_mk']) ?></td>
                                <td><?= htmlspecialchars($row['nama_mk']) ?></td>
                                <td><?= htmlspecialchars($row['nama_prodi_display']) ?></td>
                                <td><?= htmlspecialchars($row['sks']) ?></td>
                                <td>
                                    <a href="edit_matakuliah.php?kode_mk=<?= htmlspecialchars($row['kode_mk']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <form method="POST" action="manage_matakuliah.php" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');">
                                        <input type="hidden" name="kode_mk_delete" value="<?= htmlspecialchars($row['kode_mk']) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data mata kuliah.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php mysqli_close($conn); // Tutup koneksi ?>
</body>
</html>