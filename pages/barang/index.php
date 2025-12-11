<?php
include "../../config/config.php";
cek_login();
include "../../templates/header.php";

// Ambil data barang dari database
$data = query("SELECT * FROM barang ORDER BY id DESC");
?>




<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-3">
    <h1 class="text-2xl font-bold text-blue-800 text-center sm:text-left">
        Data Jenis Barang
    </h1>

    <a href="tambah.php" 
       class="bg-gradient-to-r from-blue-600 to-green-500 text-white px-5 py-2 rounded-2xl shadow
              text-center font-semibold hover:brightness-110 transition">
        + Tambah Barang
    </a>
</div>

<div class="mb-4">
    <input 
        type="text" 
        id="searchInput"
        placeholder="Cari barang..."
        class="w-full md:w-1/3 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300"
        onkeyup="searchTable()"
    >
</div>

<!-- WRAPPER UNTUK SCROLL MOBILE -->
<div class="bg-gradient-to-br from-blue-50 to-green-50 p-4 rounded-2xl shadow-lg overflow-x-auto">

    <table class="min-w-max w-full border-collapse text-gray-800 text-sm sm:text-base">
        <thead>
            <tr class="bg-gradient-to-r from-blue-200 to-green-200 text-gray-900">
                <th class="border px-3 py-2 text-left whitespace-nowrap">No</th>
                <th class="border px-3 py-2 text-left whitespace-nowrap">Kode</th>
                <th class="border px-3 py-2 text-left whitespace-nowrap">Nama Barang</th>
                <th class="border px-3 py-2 text-left whitespace-nowrap">Kategori</th>
                <th class="border px-3 py-2 text-left whitespace-nowrap">Stok</th>
                <th class="border px-3 py-2 text-left whitespace-nowrap text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php $no = 1; foreach ($data as $row) : ?>
            <tr class="hover:bg-blue-50 transition">
                <td class="border px-3 py-2"><?= $no++; ?></td>
                <td class="border px-3 py-2 font-semibold"><?= $row['kode_barang']; ?></td>
                <td class="border px-3 py-2"><?= $row['nama_barang']; ?></td>
                <td class="border px-3 py-2"><?= $row['kategori']; ?></td>
                <td class="border px-3 py-2 font-bold text-teal-700"><?= $row['stok']; ?></td>

                <td class="border px-3 py-2">
                    <div class="flex flex-col sm:flex-row gap-2 justify-center">

                        <!-- Edit -->
                        <a href="edit.php?id=<?= $row['id']; ?>"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow text-center transition">
                            Edit
                        </a>

                        <!-- Hapus -->
                        <a href="hapus.php?id=<?= $row['id']; ?>"
                           onclick="return confirm('Yakin ingin menghapus barang ini?');"
                           class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow text-center transition">
                            Hapus
                        </a>

                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php include "../../templates/footer.php"; ?>
