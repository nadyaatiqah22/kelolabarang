<?php
include "../../config/config.php";
cek_login();

// cek apakah ada id
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Ambil data barang keluar berdasarkan id
$bk = query("SELECT * FROM barang_keluar WHERE id = $id")[0];

// Kembalikan stok barang
$barang_id = $bk['barang_id'];
$jumlah    = $bk['jumlah'];

mysqli_query($conn, "UPDATE barang SET stok = stok + $jumlah WHERE id = $barang_id");

// Hapus data barang keluar
mysqli_query($conn, "DELETE FROM barang_keluar WHERE id = $id");

// Redirect kembali
header("Location: index.php");
exit();
?>
