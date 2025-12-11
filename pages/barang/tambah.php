<?php
include "../../config/config.php";
cek_login();
include "../../templates/header.php";

// Jika form submit
if (isset($_POST['simpan'])) {
    $nama       = $_POST['nama_barang'];
    $kode       = $_POST['kode_barang'];
    $kategori   = $_POST['kategori'];
    $stok       = $_POST['stok'];

    // Validasi sederhana
    if (empty($nama) || empty($kode)) {
        $error = "Nama dan Kode Barang wajib diisi!";
    } else {
        $insert = mysqli_query($conn, "
            INSERT INTO barang (nama_barang, kode_barang, kategori, stok)
            VALUES ('$nama', '$kode', '$kategori', '$stok')
        ");

        if ($insert) {
            echo "<script>
                    alert('Barang berhasil ditambahkan!');
                    window.location.href='index.php';
                  </script>";
        } else {
            $error = "Gagal menambahkan barang.";
        }
    }
}
?>



<div class="max-w-xl mx-auto bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-8 rounded-2xl shadow-2xl border border-gray-700 mt-6">

    <h1 class="text-3xl font-bold mb-6 text-center bg-gradient-to-r from-blue-400 to-teal-300 bg-clip-text text-transparent tracking-wide drop-shadow">
        Tambah Barang
    </h1>

    <?php if (!empty($error)) : ?>
        <div class="bg-red-500/20 border border-red-400 text-red-300 p-3 rounded mb-4 text-sm">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">

        <!-- Kode Barang -->
        <div>
            <label class="block font-medium mb-1 text-gray-200">Kode Barang</label>
            <input type="text" name="kode_barang" required
                class="w-full bg-gray-800 border border-gray-700 text-gray-200 px-3 py-2 rounded-lg
                       focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none
                       transition shadow-inner">
        </div>

        <!-- Nama Barang -->
        <div>
            <label class="block font-medium mb-1 text-gray-200">Nama Barang</label>
            <input type="text" name="nama_barang" required
                class="w-full bg-gray-800 border border-gray-700 text-gray-200 px-3 py-2 rounded-lg
                       focus:ring-2 focus:ring-teal-400 focus:border-teal-400 outline-none
                       transition shadow-inner">
        </div>

        <!-- Kategori -->
        <div>
            <label class="block font-medium mb-1 text-gray-200">Kategori</label>
            <input type="text" name="kategori"
                class="w-full bg-gray-800 border border-gray-700 text-gray-200 px-3 py-2 rounded-lg
                       focus:ring-2 focus:ring-purple-400 focus:border-purple-400 outline-none
                       transition shadow-inner"
                placeholder="Opsional">
        </div>

        <!-- Stok awal -->
        <div>
            <label class="block font-medium mb-1 text-gray-200">Stok Awal</label>
            <input type="number" name="stok" min="0" value="0"
                class="w-full bg-gray-800 border border-gray-700 text-gray-200 px-3 py-2 rounded-lg
                       focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none
                       transition shadow-inner">
        </div>

        <!-- Tombol -->
        <div class="flex gap-4 pt-4 justify-center">

            <button type="submit" name="simpan"
                class="bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-500 hover:to-teal-400
                       text-white px-6 py-2 rounded-xl shadow-lg hover:shadow-blue-500/40
                       transition-all duration-200 font-semibold tracking-wide">
                Simpan
            </button>

            <a href="index.php"
                class="bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-500 hover:to-gray-400
                       text-white px-6 py-2 rounded-xl shadow-lg hover:shadow-gray-400/40
                       transition-all duration-200 font-semibold tracking-wide">
                Batal
            </a>
        </div>

    </form>
</div>

<?php include "../../templates/footer.php"; ?>
