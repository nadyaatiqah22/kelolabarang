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



<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-5">Tambah Barang</h1>

    <?php if (!empty($error)) : ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <!-- Kode Barang -->
        <div>
            <label class="block font-medium mb-1">Kode Barang</label>
            <input type="text" name="kode_barang" required
                   class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
        </div>

        <!-- Nama Barang -->
        <div>
            <label class="block font-medium mb-1">Nama Barang</label>
            <input type="text" name="nama_barang" required
                   class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
        </div>

        <!-- Kategori -->
        <div>
            <label class="block font-medium mb-1">Kategori</label>
            <input type="text" name="kategori"
                   class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300"
                   placeholder="Opsional">
        </div>

        <!-- Stok awal -->
        <div>
            <label class="block font-medium mb-1">Stok Awal</label>
            <input type="number" name="stok" min="0" value="0"
                   class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
        </div>

        <div class="flex gap-3 pt-3">
            <button type="submit" name="simpan"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan
            </button>

            <a href="index.php"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>

<?php include "../../templates/footer.php"; ?>
