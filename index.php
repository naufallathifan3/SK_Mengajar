<?php
session_start(); // Mulai atau lanjutkan session yang sudah ada

// Jika tidak ada session user_id (artinya belum login), redirect ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: login/login.php'); 
    exit(); // Pastikan tidak ada kode di bawahnya yang dieksekusi
}

// Path ke config_db.php disesuaikan dengan nama folder 'Main'
require_once 'Main/config_db.php'; 

// Query untuk mengambil daftar prodi dan fakultas
$prodi_list = [];
$sql_prodi = "SELECT p.id_prodi, p.nama_prodi, p.jenjang, f.nama_fakultas
              FROM prodi p
              JOIN fakultas f ON p.id_fakultas = f.id_fakultas
              ORDER BY f.id_fakultas, p.nama_prodi";
$result_prodi = mysqli_query($conn, $sql_prodi);

if ($result_prodi) {
    while ($row = mysqli_fetch_assoc($result_prodi)) {
        $prodi_list[$row['nama_fakultas']][] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIM Akademik - UNISSULA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-top { background-color: #2e7d32; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; color: white; }
        .navbar-top img { height: 60px; margin-right: 10px; }
        .navbar-top .title { font-size: 18px; font-weight: bold; }
        .navbar-top .subtitle { font-size: 16px; }
        .navbar-bottom { background-color: #d9d9d9; padding: 5px 20px; }
        .navbar-bottom .nav-link { color: black !important; font-weight: bold; }
    </style>
</head>
<body>
    <div class="navbar-top">
        <div class="d-flex align-items-center">
            <img src="pic/logo.png" alt="Logo Unissula"> 
            <div>
                <div class="title">SK-MENGAJAR</div>
                <div class="subtitle">Biro Administrasi Akademik-Universitas Islam Sultan Agung</div>
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle text-white" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Selamat datang, <strong><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? $_SESSION['username']) ?></strong>
                (<?= htmlspecialchars($_SESSION['role']) ?>)
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                <li><a class="dropdown-item" href="login/register.php">Registrasi User Baru</a></li>
                <li><a class="dropdown-item" href="login/manage_user/manage_users.php">Manajemen User</a></li> 
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="login/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="ManageMatkul/manage_matakuliah.php">Portal (Kelola Matkul)</a></li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Perkuliahan</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Main/perkuliahan.php">Lihat Jadwal Kuliah</a></li>
                            <?php if ($_SESSION['role'] == 'admin'): ?>
                            <li><a class="dropdown-item" href="assigncourse/assign_courses_form.php">Tugaskan Mata Kuliah ke Dosen</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>SK Mengajar Dosen</h1>
        
        <form action="Main/process_additional_data.php" method="post">
            <div class="mb-3">
                <label for="prodi" class="form-label">Pilih Program Studi:</label>
                <select id="prodi" name="prodi" class="form-select" required>
                    <option value="">Pilih Program Studi</option>
                    <?php foreach ($prodi_list as $nama_fakultas => $prodis_in_fakultas): ?>
                        <optgroup label="<?= htmlspecialchars($nama_fakultas) ?>">
                            <?php foreach ($prodis_in_fakultas as $prodi_detail): ?>
                                <option value="<?= htmlspecialchars($prodi_detail['id_prodi']) ?>">
                                    <?= htmlspecialchars($prodi_detail['nama_prodi']) ?> (<?= htmlspecialchars($prodi_detail['jenjang']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                <input type="date" id="tanggal_surat" name="tanggal_surat_asli" class="form-control" onchange="formatTanggalTampilan()" required>
                <p class="mt-2">Tanggal Masehi: <span id="tanggal_terformat"></span></p>
                <input type="hidden" name="tanggal_terformat" id="hidden_input_tanggal_terformat">
                <p>Tanggal Hijriah: <span id="tanggal_hijriah_display"></span></p>
                <input type="hidden" name="tanggal_hijriah" id="hidden_input_tanggal_hijriah">
            </div>

            <script>
            function formatTanggalTampilan() {
                const inputTanggalValue = document.getElementById('tanggal_surat').value;
                const spanDisplayMasehi = document.getElementById('tanggal_terformat');
                const hiddenInputMasehi = document.getElementById('hidden_input_tanggal_terformat');
                const spanDisplayHijriah = document.getElementById('tanggal_hijriah_display');
                const hiddenInputHijriah = document.getElementById('hidden_input_tanggal_hijriah');
                const hijriMonthsIndonesia = ["Muharram", "Safar", "Rabiul Awal", "Rabiul Akhir", "Jumadil Awal", "Jumadil Akhir", "Rajab", "Sya'ban", "Ramadhan", "Syawwal", "Zulkaidah", "Zulhijah"];

                if (inputTanggalValue) {
                    const [tahun, bulan, tanggal] = inputTanggalValue.split('-');
                    const tanggalObj = new Date(tahun, parseInt(bulan) - 1, parseInt(tanggal));
                    const optionsMasehi = { day: '2-digit', month: 'long', year: 'numeric' };
                    const tanggalLatinMasehi = tanggalObj.toLocaleDateString('id-ID', optionsMasehi);
                    spanDisplayMasehi.innerText = tanggalLatinMasehi;
                    hiddenInputMasehi.value = tanggalLatinMasehi;
                    try {
                        const hijriDay = new Intl.DateTimeFormat('en-US-u-ca-islamic-nu-latn', { day: 'numeric' }).format(tanggalObj);
                        const hijriMonthNumber = parseInt(new Intl.DateTimeFormat('en-US-u-ca-islamic-nu-latn', { month: 'numeric' }).format(tanggalObj));
                        let hijriYear = new Intl.DateTimeFormat('en-US-u-ca-islamic-nu-latn', { year: 'numeric' }).format(tanggalObj);
                        hijriYear = hijriYear.replace(/\s*(AH|H)$/i, '');
                        const hijriMonthName = hijriMonthsIndonesia[hijriMonthNumber - 1];
                        const tanggalHijriahFormatted = `${hijriDay} ${hijriMonthName} ${hijriYear} H`;
                        spanDisplayHijriah.innerText = tanggalHijriahFormatted;
                        hiddenInputHijriah.value = tanggalHijriahFormatted;
                    } catch (e) {
                        spanDisplayHijriah.innerText = "Konversi Hijriah gagal";
                        hiddenInputHijriah.value = "";
                    }
                } else {
                    spanDisplayMasehi.innerText = ''; hiddenInputMasehi.value = '';
                    spanDisplayHijriah.innerText = ''; hiddenInputHijriah.value = '';
                }
            }
            </script>

            <div class="mb-3">
                <label for="nomor_agenda" class="form-label">Nomor Agenda Disposisi</label>
                <input type="text" id="nomor_agenda" name="nomor_agenda" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal SK (Contoh: Semester Gasal Tahun Akademik 2024/2025)</label>
                <input type="text" id="perihal" name="perihal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="tahun_akademik" class="form-label">Tahun Akademik (Contoh: 2024/2025)</label>
                <input type="text" id="tahun_akademik" name="tahun_akademik" class="form-control" placeholder="YYYY/YYYY" required>
            </div>

            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select id="semester" name="semester" class="form-select" required>
                    <option value="">Pilih Semester</option>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="perihal1" class="form-label">Menimbang - Lokasi Belajar Mengajar (Contoh: Program Studi Sarjana Teknik Informatika Fakultas Teknologi Industri Unissula)</label>
                <input type="text" id="perihal1" name="perihal1" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="perihal2" class="form-label">Memperhatikan (Surat Dekan)</label>
                <textarea id="perihal2" name="perihal2" class="form-control" rows="3" placeholder="Contoh: Surat Dekan Fakultas Teknologi Industri Nomor .../A.1/SA-FTI/X/2024 bertanggal ... tentang Permohonan SK Pengampu Mata Kuliah Semester Gasal TA.2024/2025" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="perihal3" class="form-label">Memutuskan Kesatu (Detail Program Studi dan Fakultas)</label>
                <input type="text" id="perihal3" name="perihal3" class="form-control" placeholder="Contoh: Modul Program Studi Sarjana Teknik Informatika Fakultas Teknologi Industri Unissula Semester Gasal Tahun Akademik 2024 / 2025" required>
            </div>

            <div class="mb-3">
                <label for="perihal5" class="form-label">Memutuskan Ketiga (Periode Tanggal Berlaku SK)</label>
                <input type="text" id="perihal5" name="perihal5" class="form-control" placeholder="Contoh: 1 September 2024 s.d. 28 Februari 2025" required>
            </div>

            <div class="mb-3">
                <label for="perihal6" class="form-label">Tentang (Untuk Lampiran)</label>
                <textarea id="perihal6" name="perihal6" class="form-control" rows="2" placeholder="Contoh: PENGANGKATAN DOSEN PENGAMPU MATA KULIAH / PENGAJAR MODUL PROGRAM STUDI SARJANA TEKNIK INFORMATIKA FAKULTAS TEKNOLOGI INDUSTRI UNISSULA SEMESTER GASAL TAHUN AKADEMIK 2024/2025" required></textarea>
            </div>

            <h5>Salinan Keputusan:</h5>
            <div class="mb-3">
                <label for="dekan_fakultas" class="form-label">Yth. Dekan Fakultas (Contoh: Dekan Fakultas Teknologi Industri)</label>
                <input type="text" id="dekan_fakultas" name="dekan_fakultas" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ka_prodi" class="form-label">Yth. Ka. Prodi (Contoh: Ka. Prodi Sarjana Teknik Informatika)</label>
                <input type="text" id="ka_prodi" name="ka_prodi" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Lanjutkan Pilih Dosen</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if(isset($conn)) { mysqli_close($conn); } // Tutup koneksi jika ada ?>
</body>
</html>