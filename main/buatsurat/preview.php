<?php
require_once '../config_db.php';
// Ambil NIDN dosen yang dipilih
$final_dosen_nidn = $_POST['final_dosen_nidn'] ?? [];

// Ambil semua data SK lainnya
$form_data = [];
foreach ($_POST as $key => $value) {
    if ($key !== 'final_dosen_nidn' && !is_array($value)) {
        $form_data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

// SIAPKAN DATA UNTUK TABEL FINAL
$data_final_dosen = [];

if (!empty($final_dosen_nidn)) {
    // LANGKAH 1: Ambil nama SEMUA dosen yang dipilih agar tidak ada yang hilang
    $placeholders = implode(',', array_fill(0, count($final_dosen_nidn), '?'));
    $types = str_repeat('s', count($final_dosen_nidn));

    $sql_all_dosen = "SELECT nidn, nama_dosen FROM dosen WHERE nidn IN ($placeholders) ORDER BY nama_dosen ASC";
    $stmt_all = mysqli_prepare($conn, $sql_all_dosen);
    mysqli_stmt_bind_param($stmt_all, $types, ...$final_dosen_nidn);
    mysqli_stmt_execute($stmt_all);
    $result_all = mysqli_stmt_get_result($stmt_all);

    // Inisialisasi semua dosen terpilih dengan daftar matakuliah kosong
    while ($row = mysqli_fetch_assoc($result_all)) {
        $data_final_dosen[$row['nidn']] = [
            'nama_dosen' => $row['nama_dosen'],
            'matakuliah' => []
        ];
    }
    mysqli_stmt_close($stmt_all);

    // LANGKAH 2: Cari data mengajar di database HANYA untuk dosen yang punya jadwal
    $sql_mengajar = "SELECT d.nidn, mk.nama_mk, mk.sks
                     FROM mengajar m
                     JOIN dosen d ON m.nidn = d.nidn
                     JOIN matakuliah mk ON m.kode_mk = mk.kode_mk
                     WHERE m.nidn IN ($placeholders) AND m.id_prodi = ? AND m.tahun_akademik = ? AND m.semester = ?
                     ORDER BY mk.nama_mk ASC";

    $types_mengajar = $types . 'sss';
    $params_mengajar = array_merge($final_dosen_nidn, [$form_data['id_prodi'], $form_data['tahun_akademik'], $form_data['semester']]);

    $stmt_mengajar = mysqli_prepare($conn, $sql_mengajar);
    mysqli_stmt_bind_param($stmt_mengajar, $types_mengajar, ...$params_mengajar);
    mysqli_stmt_execute($stmt_mengajar);
    $result_mengajar = mysqli_stmt_get_result($stmt_mengajar);

    // LANGKAH 3: Masukkan data matakuliah ke dosen yang sesuai
    while ($row_mengajar = mysqli_fetch_assoc($result_mengajar)) {
        $data_final_dosen[$row_mengajar['nidn']]['matakuliah'][] = [
            'nama_mk' => $row_mengajar['nama_mk'],
            'sks' => $row_mengajar['sks']
        ];
    }
    mysqli_stmt_close($stmt_mengajar);
}
if(isset($conn)) { mysqli_close($conn); }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview SK Mengajar</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* CSS untuk layout baru (sidebar dan area dokumen) */
        body {
            margin: 0; /* Hapus margin default body */
            display: flex; /* Gunakan flexbox untuk layout utama */
            min-height: 100vh; /* Pastikan body mengambil tinggi penuh viewport */
            font-family: Arial, sans-serif; /* Font default untuk UI */
        }
        .sidebar {
            width: 250px; /* Lebar sidebar */
            background-color: #f0f0f0; /* Warna latar sidebar */
            padding: 20px;
            box-sizing: border-box; /* Pastikan padding termasuk dalam lebar */
            flex-shrink: 0; /* Sidebar tidak mengecil */
            border-right: 1px solid #ddd; /* Garis pemisah */
        }
        .sidebar h2 {
            font-size: 1.2em;
            margin-top: 0;
            color: #333;
            text-align: center;
        }
        .sidebar button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #007bff; /* Warna tombol */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            text-transform: uppercase;
            font-weight: bold;
        }
        .sidebar button:hover {
            background-color: #0056b3;
        }
        .main-content-wrapper {
            flex-grow: 1; /* Konten utama mengambil sisa ruang */
            padding: 20px; /* Padding di sekitar konten dokumen */
            box-sizing: border-box;
            background-color: #f8f8f8; /* Latar abu-abu muda untuk area di sekitar dokumen */
            display: flex; /* Untuk menengahkan konten SK */
            justify-content: center; /* Horizontally center */
            align-items: flex-start; /* Align to top */
            overflow-y: auto; /* Aktifkan scroll jika dokumen terlalu panjang */
        }
        .document-container {
            width: 210mm; /* Lebar A4 */
            /* min-height: 297mm; */ /* Hapus min-height agar tidak terpotong jika dokumen panjang */
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Efek bayangan seperti kertas */
            padding: 20px 30px; /* Padding di dalam dokumen SK */
            box-sizing: border-box;
            margin-bottom: 20px; /* Spasi di bawah dokumen jika ada banyak halaman */
        }

        /* Override style.css body margin for the document container */
        .document-container body {
            margin: 0; /* Pastikan tidak ada margin tambahan di dalam container dokumen */
        }

        /* Pastikan page-break bekerja untuk dokumen di dalam container */
        .document-container .page-break {
            page-break-before: always;
            break-before: page;
        }

        /* Styling untuk kondisi cetak */
        @media print {
            body {
                display: block; /* Nonaktifkan flex saat mencetak */
                margin: 0;
            }
            .sidebar {
                display: none; /* Sembunyikan sidebar saat mencetak */
            }
            .main-content-wrapper {
                padding: 0;
                width: 100%;
                display: block;
            }
            .document-container {
                width: 100%;
                min-height: auto;
                box-shadow: none;
                padding: 0;
                margin: 0;
            }
            /* Pastikan page breaks bekerja seperti yang diinginkan untuk pencetakan */
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Preview Cetak SK</h2>
        <button onclick="window.print()">CETAK SK</button>
    </div>

    <div class="main-content-wrapper">
        <div class="document-container">
            <?php include 'kop.php'; ?>
            <?php include 'menimbang.php'; ?>

            <div class="page-break"></div>
            <?php include 'kop.php'; ?>
            <?php include 'memutuskan.php'; ?>

            <div class="page-break"></div>
            <?php include 'kop.php'; ?>
            <?php include 'lampiran_dosen.php'; ?>
        </div>
    </div>

</body>
</html>