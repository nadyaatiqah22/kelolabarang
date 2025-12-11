<?php
include "../../config/config.php";
cek_login();
include "../../templates/header.php";

// Ambil semua barang
$barang = query("SELECT * FROM barang ORDER BY nama_barang ASC");

// Jika form submit
if (isset($_POST['simpan'])) {
    $barang_id = $_POST['barang_id'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    // Simpan ke tabel barang_masuk
    $insert = mysqli_query($conn, "
        INSERT INTO barang_masuk (barang_id, jumlah, tanggal_masuk, keterangan)
        VALUES ('$barang_id', '$jumlah', '$tanggal', '$keterangan')
    ");

    if ($insert) {
        // Update stok barang
        mysqli_query($conn, "
            UPDATE barang SET stok = stok + $jumlah WHERE id = $barang_id
        ");

        echo "<script>
                alert('Barang masuk berhasil ditambahkan!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan data.');
              </script>";
    }
}
?>



<div class="flex flex-col items-center py-6">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">
        Tambah Barang Masuk
    </h1>

    <div class="w-full max-w-xl bg-white p-6 sm:p-8 rounded-2xl shadow-lg border border-gray-200">
        <form method="POST" class="space-y-5">

            <!-- Pilih Barang -->
            <div>
                <label class="block mb-2 font-medium text-gray-700">Nama Barang</label>
                <select id="selectBarang" name="barang_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2
                               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
                    <option value="">-- Pilih Barang --</option>
                    <?php foreach ($barang as $b) : ?>
                        <option value="<?= $b['id']; ?>">
                            <?= $b['nama_barang']; ?> (Stok: <?= $b['stok']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Jumlah -->
            <div>
                <label class="block font-medium mb-1 text-gray-700">Jumlah Masuk</label>
                <input type="number" name="jumlah" min="1" required
                       class="w-full border border-gray-300 px-3 py-2 rounded-lg
                              focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block font-medium mb-1 text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" required
                       class="w-full border border-gray-300 px-3 py-2 rounded-lg
                              focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block font-medium mb-1 text-gray-700">Keterangan</label>
                <textarea name="keterangan" rows="3"
                          class="w-full border border-gray-300 px-3 py-2 rounded-lg
                                 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                          placeholder="Opsional..."></textarea>
            </div>

            <!-- Tombol -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4 justify-center">
                <button type="submit" name="simpan"
                        class="bg-gradient-to-r from-blue-500 to-teal-400 hover:from-blue-400 hover:to-teal-500
                               text-white px-6 py-2 rounded-xl shadow-lg font-semibold transition-all duration-200">
                    Simpan
                </button>

                <a href="index.php"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-xl shadow font-semibold
                          transition-all duration-200 text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

<!-- Tom Select CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect("#selectBarang", {
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "-- Pilih Barang --",
        maxOptions: 50,
    });
</script>
