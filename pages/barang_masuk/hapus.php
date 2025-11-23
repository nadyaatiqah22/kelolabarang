<?php
include "../../config/config.php";
cek_login();

// Pastikan ada ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil data barang_masuk berdasarkan ID
$bm = query("SELECT * FROM barang_masuk WHERE id = $id");
if (!$bm) {
    header("Location: index.php");
    exit;
}

$bm = $bm[0];

// Ambil ID barang & jumlah masuk
$barang_id = $bm['barang_id'];
$jumlah_masuk = $bm['jumlah'];

// Kembalikan stok barang
$update_stok = mysqli_query($conn, "
    UPDATE barang 
    SET stok = stok - $jumlah_masuk 
    WHERE id = $barang_id
");

// Hapus data barang_masuk
$hapus = mysqli_query($conn, "DELETE FROM barang_masuk WHERE id = $id");

if ($hapus) {
    echo "<script>
            alert('Data berhasil dihapus & stok dikurangi kembali.');
            window.location.href = 'index.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus data.');
            window.location.href = 'index.php';
          </script>";
}

?>
