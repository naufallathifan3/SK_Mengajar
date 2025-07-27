<?php
session_start();

// Gatekeeper: Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login/login.php');
    exit();
}

require_once 'config_db.php';

// === LANGKAH 1: PERSIAPAN DATA ===

// Ambil semua fakultas untuk dropdown pertama
$fakultas_list = mysqli_query($conn, "SELECT id_fakultas, nama_fakultas FROM fakultas ORDER BY nama_fakultas ASC");

// Ambil semua prodi dan kelompokkan berdasarkan id_fakultas untuk JavaScript
$prodi_by_fakultas = [];
$sql_prodi = "SELECT id_prodi, id_fakultas, nama_prodi, jenjang FROM prodi ORDER BY nama_prodi ASC";
$result_prodi = mysqli_query($conn, $sql_prodi);
while ($prodi = mysqli_fetch_assoc($result_prodi)) {
    $prodi_by_fakultas[$prodi['id_fakultas']][] = $prodi;
}

// Konversi data prodi ke format JSON agar bisa dibaca oleh JavaScript
$prodi_json = json_encode($prodi_by_fakultas);


// === LANGKAH 2: PROSES FILTER & PENGAMBILAN DATA JADWAL ===
$jadwal_mengajar = [];
$selected_prodi_id = $_GET['id_prodi'] ?? null; // Cek apakah ada prodi yang difilter dari URL

if ($selected_prodi_id) {
    $sql_jadwal = "SELECT 
                        m.id_mengajar, 
                        d.nama_dosen, 
                        mk.nama_mk 
                   FROM mengajar m
                   JOIN dosen d ON m.nidn = d.nidn
                   JOIN matakuliah mk ON m.kode_mk = mk.kode_mk
                   WHERE m.id_prodi = ?
                   ORDER BY d.nama_dosen, mk.nama_mk ASC";
    
    $stmt = mysqli_prepare($conn, $sql_jadwal);
    mysqli_stmt_bind_param($stmt, "s", $selected_prodi_id);
    mysqli_stmt_execute($stmt);
    $result_jadwal = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result_jadwal)) {
        $jadwal_mengajar[] = $row;
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Perkuliahan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="mb-0">Lihat Jadwal Kuliah</h1>
            </div>
            <div class="card-body">
                <form action="perkuliahan.php" method="GET" class="p-3 border rounded bg-light mb-4">
                    <p class="fw-bold">Filter Jadwal</p>
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <label for="id_fakultas" class="form-label">1. Pilih Fakultas</label>
                            <select id="id_fakultas" name="id_fakultas" class="form-select">
                                <option value="">-- Semua Fakultas --</option>
                                <?php
                                $current_fakultas_id = $_GET['id_fakultas'] ?? '';
                                mysqli_data_seek($fakultas_list, 0); // Reset pointer
                                while($fakultas = mysqli_fetch_assoc($fakultas_list)): ?>
                                    <option value="<?= htmlspecialchars($fakultas['id_fakultas']) ?>" <?= ($current_fakultas_id == $fakultas['id_fakultas']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($fakultas['nama_fakultas']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label for="id_prodi" class="form-label">2. Pilih Program Studi</label>
                            <select id="id_prodi" name="id_prodi" class="form-select" <?= !$current_fakultas_id ? 'disabled' : '' ?>>
                                <option value="">-- Pilih Prodi --</option>
                                </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end mb-2">
                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </div>
                    </div>
                </form>

                <h3 class="mt-4">Hasil Jadwal Mengajar</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Dosen</th>
                                <th>ID Mengajar</th>
                                <th>Mata Kuliah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jadwal_mengajar)): ?>
                                <?php foreach ($jadwal_mengajar as $index => $jadwal): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars($jadwal['nama_dosen']) ?></td>
                                        <td><?= htmlspecialchars($jadwal['id_mengajar']) ?></td>
                                        <td><?= htmlspecialchars($jadwal['nama_mk']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <?php if ($selected_prodi_id): ?>
                                            Tidak ada data jadwal mengajar ditemukan untuk prodi ini.
                                        <?php else: ?>
                                            Silakan pilih fakultas dan prodi, lalu tekan "Tampilkan" untuk melihat jadwal.
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <a href="../index.php" class="btn btn-secondary mt-3">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>

    <script>
        // Ambil data prodi dari PHP dan ubah menjadi objek JavaScript
        const prodiByFakultas = <?= $prodi_json ?>;
        const fakultasDropdown = document.getElementById('id_fakultas');
        const prodiDropdown = document.getElementById('id_prodi');
        const selectedProdiFromPHP = '<?= $selected_prodi_id ?? '' ?>';

        function updateProdiDropdown() {
            const selectedFakultas = fakultasDropdown.value;
            // Kosongkan dropdown prodi
            prodiDropdown.innerHTML = '<option value="">-- Pilih Prodi --</option>';
            prodiDropdown.disabled = true;

            if (selectedFakultas && prodiByFakultas[selectedFakultas]) {
                prodiDropdown.disabled = false;
                // Isi dengan prodi yang sesuai
                prodiByFakultas[selectedFakultas].forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi.id_prodi;
                    option.textContent = `${prodi.nama_prodi} (${prodi.jenjang})`;
                    // Jika prodi ini adalah prodi yang dipilih sebelumnya (saat halaman reload)
                    if (prodi.id_prodi === selectedProdiFromPHP) {
                        option.selected = true;
                    }
                    prodiDropdown.appendChild(option);
                });
            }
        }

        // Jalankan fungsi saat dropdown fakultas berubah
        fakultasDropdown.addEventListener('change', updateProdiDropdown);

        // Jalankan fungsi sekali saat halaman dimuat untuk mengisi prodi jika fakultas sudah terpilih (setelah reload)
        document.addEventListener('DOMContentLoaded', updateProdiDropdown);
    </script>
</body>
</html>