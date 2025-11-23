<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke halaman index.php root
header("Location: ../index.php");
exit;
?>
