<?php
include "../../config/config.php";
cek_login();

// cek apakah ada id
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']); 

// CEK barang dipakai di barang_keluar
$cek_keluar = find("SELECT COUNT(*) AS total FROM barang_keluar WHERE barang_id = $id");
$cek_keluar = $cek_keluar['total'] ?? 0;

// CEK barang dipakai di barang_masuk
$cek_masuk = find("SELECT COUNT(*) AS total FROM barang_masuk WHERE barang_id = $id");
$cek_masuk = $cek_masuk['total'] ?? 0;

if ($cek_keluar > 0 || $cek_masuk > 0) {
    set_flash("❌ Barang tidak dapat dihapus karena sudah digunakan dalam transaksi!", "danger");
    header("Location: index.php");
    exit();
}

// lakukan hapus
$hapus = mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");

if ($hapus) {
    set_flash("✔ Barang berhasil dihapus!", "success");
} else {
    set_flash("❌ Gagal menghapus barang: " . mysqli_error($koneksi), "danger");
}

header("Location: index.php");
exit();
?>
