<?php
session_start();
session_destroy();  // Menghancurkan sesi pengguna
header("Location: index.php");  // Mengarahkan kembali ke halaman login
exit();
?>
