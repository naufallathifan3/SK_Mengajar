<?php
// Konfigurasi Database
define('DB_SERVER', '127.0.0.1:3306'); // atau 'localhost'
define('DB_USERNAME', 'root');    // Ganti dengan username DB Anda
define('DB_PASSWORD', '');        // Ganti dengan password DB Anda
define('DB_NAME', 'db_mengajar');

// Membuat koneksi
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek koneksi
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Set character set
mysqli_set_charset($conn, "utf8mb4");
?>