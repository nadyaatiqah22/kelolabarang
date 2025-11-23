<?php
include "../../config/config.php";
cek_login();

// Ambil filter bulan & tahun
$bulan = $_GET['bulan'] ?? date("m");
$tahun = $_GET['tahun'] ?? date("Y");

// Ambil semua barang + kategori
$barang = query("SELECT * FROM barang ORDER BY nama_barang ASC");

// Header untuk Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_inventaris_{$bulan}_{$tahun}.xls");

// Mulai tabel Excel
echo "<table border='1'>";
echo "<tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Stok Awal</th>
        <th>Masuk (Jumlah)</th>
        <th>Tanggal Masuk</th>
        <th>Keluar (Jumlah)</th>
        <th>Tanggal Keluar</th>
        <th>Stok Akhir</th>
      </tr>";

$no = 1;
foreach ($barang as $b) {

    // Hitung total masuk & ambil tanggal masuk
    $q_masuk = mysqli_query($conn, "
        SELECT jumlah, tanggal_masuk 
        FROM barang_masuk 
        WHERE barang_id = {$b['id']} 
          AND MONTH(tanggal_masuk) = $bulan 
          AND YEAR(tanggal_masuk) = $tahun
    ");
    $masuk_data = [];
    while($row = mysqli_fetch_assoc($q_masuk)) {
        $masuk_data[] = $row['jumlah'] . " (". $row['tanggal_masuk'] .")";
    }
    $masuk_str = !empty($masuk_data) ? implode(", ", $masuk_data) : 0;

    // Hitung total keluar & ambil tanggal keluar
    $q_keluar = mysqli_query($conn, "
        SELECT jumlah, tanggal_keluar 
        FROM barang_keluar 
        WHERE barang_id = {$b['id']} 
          AND MONTH(tanggal_keluar) = $bulan 
          AND YEAR(tanggal_keluar) = $tahun
    ");
    $keluar_data = [];
    while($row = mysqli_fetch_assoc($q_keluar)) {
        $keluar_data[] = $row['jumlah'] . " (". $row['tanggal_keluar'] .")";
    }
    $keluar_str = !empty($keluar_data) ? implode(", ", $keluar_data) : 0;

    // Hitung stok
    $total_masuk  = array_sum(array_column($masuk_data, 'jumlah')) ?? 0;
    $total_keluar = array_sum(array_column($keluar_data, 'jumlah')) ?? 0;
    $stok_awal    = $b['stok'] + $total_keluar - $total_masuk;
    $stok_akhir   = $stok_awal + $total_masuk - $total_keluar;

    echo "<tr>
            <td>{$no}</td>
            <td>{$b['nama_barang']}</td>
            <td>{$b['kategori']}</td>
            <td>{$stok_awal}</td>
            <td>{$masuk_str}</td>
            <td>".($masuk_str ? implode(", ", array_map(fn($x)=>explode(" (",$x)[1],$masuk_data)):"-")."</td>
            <td>{$keluar_str}</td>
            <td>".($keluar_str ? implode(", ", array_map(fn($x)=>explode(" (",$x)[1],$keluar_data)):"-")."</td>
            <td>{$stok_akhir}</td>
          </tr>";

    $no++;
}

echo "</table>";
exit;
