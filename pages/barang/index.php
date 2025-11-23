<?php
include "../../config/config.php";
cek_login();
include "../../templates/header.php";

// Ambil data barang dari database
$data = query("SELECT * FROM barang ORDER BY id DESC");
?>



<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-blue-800">Data Barang</h1>

    <a href="tambah.php" 
       class="bg-gradient-to-r from-blue-500 to-blue-500 text-white px-4 py-2 rounded-2xl shadow hover:from-blue-600 hover:to-green-600 transition">
        + Tambah Barang
    </a>
</div>

<!-- TABEL DATA BARANG -->
<div class="bg-gradient-to-br from-blue-50 to-green-50 p-6 rounded-2xl shadow-lg">
    <table class="min-w-full table-auto border-collapse text-gray-800">
        <thead>
        <tr class="bg-gradient-to-r from-blue-200 to-green-200 text-gray-900">
            <th class="border px-4 py-2 text-left">No</th>
            <th class="border px-4 py-2 text-left">Kode</th>
            <th class="border px-4 py-2 text-left">Nama Barang</th>
            <th class="border px-4 py-2 text-left">Kategori</th>
            <th class="border px-4 py-2 text-left">Stok</th>
            <th class="border px-4 py-2 text-left">Aksi</th>
        </tr>
        </thead>

        <tbody>
        <?php $no = 1; foreach ($data as $row) : ?>
            <tr class="hover:bg-blue-50 transition">
                <td class="border px-4 py-2"><?= $no++; ?></td>
                <td class="border px-4 py-2 font-semibold"><?= $row['kode_barang']; ?></td>
                <td class="border px-4 py-2"><?= $row['nama_barang']; ?></td>
                <td class="border px-4 py-2"><?= $row['kategori']; ?></td>
                <td class="border px-4 py-2 font-bold text-teal-700"><?= $row['stok']; ?></td>

                <td class="border px-4 py-2 flex gap-2">
                    <a href="edit.php?id=<?= $row['id']; ?>"
                       class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 shadow transition">
                        Edit
                    </a>

                    <a href="hapus.php?id=<?= $row['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus barang ini?');"
                       class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 shadow transition">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include "../../templates/footer.php"; ?>
