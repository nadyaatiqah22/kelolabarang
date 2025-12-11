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

<div class="flex justify-center p-4 md:p-6">

    <div class="w-full max-w-6xl">

        <!-- Judul -->
        <h1 class="text-xl sm:text-2xl font-bold mb-8 text-blue-900 text-center">
            Dashboard Inventaris Barang
        </h1>

        <!-- Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 justify-items-center">

            <!-- Total Barang -->
            <div class="p-5 bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-2xl shadow-lg hover:shadow-2xl transition w-full sm:w-64 text-center">
                <h2 class="text-base sm:text-lg font-semibold">Total Barang</h2>
                <p class="text-3xl sm:text-4xl font-extrabold mt-2"><?= $total_barang ?></p>
            </div>

            <!-- Total Barang Masuk -->
            <div class="p-5 bg-gradient-to-r from-green-600 to-green-400 text-white rounded-2xl shadow-lg hover:shadow-2xl transition w-full sm:w-64 text-center">
                <h2 class="text-base sm:text-lg font-semibold">Barang Masuk</h2>
                <p class="text-3xl sm:text-4xl font-extrabold mt-2"><?= $total_masuk ?></p>
            </div>

            <!-- Total Barang Keluar -->
            <div class="p-5 bg-gradient-to-r from-teal-500 to-cyan-400 text-white rounded-2xl shadow-lg hover:shadow-2xl transition w-full sm:w-64 text-center">
                <h2 class="text-base sm:text-lg font-semibold">Barang Keluar</h2>
                <p class="text-3xl sm:text-4xl font-extrabold mt-2"><?= $total_keluar ?></p>
            </div>

        </div>

        <!-- BAGIAN DATA TERBARU & GRAFIK -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 justify-items-center">

            <!-- Barang Masuk Terbaru -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-lg rounded-2xl p-5 w-full">
                <h2 class="font-bold text-lg sm:text-xl mb-4 text-blue-900 text-center">Barang Masuk Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max border-collapse border border-gray-200 text-sm sm:text-base">
                        <thead>
                            <tr class="bg-blue-200 text-blue-900">
                                <th class="p-3 border whitespace-nowrap">Barang</th>
                                <th class="p-3 border whitespace-nowrap">Jumlah</th>
                                <th class="p-3 border whitespace-nowrap">Tanggal</th>
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
            </div>

            <!-- Barang Keluar Terbaru -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 shadow-lg rounded-2xl p-5 w-full">
                <h2 class="font-bold text-lg sm:text-xl mb-4 text-green-900 text-center">Barang Keluar Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max border-collapse border border-gray-200 text-sm sm:text-base">
                        <thead>
                            <tr class="bg-green-200 text-green-900">
                                <th class="p-3 border whitespace-nowrap">Barang</th>
                                <th class="p-3 border whitespace-nowrap">Jumlah</th>
                                <th class="p-3 border whitespace-nowrap">Tanggal</th>
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

            <!-- GRAFIK -->
            <div class="bg-white rounded-2xl shadow-lg p-5 w-full flex flex-col items-center">
                <h2 class="font-bold text-lg sm:text-xl mb-4 text-gray-800 text-center">Statistik Barang</h2>
                <canvas id="barangChart" class="w-full max-w-full"></canvas>
            </div>

        </div>

    </div>
</div>

<?php include "../templates/footer.php"; ?>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('barangChart').getContext('2d');
    const barangChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Total Barang', 'Barang Masuk', 'Barang Keluar'],
            datasets: [{
                label: 'Jumlah',
                data: [<?= $total_barang ?>, <?= $total_masuk ?>, <?= $total_keluar ?>],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(20, 184, 166, 0.7)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(20, 184, 166, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { mode: 'index', intersect: false }
            }
        }
    });
</script>
