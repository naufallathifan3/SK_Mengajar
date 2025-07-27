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

$message = '';
$message_type = ''; // 'success' or 'danger'

// Pastikan data dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan amankan data dari form
    $nidn = $_POST['nidn'] ?? '';
    $kode_mk = $_POST['kode_mk'] ?? '';
    $tahun_akademik = $_POST['tahun_akademik'] ?? '';
    $semester = $_POST['semester'] ?? '';

    // Validasi dasar: pastikan semua field terisi
    if (!empty($nidn) && !empty($kode_mk) && !empty($tahun_akademik) && !empty($semester)) {
        
        // LANGKAH 1: Dapatkan id_prodi dan id_fakultas berdasarkan kode_mk yang dipilih
        $id_prodi = null;
        $id_fakultas = null;

        $sql_info = "SELECT mk.id_prodi, p.id_fakultas 
                     FROM matakuliah mk 
                     JOIN prodi p ON mk.id_prodi = p.id_prodi 
                     WHERE mk.kode_mk = ?";
        
        $stmt_info = mysqli_prepare($conn, $sql_info);
        mysqli_stmt_bind_param($stmt_info, "s", $kode_mk);
        mysqli_stmt_execute($stmt_info);
        $result_info = mysqli_stmt_get_result($stmt_info);
        
        if ($info = mysqli_fetch_assoc($result_info)) {
            $id_prodi = $info['id_prodi'];
            $id_fakultas = $info['id_fakultas'];
        }
        mysqli_stmt_close($stmt_info);

        // Jika info prodi dan fakultas ditemukan, lanjutkan proses
        if ($id_prodi && $id_fakultas) {
            
            // LANGKAH 2: Periksa apakah data yang sama sudah ada
            $sql_check = "SELECT id_mengajar FROM mengajar WHERE nidn = ? AND kode_mk = ? AND tahun_akademik = ? AND semester = ?";
            $stmt_check = mysqli_prepare($conn, $sql_check);
            mysqli_stmt_bind_param($stmt_check, "ssss", $nidn, $kode_mk, $tahun_akademik, $semester);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);

            if (mysqli_stmt_num_rows($stmt_check) > 0) {
                // Jika data sudah ada
                $message = "<strong>Gagal!</strong> Penugasan untuk dosen ini dengan mata kuliah yang sama di periode ini sudah ada.";
                $message_type = "danger";
            } else {
                // LANGKAH 3: Jika data belum ada, lakukan INSERT
                $sql_insert = "INSERT INTO mengajar (nidn, kode_mk, tahun_akademik, semester, id_prodi, id_fakultas) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($conn, $sql_insert);
                mysqli_stmt_bind_param($stmt_insert, "ssssss", $nidn, $kode_mk, $tahun_akademik, $semester, $id_prodi, $id_fakultas);

                if (mysqli_stmt_execute($stmt_insert)) {
                    $message = "<strong>Sukses!</strong> Penugasan berhasil disimpan ke database.";
                    $message_type = "success";
                } else {
                    $message = "<strong>Error!</strong> Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
                    $message_type = "danger";
                }
                mysqli_stmt_close($stmt_insert);
            }
            mysqli_stmt_close($stmt_check);

        } else {
             $message = "<strong>Gagal!</strong> Tidak dapat menemukan informasi Prodi dan Fakultas untuk Mata Kuliah yang dipilih. Periksa kembali data di tabel `matakuliah`.";
             $message_type = "danger";
        }

    } else {
        $message = "<strong>Gagal!</strong> Semua field harus diisi.";
        $message_type = "danger";
    }
} else {
    // Jika halaman diakses langsung, redirect ke form
    header("Location: assign_courses_form.php");
    exit();
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Penugasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-<?= $message_type ?>" role="alert">
            <h4 class="alert-heading"><?= ($message_type == 'success') ? 'Berhasil!' : 'Terjadi Kesalahan!' ?></h4>
            <p><?= $message ?></p>
            <hr>
            <a href="assign_courses_form.php" class="btn btn-<?= ($message_type == 'success') ? 'primary' : 'secondary' ?>">Kembali ke Form Penugasan</a>
        </div>
    </div>
</body>
</html>