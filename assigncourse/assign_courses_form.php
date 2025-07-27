<?php
session_start();

// Gatekeeper: Hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Untuk file pemroses (handle), cukup hentikan eksekusi
    die("Akses Ditolak. Anda tidak memiliki izin untuk melakukan tindakan ini.");
}

// ---- Kode asli halaman dimulai dari sini ----
require_once '../Main/config_db.php'; 
// ...dan seterusnya...
?>
<?php
require_once '../main/config_db.php';

// 1. Ambil daftar semua fakultas untuk dropdown filter
$sql_fakultas = "SELECT id_fakultas, nama_fakultas FROM fakultas ORDER BY nama_fakultas ASC";
$result_fakultas = mysqli_query($conn, $sql_fakultas);

// 2. Periksa apakah pengguna sudah memilih fakultas dari URL (method GET)
$selected_fakultas_id = $_GET['id_fakultas'] ?? null;

$dosen_list = [];
$matakuliah_list = [];

// 3. Jika fakultas SUDAH dipilih, jalankan query untuk mengambil data dosen dan matkul
if ($selected_fakultas_id) {
    // Query untuk mengambil dosen berdasarkan fakultas yang dipilih
    $sql_dosen = "SELECT d.nidn, d.nama_dosen 
                  FROM dosen d 
                  JOIN prodi p ON d.id_prodi = p.id_prodi 
                  WHERE p.id_fakultas = ? 
                  ORDER BY d.nama_dosen ASC";
    $stmt_dosen = mysqli_prepare($conn, $sql_dosen);
    mysqli_stmt_bind_param($stmt_dosen, "s", $selected_fakultas_id);
    mysqli_stmt_execute($stmt_dosen);
    $result_dosen = mysqli_stmt_get_result($stmt_dosen);
    while($dosen = mysqli_fetch_assoc($result_dosen)) {
        $dosen_list[] = $dosen;
    }
    mysqli_stmt_close($stmt_dosen);

    // Query untuk mengambil matakuliah berdasarkan fakultas yang dipilih
    $sql_matakuliah = "SELECT mk.kode_mk, mk.nama_mk, mk.sks 
                       FROM matakuliah mk 
                       JOIN prodi p ON mk.id_prodi = p.id_prodi 
                       WHERE p.id_fakultas = ? 
                       ORDER BY mk.nama_mk ASC";
    $stmt_matakuliah = mysqli_prepare($conn, $sql_matakuliah);
    mysqli_stmt_bind_param($stmt_matakuliah, "s", $selected_fakultas_id);
    mysqli_stmt_execute($stmt_matakuliah);
    $result_matakuliah = mysqli_stmt_get_result($stmt_matakuliah);
    while($mk = mysqli_fetch_assoc($result_matakuliah)) {
        $matakuliah_list[] = $mk;
    }
    mysqli_stmt_close($stmt_matakuliah);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugaskan Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h1 class="mb-0">Form Penugasan Mengajar</h1>
            </div>
            <div class="card-body">
                
                <form action="assign_courses_form.php" method="GET" class="mb-4 p-3 border rounded bg-light">
                    <div class="mb-2">
                        <label for="id_fakultas" class="form-label fw-bold">Langkah 1: Pilih Fakultas untuk Memfilter Data</label>
                        <select id="id_fakultas" name="id_fakultas" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Pilih Fakultas --</option>
                            <?php while($fakultas = mysqli_fetch_assoc($result_fakultas)): ?>
                                <option value="<?= htmlspecialchars($fakultas['id_fakultas']) ?>" <?= ($selected_fakultas_id == $fakultas['id_fakultas']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($fakultas['nama_fakultas']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                </form>

                <hr>

                <?php if ($selected_fakultas_id): ?>
                    <p class="fw-bold">Langkah 2: Isi Detail Penugasan</p>
                    <form action="handle_assign_course.php" method="post">
                        
                        <div class="mb-3">
                            <label for="nidn" class="form-label">Pilih Dosen:</label>
                            <select id="nidn" name="nidn" class="form-select select2" required>
                                <option value="">-- Pilih Dosen --</option>
                                <?php foreach($dosen_list as $dosen): ?>
                                    <option value="<?= htmlspecialchars($dosen['nidn']) ?>"><?= htmlspecialchars($dosen['nama_dosen']) ?> (<?= htmlspecialchars($dosen['nidn']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kode_mk" class="form-label">Pilih Mata Kuliah:</label>
                            <select id="kode_mk" name="kode_mk" class="form-select select2" required>
                                <option value="">-- Pilih Mata Kuliah --</option>
                                <?php foreach($matakuliah_list as $mk): ?>
                                    <option value="<?= htmlspecialchars($mk['kode_mk']) ?>"><?= htmlspecialchars($mk['nama_mk']) ?> (SKS: <?= htmlspecialchars($mk['sks']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik:</label>
                            <input type="text" id="tahun_akademik" name="tahun_akademik" class="form-control" placeholder="Contoh: 2024/2025" required>
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester:</label>
                            <select id="semester" name="semester" class="form-select" required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Simpan Penugasan</button>
                    </form>
                <?php else: ?>
                    <div class="text-center text-muted p-4">
                        <p>Silakan pilih fakultas terlebih dahulu untuk menampilkan form penugasan.</p>
                    </div>
                <?php endif; ?>

                <a href="../index.php" class="btn btn-secondary w-100 mt-2">Kembali ke Halaman Utama</a>

            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>