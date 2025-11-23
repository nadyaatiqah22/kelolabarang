<?php
include "../../config/config.php";
cek_login();
include "../../templates/header.php";

// Ambil filter bulan & tahun
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date("m");
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date("Y");

// Fungsi hitung masuk & keluar berdasarkan bulan dan tahun
function hitung_masuk($id, $bulan, $tahun) {
    global $conn;
    $q = mysqli_query($conn, "
        SELECT SUM(jumlah) AS total 
        FROM barang_masuk 
        WHERE barang_id = $id 
          AND MONTH(tanggal_masuk) = $bulan 
          AND YEAR(tanggal_masuk) = $tahun
    ");
    $r = mysqli_fetch_assoc($q);
    return $r['total'] ? $r['total'] : 0;
}

function hitung_keluar($id, $bulan, $tahun) {
    global $conn;
    $q = mysqli_query($conn, "
        SELECT SUM(jumlah) AS total 
        FROM barang_keluar 
        WHERE barang_id = $id 
          AND MONTH(tanggal_keluar) = $bulan 
          AND YEAR(tanggal_keluar) = $tahun
    ");
    $r = mysqli_fetch_assoc($q);
    return $r['total'] ? $r['total'] : 0;
}

// Ambil barang yang ada transaksi masuk atau keluar di bulan & tahun terpilih
$barang = query("
    SELECT DISTINCT b.*
    FROM barang b
    LEFT JOIN barang_masuk bm ON b.id = bm.barang_id 
        AND MONTH(bm.tanggal_masuk) = $bulan 
        AND YEAR(bm.tanggal_masuk) = $tahun
    LEFT JOIN barang_keluar bk ON b.id = bk.barang_id 
        AND MONTH(bk.tanggal_keluar) = $bulan 
        AND YEAR(bk.tanggal_keluar) = $tahun
    WHERE bm.id IS NOT NULL OR bk.id IS NOT NULL
    ORDER BY b.nama_barang ASC
");
?>



<h1 class="text-2xl font-bold mb-4">Laporan Inventaris</h1>

<!-- Filter -->
<div class="bg-gradient-to-r from-blue-50 to-green-50 p-4 rounded-2xl shadow mb-6 flex items-center gap-4">

    <form method="GET" class="flex gap-4">

        <div>
            <label class="block font-medium text-gray-700">Bulan</label>
            <select name="bulan" class="border rounded px-3 py-2">
                <?php for ($b = 1; $b <= 12; $b++): ?>
                    <option value="<?= $b; ?>" <?= ($bulan == $b) ? "selected" : "" ?>>
                        <?= date("F", mktime(0,0,0,$b,10)); ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Tahun</label>
            <select name="tahun" class="border rounded px-3 py-2">
                <?php for ($t = 2020; $t <= date("Y"); $t++): ?>
                    <option value="<?= $t; ?>" <?= ($tahun == $t) ? "selected" : "" ?>>
                        <?= $t; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="flex items-end">
            <button class="bg-gradient-to-r from-yellow-500 to-yellow-500 text-white px-4 py-2 rounded-2xl shadow hover:from-blue-600 hover:to-green-600 transition">
                Tampilkan
            </button>
        </div>

    </form>
</div>

<!-- Tombol Export -->
<div class="flex gap-3 mb-4">
    <a href="/kelolabarang/pages/laporan/export_excel.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>"
       class="bg-gradient-to-r from-green-500 to-green-500 text-white px-4 py-2 rounded-2xl shadow hover:from-green-600 hover:to-blue-600 transition">
       Export Excel
    </a>
</div>

<!-- Tabel Laporan -->
<div class="bg-gradient-to-br from-blue-50 to-green-50 p-6 rounded-2xl shadow-lg">
    <table class="min-w-full table-auto border-collapse text-gray-800">
        <thead>
        <tr class="bg-gradient-to-r from-blue-200 to-green-200 text-gray-900">
            <th class="border px-4 py-2">No</th>
            <th class="border px-4 py-2 text-left">Nama Barang</th>
            <th class="border px-4 py-2">Stok Awal</th>
            <th class="border px-4 py-2">Masuk</th>
            <th class="border px-4 py-2">Keluar</th>
            <th class="border px-4 py-2">Stok Akhir</th>
        </tr>
        </thead>

        <tbody>
        <?php if(empty($barang)): ?>
            <tr>
                <td colspan="6" class="border px-4 py-2 text-center">Tidak ada transaksi di bulan ini</td>
            </tr>
        <?php else: ?>
            <?php 
            $no = 1; 
            foreach ($barang as $b): 
                $masuk  = hitung_masuk($b['id'], $bulan, $tahun);
                $keluar = hitung_keluar($b['id'], $bulan, $tahun);
                $awal   = $b['stok'] + $keluar - $masuk;
                $akhir  = $awal + $masuk - $keluar;
            ?>
                <tr class="hover:bg-blue-50 transition">
                    <td class="border px-4 py-2 text-center"><?= $no++; ?></td>
                    <td class="border px-4 py-2 font-semibold"><?= $b['nama_barang']; ?></td>
                    <td class="border px-4 py-2 text-center"><?= $awal; ?></td>
                    <td class="border px-4 py-2 text-center font-bold text-green-700"><?= $masuk; ?></td>
                    <td class="border px-4 py-2 text-center font-bold text-red-600"><?= $keluar; ?></td>
                    <td class="border px-4 py-2 text-center font-semibold"><?= $akhir; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "../../templates/footer.php"; ?>
