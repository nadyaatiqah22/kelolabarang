<?php
session_start();

// Jika belum login → pindah ke login
if (!isset($_SESSION['admin'])) {
    header("Location: auth/login.php");
    exit;
}

// Jika sudah login → masuk dashboard
header("Location: pages/dashboard.php");
exit;
?>