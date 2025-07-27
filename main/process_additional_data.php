<?php
require_once 'config_db.php'; // Memuat koneksi database

$id_prodi_terpilih = isset($_POST['prodi']) ? mysqli_real_escape_string($conn, $_POST['prodi']) : '';

// Ambil semua data form lainnya dari halaman index.php
$form_data = [];
foreach ($_POST as $key => $value) {
    if ($key !== 'prodi') {
        $form_data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

$dosen_list_final = [];
$nama_prodi = '';
$nama_fakultas = '';
$error_message = '';

if (!empty($id_prodi_terpilih) && !empty($form_data['tahun_akademik']) && !empty($form_data['semester'])) {
    // Ambil info prodi dan fakultas
    $sql_info_prodi = "SELECT p.nama_prodi, f.nama_fakultas FROM prodi p JOIN fakultas f ON p.id_fakultas = f.id_fakultas WHERE p.id_prodi = ?";
    $stmt_info_prodi = mysqli_prepare($conn, $sql_info_prodi);
    mysqli_stmt_bind_param($stmt_info_prodi, "s", $id_prodi_terpilih);
    mysqli_stmt_execute($stmt_info_prodi);
    $result_info_prodi = mysqli_stmt_get_result($stmt_info_prodi);
    if ($row_info = mysqli_fetch_assoc($result_info_prodi)) {
        $nama_prodi = $row_info['nama_prodi'];
        $nama_fakultas = $row_info['nama_fakultas'];
    }
    mysqli_stmt_close($stmt_info_prodi);

    // 1. Ambil NIDN dosen yang tercatat di tabel 'mengajar' (punya jadwal)
    $nidn_dosen_pengajar = [];
    $sql_dosen_mengajar = "SELECT DISTINCT nidn FROM mengajar WHERE id_prodi = ? AND tahun_akademik = ? AND semester = ?";
    $stmt_dosen_mengajar = mysqli_prepare($conn, $sql_dosen_mengajar);
    mysqli_stmt_bind_param($stmt_dosen_mengajar, "sss", $id_prodi_terpilih, $form_data['tahun_akademik'], $form_data['semester']);
    mysqli_stmt_execute($stmt_dosen_mengajar);
    $result_dosen_mengajar = mysqli_stmt_get_result($stmt_dosen_mengajar);
    while ($row = mysqli_fetch_assoc($result_dosen_mengajar)) {
        $nidn_dosen_pengajar[] = $row['nidn'];
    }
    mysqli_stmt_close($stmt_dosen_mengajar);

    // 2. Ambil semua dosen homebase dari prodi tersebut
    $sql_dosen_homebase = "SELECT nidn, nama_dosen FROM dosen WHERE id_prodi = ? ORDER BY nama_dosen ASC";
    $stmt_dosen_homebase = mysqli_prepare($conn, $sql_dosen_homebase);
    mysqli_stmt_bind_param($stmt_dosen_homebase, "s", $id_prodi_terpilih);
    mysqli_stmt_execute($stmt_dosen_homebase);
    $result_dosen_homebase = mysqli_stmt_get_result($stmt_dosen_homebase);
    while ($row = mysqli_fetch_assoc($result_dosen_homebase)) {
        // Beri label/status pada setiap dosen
        $status = in_array($row['nidn'], $nidn_dosen_pengajar) ? 'pengajar' : 'homebase';
        $dosen_list_final[] = [
            'nidn' => $row['nidn'], 
            'nama_dosen' => $row['nama_dosen'], 
            'status' => $status
        ];
    }
    mysqli_stmt_close($stmt_dosen_homebase);

    if (empty($dosen_list_final)) {
        $error_message = "Tidak ada dosen yang terdata sebagai homebase di program studi ini.";
    }

} else {
    $error_message = "Informasi Program Studi, Tahun Akademik, atau Semester tidak lengkap.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center"><h1>Pilih Dosen</h1></div>
        <div class="card-body">
            <?php if (empty($error_message)): ?>
                <div class="mb-4">
                    <h2 class="text-primary">Program Studi: <?= htmlspecialchars($nama_prodi) ?></h2>
                    <p>Tahun Akademik: <?= htmlspecialchars($form_data['tahun_akademik']) ?>, Semester: <?= htmlspecialchars($form_data['semester']) ?></p>
                </div>

                <form action="generate_table.php" method="post">
                    <h4 class="text-success">Pilih Dosen yang akan dicantumkan di SK:</h4>
                    <div class="list-group mb-4">
                        <?php foreach ($dosen_list_final as $dosen_data): ?>
                            <label class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <input type="checkbox" name="dosen_nidn[]" value="<?= htmlspecialchars($dosen_data['nidn']) ?>" class="form-check-input me-2">
                                    <?= htmlspecialchars($dosen_data['nama_dosen']) ?>
                                </span>
                                <?php if ($dosen_data['status'] == 'pengajar'): ?>
                                    <span class="badge bg-success">Ada Jadwal</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Hanya Homebase</span>
                                <?php endif; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <?php foreach ($form_data as $key => $value): ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= $value ?>">
                    <?php endforeach; ?>
                    <input type="hidden" name="id_prodi" value="<?= htmlspecialchars($id_prodi_terpilih) ?>">
                    <input type="hidden" name="nama_prodi_display" value="<?= htmlspecialchars($nama_prodi) ?>">
                    <input type="hidden" name="nama_fakultas_display" value="<?= htmlspecialchars($nama_fakultas) ?>">

                    <button type="submit" class="btn btn-primary w-100">Lanjutkan ke Preview</button>
                </form>
            <?php else: ?>
                <div class="alert alert-danger"><p><?= $error_message ?></p></div>
            <?php endif; ?>
            <a href="../index.php" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
<?php if(isset($conn)) { mysqli_close($conn); } ?>
</body>
</html>