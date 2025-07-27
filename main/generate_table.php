<?php
require_once 'config_db.php'; // Koneksi DB diperlukan untuk mengambil nama dosen berdasarkan NIDN

// Ambil data dari POST
$dosen_nidn_terpilih = $_POST['dosen_nidn'] ?? [];

$form_data_sk = [
    'id_prodi'            => $_POST['id_prodi'] ?? '', // id_prodi yang sebenarnya
    'nama_prodi_display'  => $_POST['nama_prodi_display'] ?? '',
    'nama_fakultas_display'=> $_POST['nama_fakultas_display'] ?? '',
    'tglsr'               => $_POST['tanggal_terformat'] ?? '',
    'tglhjr'              => $_POST['tanggal_hijriah'] ?? '',
    'nomor_agenda'        => $_POST['nomor_agenda'] ?? '',
    'perihal'             => $_POST['perihal'] ?? '',
    'tahun_akademik'      => $_POST['tahun_akademik'] ?? '',
    'semester'            => $_POST['semester'] ?? '',
    'dekan_fakultas'      => $_POST['dekan_fakultas'] ?? '',
    'ka_prodi'            => $_POST['ka_prodi'] ?? '',
    'perihal1'            => $_POST['perihal1'] ?? '',
    'MP'                   => $_POST['perihal2'] ?? '',
    'perihal3'            => $_POST['perihal3'] ?? '',
    'perihal4'            => $_POST['perihal4'] ?? '',
    'perihal5'            => $_POST['perihal5'] ?? '',
    'perihal6'            => $_POST['perihal6'] ?? ''
];

$detail_dosen_terpilih = [];
if (!empty($dosen_nidn_terpilih)) {
    // Buat placeholder untuk query IN
    $placeholders = implode(',', array_fill(0, count($dosen_nidn_terpilih), '?'));
    $types = str_repeat('s', count($dosen_nidn_terpilih));

    $sql_get_dosen = "SELECT nidn, nama_dosen FROM dosen WHERE nidn IN ($placeholders) ORDER BY nama_dosen ASC";
    $stmt_get_dosen = mysqli_prepare($conn, $sql_get_dosen);
    mysqli_stmt_bind_param($stmt_get_dosen, $types, ...$dosen_nidn_terpilih); // Spread operator untuk NIDN
    mysqli_stmt_execute($stmt_get_dosen);
    $result_get_dosen = mysqli_stmt_get_result($stmt_get_dosen);
    while ($row = mysqli_fetch_assoc($result_get_dosen)) {
        $detail_dosen_terpilih[] = $row;
    }
    mysqli_stmt_close($stmt_get_dosen);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Dosen untuk SK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h1 class="text-center mb-0">Preview Dosen Terpilih untuk SK</h1>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <p><strong>Program Studi:</strong> <?= htmlspecialchars($form_data_sk['nama_prodi_display']) ?></p>
                <p><strong>Fakultas:</strong> <?= htmlspecialchars($form_data_sk['nama_fakultas_display']) ?></p>
                <p><strong>Tahun Akademik:</strong> <?= htmlspecialchars($form_data_sk['tahun_akademik']) ?>, <strong>Semester:</strong> <?= htmlspecialchars($form_data_sk['semester']) ?></p>
            </div>

            <?php if (!empty($detail_dosen_terpilih)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>Nama Dosen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail_dosen_terpilih as $index => $dosen): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($dosen['nidn']) ?></td>
                                <td><?= htmlspecialchars($dosen['nama_dosen']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <form action="buatsurat/preview.php" method="post" target="_blank"> <?php foreach ($dosen_nidn_terpilih as $nidn): ?>
                        <input type="hidden" name="final_dosen_nidn[]" value="<?= htmlspecialchars($nidn) ?>">
                    <?php endforeach; ?>

                    <?php foreach ($form_data_sk as $key => $value): ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>">
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-success w-100 mt-3">Buat SK Mengajar</button>
                </form>
            <?php else: ?>
                <div class="alert alert-danger text-center">Tidak ada dosen yang dipilih atau data dosen tidak ditemukan.</div>
            <?php endif; ?>
            <a href="process_additional_data.php" onclick="window.history.back(); return false;" class="btn btn-secondary w-100 mt-3">Kembali Pilih Dosen</a>
        </div>
    </div>
</div>
<?php mysqli_close($conn); // Tutup koneksi ?>
</body>
</html>