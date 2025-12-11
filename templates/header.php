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

    <style>
        /* Animasi smooth sidebar */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-100">

<!-- ===================================================== -->
<!--   SIDEBAR DESKTOP (SELALU TERBUKA)                    -->
<!-- ===================================================== -->
<div class="hidden md:block fixed top-0 left-0 w-64 h-full overflow-y-auto bg-gradient-to-b from-gray-900 to-gray-700 text-white shadow-lg z-50">

    <!-- Logo -->
    <div class="p-6 text-center border-b border-gray-700 flex items-center justify-center">
    <img src="/kelolabarang/assets/logobznobg.png" 
         alt="Logo" 
         class="w-40 h-40 object-contain">
</div>


    <!-- Menu -->
    <nav class="mt-6 text-sm">
        <a href="/kelolabarang/pages/dashboard.php" class="block px-6 py-3 hover:bg-white/20 transition">Dashboard</a>
        <a href="/kelolabarang/pages/barang/index.php" class="block px-6 py-3 hover:bg-white/20 transition">Data Barang</a>
        <a href="/kelolabarang/pages/barang_masuk/index.php" class="block px-6 py-3 hover:bg-white/20 transition">Barang Masuk</a>
        <a href="/kelolabarang/pages/barang_keluar/index.php" class="block px-6 py-3 hover:bg-white/20 transition">Barang Keluar</a>
        <a href="/kelolabarang/pages/laporan/index.php" class="block px-6 py-3 hover:bg-white/20 transition">Laporan</a>
    </nav>

    <a href="/kelolabarang/auth/logout.php"
       class="block px-6 py-3 bg-red-600 hover:bg-red-900 mt-8">Logout</a>
</div>


<!-- ===================================================== -->
<!--   SIDEBAR MOBILE (SLIDE IN)                           -->
<!-- ===================================================== -->
<div id="mobileSidebar"
     class="fixed top-0 left-0 w-64 h-full bg-gradient-to-b from-gray-900 to-gray-700 text-white shadow-lg
            sidebar-transition z-50 md:hidden"
     style="transform: translateX(-100%);">

    <!-- Logo -->
    <div class="p-6 text-center border-b border-gray-700 flex items-center justify-center">
    <img src="/kelolabarang/assets/logobznobg.png" 
         alt="Logo" 
         class="w-40 h-40 object-contain">
</div>


    <!-- Menu -->
    <nav class="mt-6 text-sm">
        <a href="/kelolabarang/pages/dashboard.php" class="block px-6 py-3 hover:bg-white/20 transition">Dashboard</a>
        <a href="/kelolabarang/pages/barang/index.php" class="block px-6 py-3 hover:bg-white/20 transition">Data Kategori Jenis Barang</a>
        <a href="/kelolabarang/pages/barang_masuk/index.php" class="block px-6 py-3 hover:bg-white/20 transition">Barang Masuk</a>
        <a href="/kelolabarang/pages/barang_keluar/index.php" class="block px-6 py-3 hover:bg-white/20 transition">Barang Keluar</a>
        <a href="/kelolabarang/pages/laporan/index.php" class="block px-6 py-3 hover:bg-white/20 transition">Laporan</a>
    </nav>

    <a href="/kelolabarang/auth/logout.php"
       class="block px-6 py-3 bg-red-600 hover:bg-red-900 mt-8">Logout</a>
</div>


<!-- ===================================================== -->
<!--   HEADER MOBILE                                       -->
<!-- ===================================================== -->
<div class="md:hidden flex items-center justify-between bg-gray-900 text-white px-4 py-3 shadow">
    <button onclick="toggleSidebar()" class="text-2xl">&#9776;</button>
    <span class="text-lg font-semibold">Kelola Barang</span>
    <img src="/kelolabarang/assets/logobznobg.png" class="w-10 h-10" />
</div>


<!-- ===================================================== -->
<!--   OVERLAY MOBILE                                      -->
<!-- ===================================================== -->
<div id="overlay"
     class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"
     onclick="toggleSidebar()"></div>


<!-- ===================================================== -->
<!--   MAIN CONTENT                                        -->
<!-- ===================================================== -->
<div class="p-4 md:ml-64 md:p-6">

    <!-- FLASH MESSAGE -->
    <?php 
    if ($msg = get_flash()) {
        echo "<div class='mb-4'>$msg</div>";
    }
    ?>


<!-- ===================================================== -->
<!--   JAVASCRIPT TOGGLE MENU                              -->
<!-- ===================================================== -->
<script>
function toggleSidebar() {
    const sidebar = document.getElementById("mobileSidebar");
    const overlay = document.getElementById("overlay");

    const isOpen = sidebar.style.transform === "translateX(0%)";

    sidebar.style.transform = isOpen ? "translateX(-100%)" : "translateX(0%)";
    overlay.classList.toggle("hidden", isOpen);
}
</script>

</body>
</html>
