<?php
include "../config/config.php";
cek_login();

// Ambil ringkasan
$total_barang = query("SELECT COUNT(*) AS total FROM barang")[0]['total'];
$total_masuk  = query("SELECT SUM(jumlah) AS total FROM barang_masuk")[0]['total'] ?? 0;
$total_keluar = query("SELECT SUM(jumlah) AS total FROM barang_keluar")[0]['total'] ?? 0;

// Ambil data terbaru (opsional)
$barang_terbaru = query("
    SELECT bm.*, b.nama_barang 
    FROM barang_masuk bm
    JOIN barang b ON bm.barang_id = b.id
    ORDER BY bm.id DESC 
    LIMIT 5
");

$barang_keluar_terbaru = query("
    SELECT bk.*, b.nama_barang 
    FROM barang_keluar bk
    JOIN barang b ON bk.barang_id = b.id
    ORDER BY bk.id DESC 
    LIMIT 5
");
?>


<?php include "../templates/header.php"; ?>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Dashboard Inventaris Barang</h1>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Total Barang -->
    <div class="p-6 bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">
        <h2 class="text-lg font-semibold tracking-wide">Total Barang</h2>
        <p class="text-4xl font-extrabold mt-3"><?= $total_barang ?></p>
    </div>

    <!-- Total Barang Masuk -->
    <div class="p-6 bg-gradient-to-r from-green-600 to-green-400 text-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">
        <h2 class="text-lg font-semibold tracking-wide">Total Barang Masuk</h2>
        <p class="text-4xl font-extrabold mt-3"><?= $total_masuk ?></p>
    </div>

    <!-- Total Barang Keluar -->
    <div class="p-6 bg-gradient-to-r from-teal-500 to-cyan-400 text-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">
        <h2 class="text-lg font-semibold tracking-wide">Total Barang Keluar</h2>
        <p class="text-4xl font-extrabold mt-3"><?= $total_keluar ?></p>
    </div>

</div>

<!-- Data terbaru -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- Barang Masuk -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-lg rounded-2xl p-6">
        <h2 class="font-bold text-xl mb-4 text-blue-900">Barang Masuk Terbaru</h2>
        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-blue-200 text-blue-900">
                    <th class="p-3 border">Barang</th>
                    <th class="p-3 border">Jumlah</th>
                    <th class="p-3 border">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang_terbaru as $bm): ?>
                <tr class="hover:bg-blue-50 transition">
                    <td class="border p-3"><?= $bm['nama_barang'] ?></td>
                    <td class="border p-3"><?= $bm['jumlah'] ?></td>
                    <td class="border p-3"><?= $bm['tanggal_masuk'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Barang Keluar -->
    <div class="bg-gradient-to-br from-green-50 to-green-100 shadow-lg rounded-2xl p-6">
        <h2 class="font-bold text-xl mb-4 text-green-900">Barang Keluar Terbaru</h2>
        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-green-200 text-green-900">
                    <th class="p-3 border">Barang</th>
                    <th class="p-3 border">Jumlah</th>
                    <th class="p-3 border">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang_keluar_terbaru as $bk): ?>
                <tr class="hover:bg-green-50 transition">
                    <td class="border p-3"><?= $bk['nama_barang'] ?></td>
                    <td class="border p-3"><?= $bk['jumlah'] ?></td>
                    <td class="border p-3"><?= $bk['tanggal_keluar'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include "../templates/footer.php"; ?>
