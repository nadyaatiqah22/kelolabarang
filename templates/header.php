<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Barang</title>
</head>



<body class="bg-gray-100">

<!-- SIDEBAR KIRI -->
<div class="w-64 h-screen bg-gradient-to-b from-gray-900 to-gray-700 text-white fixed left-0 top-0 shadow-lg">

    <!-- Logo -->
<div class="p-6 text-center border-b border-gray-700 flex items-center gap-3">
    <img src="/kelolabarang/assets/logobznobg.png" alt="Logo" class="w-15 h-15">
</div>

<!-- Menu -->
    <nav class="mt-6 flex-1 text-sm">
        <a href="/kelolabarang/pages/dashboard.php" class="block px-6 py-3 rounded-lg hover:bg-white/20 transition">Dashboard</a>
        <a href="/kelolabarang/pages/barang/index.php" class="block px-6 py-3 rounded-lg hover:bg-white/20 transition">Data Barang</a>
        <a href="/kelolabarang/pages/barang_masuk/index.php" class="block px-6 py-3 rounded-lg hover:bg-white/20 transition">Barang Masuk</a>
        <a href="/kelolabarang/pages/barang_keluar/index.php" class="block px-6 py-3 rounded-lg hover:bg-white/20 transition">Barang Keluar</a>
        <a href="/kelolabarang/pages/laporan/index.php" class="block px-6 py-3 rounded-lg hover:bg-white/20 transition">Laporan</a>
    </nav>

<a href="/kelolabarang/auth/logout.php" class="block px-6 py-3 bg-red-600 hover:bg-red-900 mt-8">Logout</a> </nav>

</div>

<!-- KONTEN UTAMA (DIGESER KE KANAN) -->
<div class="ml-64 p-6">

<?php 
if ($msg = get_flash()) {
    echo "<div class='mb-4'>$msg</div>";
}
?>

