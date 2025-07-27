<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: login.php?logout=1'); // <-- Sudah benar
exit();
?>