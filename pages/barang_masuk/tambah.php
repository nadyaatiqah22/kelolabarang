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



<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-5">Tambah Barang Masuk</h1>

    <form method="POST">

        <!-- PILIH BARANG -->
        <label class="block mb-2 font-medium">Nama Barang</label>
        <select name="barang_id" required class="w-full border px-3 py-2 rounded mb-4">
            <option value="">-- Pilih Barang --</option>
            <?php foreach ($barang as $b) : ?>
                <option value="<?= $b['id']; ?>">
                    <?= $b['nama_barang']; ?> (Stok: <?= $b['stok']; ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <!-- JUMLAH -->
        <label class="block mb-2 font-medium">Jumlah Masuk</label>
        <input type="number" name="jumlah" min="1" required
               class="w-full border px-3 py-2 rounded mb-4">

        <!-- TANGGAL -->
        <label class="block mb-2 font-medium">Tanggal</label>
        <input type="date" name="tanggal" required
               class="w-full border px-3 py-2 rounded mb-4">

        <!-- KETERANGAN -->
        <label class="block mb-2 font-medium">Keterangan</label>
        <textarea name="keterangan" class="w-full border px-3 py-2 rounded mb-4"
                  placeholder="Opsional..."></textarea>

        <button type="submit" name="simpan"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan
        </button>

        <a href="index.php" 
           class="ml-2 text-gray-700 hover:underline">
            Batal
        </a>
    </form>
</div>

<?php include "../../templates/footer.php"; ?>
