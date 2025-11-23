<?php
include "../../config/config.php";
cek_login();
include "../../templates/header.php";

global $conn; // FIX WAJIB

// Cek apakah ada id yang dikirim
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data barang berdasarkan ID
$barang = query("SELECT * FROM barang WHERE id = $id");
if (!$barang) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}
$barang = $barang[0];

// Cek apakah tabel memiliki kolom keterangan
$has_keterangan = false;
$cek = mysqli_query($conn, "SHOW COLUMNS FROM barang LIKE 'keterangan'");
if ($cek && mysqli_num_rows($cek) > 0) {
    $has_keterangan = true;
}

// Jika form disubmit
if (isset($_POST['update'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $stok = intval($_POST['stok']);

    if ($has_keterangan) {
        $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
        $update_sql = "
            UPDATE barang 
            SET nama_barang = '$nama',
                kategori = '$kategori',
                stok = $stok,
                keterangan = '$keterangan'
            WHERE id = $id
        ";
    } else {
        $update_sql = "
            UPDATE barang 
            SET nama_barang = '$nama',
                kategori = '$kategori',
                stok = $stok
            WHERE id = $id
        ";
    }

    $update = mysqli_query($conn, $update_sql);

    if ($update) {
        echo "<script>
                alert('Data barang berhasil diperbarui!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>



<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-5">Edit Barang</h1>

    <form method="POST">

        <label class="block mb-2 font-medium">Nama Barang</label>
        <input type="text" name="nama_barang" required
               value="<?= htmlspecialchars($barang['nama_barang'], ENT_QUOTES); ?>"
               class="w-full border px-3 py-2 rounded mb-4">

        <label class="block mb-2 font-medium">Kategori</label>
        <input type="text" name="kategori"
               value="<?= htmlspecialchars($barang['kategori'] ?? '', ENT_QUOTES); ?>"
               class="w-full border px-3 py-2 rounded mb-4">

        <label class="block mb-2 font-medium">Stok</label>
        <input type="number" name="stok" min="0" required
               value="<?= intval($barang['stok']); ?>"
               class="w-full border px-3 py-2 rounded mb-4">

        <?php if ($has_keterangan): ?>
            <label class="block mb-2 font-medium">Keterangan</label>
            <textarea name="keterangan"
                      class="w-full border px-3 py-2 rounded mb-4"><?= htmlspecialchars($barang['keterangan'] ?? '', ENT_QUOTES); ?></textarea>
        <?php endif; ?>

        <button type="submit" name="update"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update
        </button>

        <a href="index.php" class="ml-3 text-gray-700 hover:underline">Batal</a>
    </form>
</div>

<?php include "../../templates/footer.php"; ?>
