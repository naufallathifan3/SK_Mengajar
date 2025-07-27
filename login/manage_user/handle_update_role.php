<?php
session_start();
require_once '../../main/config_db.php';

// Gatekeeper: Pastikan hanya admin yang bisa menjalankan skrip ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses tidak sah.");
}

// Pastikan ini adalah request POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id_to_update = $_POST['user_id'] ?? null;
    $new_role = $_POST['new_role'] ?? '';

    // Validasi: Pastikan data yang diterima valid
    if (empty($user_id_to_update) || !in_array($new_role, ['admin', 'operator'])) {
        header('Location: manage_users.php?error=Data tidak valid.');
        exit();
    }

    // Validasi Keamanan: Admin tidak boleh mengubah role dirinya sendiri
    if ($user_id_to_update == $_SESSION['user_id']) {
        header('Location: manage_users.php?error=Anda tidak dapat mengubah role Anda sendiri.');
        exit();
    }

    // Siapkan dan eksekusi query UPDATE
    $sql = "UPDATE user SET role = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $new_role, $user_id_to_update);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: manage_users.php?status=success');
        exit();
    } else {
        header('Location: manage_users.php?error=Gagal memperbarui database.');
        exit();
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    // Jika bukan metode POST, redirect
    header('Location: manage_users.php');
    exit();
}
?>