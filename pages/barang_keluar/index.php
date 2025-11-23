<?php
include "../../config/config.php";
cek_login();
include "../../templates/header.php";

// Ambil data barang keluar + join nama barang
$data = query("
    SELECT bk.*, b.nama_barang 
    FROM barang_keluar bk
    JOIN barang b ON bk.barang_id = b.id
    ORDER BY bk.id DESC
");
?>



<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-teal-800">Data Barang Keluar</h1>

    <a href="tambah.php" 
       class="bg-gradient-to-r from-teal-600 to-teal-600 text-white px-4 py-2 rounded-2xl shadow hover:from-green-600 hover:to-teal-500 transition">
        + Barang Keluar
    </a>
</div>

<!-- Tabel Barang Keluar -->
<div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg">
    <table class="min-w-full table-auto border-collapse text-gray-800">
        <thead>
        <tr class="bg-gradient-to-r from-green-200 to-teal-200 text-gray-900">
            <th class="border px-4 py-2 text-left">No</th>
            <th class="border px-4 py-2 text-left">Nama Barang</th>
            <th class="border px-4 py-2 text-left">Jumlah Keluar</th>
            <th class="border px-4 py-2 text-left">Tanggal Keluar</th>
            <th class="border px-4 py-2 text-left">Keterangan</th>
            <th class="border px-4 py-2 text-left">Aksi</th>
        </tr>
        </thead>

        <tbody>
        <?php $no = 1; foreach ($data as $row) : ?>
            <tr class="hover:bg-green-50 transition">
                <td class="border px-4 py-2"><?= $no++; ?></td>
                <td class="border px-4 py-2 font-semibold"><?= $row['nama_barang']; ?></td>
                <td class="border px-4 py-2 font-bold text-green-700"><?= $row['jumlah']; ?></td>
                <td class="border px-4 py-2"><?= $row['tanggal_keluar']; ?></td>
                <td class="border px-4 py-2"><?= $row['keterangan']; ?></td>
                <td class="border px-4 py-2">
                    <a href="hapus.php?id=<?= $row['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus data ini?');"
                       class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include "../../templates/footer.php"; ?>
