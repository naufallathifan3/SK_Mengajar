<?php
session_start();
require_once '../main/config_db.php';

// Gatekeeper: Hanya admin yang boleh menjalankan skrip ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses tidak sah.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validasi dasar
    if (empty($nama_lengkap) || empty($username) || empty($password) || empty($role)) {
        header('Location: register.php?error=Semua field wajib diisi.');
        exit();
    }

    // Cek apakah username sudah ada
    $sql_check = "SELECT id FROM user WHERE username = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        // Jika username sudah ada, kembali dengan pesan error
        header('Location: register.php?error=Username sudah digunakan. Silakan pilih username lain.');
        exit();
    }
    mysqli_stmt_close($stmt_check);

    // Jika username unik, lanjutkan proses
    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Siapkan dan eksekusi query INSERT
    $sql_insert = "INSERT INTO user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "ssss", $username, $hashed_password, $nama_lengkap, $role);

    if (mysqli_stmt_execute($stmt_insert)) {
        // Jika berhasil, kembali dengan pesan sukses
        header('Location: register.php?status=success');
        exit();
    } else {
        // Jika gagal, kembali dengan pesan error database
        header('Location: register.php?error=Gagal menyimpan ke database: ' . mysqli_error($conn));
        exit();
    }
    
    mysqli_stmt_close($stmt_insert);
    mysqli_close($conn);

} else {
    // Jika bukan metode POST, redirect
    header('Location: register.php');
    exit();
}
?>