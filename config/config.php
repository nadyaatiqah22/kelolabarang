<?php
// Wajib: mulai session agar login bisa digunakan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// -------------------------
// SETTING UMUM
// -------------------------
date_default_timezone_set('Asia/Jakarta'); // timezone lokal kamu

// -------------------------
// KONEKSI DATABASE
// -------------------------
$host = "localhost";
$user = "root";
$pass = "";
$db   = "inventaris";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// ALIAS untuk kompatibel dengan kode lain
$conn = $koneksi; // ← FIX PENTING

// -------------------------
// FUNGSI ANTI SQL INJECTION
// -------------------------
function esc($data) {
    global $koneksi;
    return mysqli_real_escape_string($koneksi, $data);
}

// -------------------------
// FUNGSI QUERY MUDAH
// -------------------------
function query($sql) {
    global $koneksi;
    $result = mysqli_query($koneksi, $sql);

    $rows = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function find($sql) {
    global $koneksi;
    $result = mysqli_query($koneksi, $sql);
    return mysqli_fetch_assoc($result);
}

// -------------------------
// CEK APAKAH ADMIN SUDAH LOGIN
// -------------------------
function cek_login() {
    if (!isset($_SESSION['admin'])) {
        header("Location: /kelolabarang/auth/login.php");
        exit();
    }
}

// -------------------------
// FLASH MESSAGE
// -------------------------
function set_flash($msg, $type = "success") {
    $_SESSION['flash'] = [
        'msg'  => $msg,
        'type' => $type
    ];
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return "<div class='alert alert-{$flash['type']}'>{$flash['msg']}</div>";
    }
    return "";
}

?>
