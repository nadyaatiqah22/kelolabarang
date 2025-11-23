<?php
include "../../config/config.php";
cek_login();
include "../../templates/header.php";

// Ambil data barang untuk dropdown
$barang = query("SELECT * FROM barang ORDER BY nama_barang ASC");

// Jika form disubmit
if (isset($_POST['simpan'])) {

    $barang_id  = $_POST['barang_id'];
    $jumlah     = $_POST['jumlah'];
    $tanggal    = $_POST['tanggal'];  // Ini dari input user
    $keterangan = $_POST['keterangan'];

    // Ambil stok barang
    $b = query("SELECT stok FROM barang WHERE id = $barang_id")[0];
    $stok = $b['stok'];

    // Cek stok cukup
    if ($jumlah > $stok) {
        $error = "Stok tidak mencukupi!";
    } else {
        // Kurangi stok
        mysqli_query($conn, "UPDATE barang SET stok = stok - $jumlah WHERE id = $barang_id");

        // Simpan barang keluar (perbaikan: ganti 'tanggal' → 'tanggal_keluar')
        mysqli_query($conn, "
            INSERT INTO barang_keluar (barang_id, jumlah, tanggal_keluar, keterangan)
            VALUES ('$barang_id', '$jumlah', '$tanggal', '$keterangan')
        ");

        header("Location: index.php");
        exit();
    }
}
?>



<h1 class="text-2xl font-bold mb-4">Tambah Barang Keluar</h1>

<div class="bg-white p-6 rounded shadow max-w-xl">

    <?php if (!empty($error)) : ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-4">

        <!-- Pilih Barang -->
        <div>
            <label class="block font-medium mb-1">Pilih Barang</label>
            <select name="barang_id" required
                    class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
                <option value="">-- Pilih --</option>
                <?php foreach ($barang as $b) : ?>
                    <option value="<?= $b['id']; ?>">
                        <?= $b['nama_barang']; ?> (Stok: <?= $b['stok']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Jumlah -->
        <div>
            <label class="block font-medium mb-1">Jumlah Keluar</label>
            <input type="number" name="jumlah" min="1" required
                   class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
        </div>

        <!-- Tanggal -->
        <div>
            <label class="block font-medium mb-1">Tanggal Keluar</label>
            <input type="date" name="tanggal" required
                   class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
        </div>

        <!-- Keterangan -->
        <div>
            <label class="block font-medium mb-1">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300"></textarea>
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
