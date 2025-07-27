<?php
session_start();
// Path ke config_db.php diubah, keluar dari folder 'login', masuk ke 'Main'
require_once '../Main/config_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. TAMBAHKAN 'nama_lengkap' DI DALAM QUERY SELECT
    $sql = "SELECT id, username, password, nama_lengkap, role FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            // Login berhasil, simpan session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap']; // <-- 2. SIMPAN NAMA LENGKAP KE SESSION
            $_SESSION['role'] = $user['role'];

            // Redirect ke halaman utama di folder Main
            header('Location: ../index.php');
            exit();
        }
    }
    
    // Jika gagal, kembali ke login.php di folder yang sama
    header('Location: login.php?error=1');
    exit();

} else {
    header('Location: login.php');
    exit();
}
?>