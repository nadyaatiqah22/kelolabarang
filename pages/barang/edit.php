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


<div class="max-w-xl mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-xl">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center sm:text-left">
        Edit Barang
    </h1>

    <form method="POST" class="space-y-4">

        <!-- Nama Barang -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Nama Barang</label>
            <input type="text" name="nama_barang" required
                   value="<?= htmlspecialchars($barang['nama_barang'], ENT_QUOTES); ?>"
                   class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
        </div>

        <!-- Kategori -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Kategori</label>
            <input type="text" name="kategori"
                   value="<?= htmlspecialchars($barang['kategori'] ?? '', ENT_QUOTES); ?>"
                   class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                   placeholder="Opsional">
        </div>

        <!-- Stok -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Stok</label>
            <input type="number" name="stok" min="0" required
                   value="<?= intval($barang['stok']); ?>"
                   class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
        </div>

        <!-- Keterangan (opsional) -->
        <?php if ($has_keterangan): ?>
        <div>
            <label class="block mb-2 font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan"
                      class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                      placeholder="Opsional"><?= htmlspecialchars($barang['keterangan'] ?? '', ENT_QUOTES); ?></textarea>
        </div>
        <?php endif; ?>

        <!-- Tombol aksi -->
        <div class="flex flex-col sm:flex-row gap-3 pt-3">
            <button type="submit" name="update"
                    class="bg-gradient-to-r from-blue-500 to-teal-400 hover:from-teal-400 hover:to-blue-500
                           text-white px-5 py-2 rounded-2xl shadow-lg font-semibold transition-all w-full sm:w-auto text-center">
                Update
            </button>

            <a href="index.php"
               class="text-gray-700 px-5 py-2 rounded-2xl border border-gray-300 hover:bg-gray-100 text-center w-full sm:w-auto transition">
                Batal
            </a>
        </div>
    </form>
</div>

<?php include "../../templates/footer.php"; ?>
