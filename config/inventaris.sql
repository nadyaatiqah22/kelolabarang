-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Nov 2025 pada 15.48
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `kategori`, `satuan`, `stok`, `created_at`) VALUES
(5, 'BRG003', 'Percobaan', 'Percobaan', NULL, 3, '2025-11-23 09:39:25'),
(7, 'BRG005', 'Percobaan', 'Percobaan', NULL, -2, '2025-11-23 09:42:24'),
(12, '001', 'Amplop Kecil ', '', NULL, 4, '2025-11-29 07:12:53'),
(13, '002', 'Bulpen', '', NULL, 5, '2025-11-29 07:13:51'),
(14, '003', 'Isi Staples Kecil ', '', NULL, 3, '2025-11-29 07:15:53'),
(15, '004', 'Sticky Note Kecil', '', NULL, 2, '2025-11-29 07:17:41'),
(16, '005', 'Penghapus ', '', NULL, 1, '2025-11-29 07:18:12'),
(17, '006', 'Map Plastik Bening', '', NULL, 3, '2025-11-29 07:18:56'),
(18, '007', 'Kertas Bufalo Kecil ', '', NULL, 2, '2025-11-29 07:19:32'),
(19, '008', 'Block Note ', '', NULL, 8, '2025-11-29 07:20:16'),
(20, '009', 'Reed Diffuser ', '', NULL, 2, '2025-11-29 07:21:03'),
(21, '010', 'Lem Stik', '', NULL, 1, '2025-11-29 07:21:33'),
(22, '011', 'Lakban Hitam', '', NULL, 4, '2025-11-29 07:24:06'),
(23, '012', 'Lakban Putih', '', NULL, 1, '2025-11-29 07:24:30'),
(24, '013', 'Double Tape Hijau', '', NULL, 1, '2025-11-29 07:25:04'),
(25, '014', 'Double Tape Putih', '', NULL, 2, '2025-11-29 07:25:48'),
(26, '015', 'Binder Klip Hitam 260', '', NULL, 4, '2025-11-29 07:26:30'),
(27, '016', 'Binder Klip Hitam 155', '', NULL, 1, '2025-11-29 07:27:13'),
(28, '017', 'Binder Klip Hitam 111', '', NULL, 1, '2025-11-29 07:27:32'),
(29, '018', 'Binder Klip Hitam 200', '', NULL, 5, '2025-11-29 07:28:01'),
(30, '019', 'Tisu', '', NULL, 1, '2025-11-29 07:28:20'),
(31, '020', 'Isi Staples Besar', '', NULL, 1, '2025-11-29 07:29:31'),
(32, '021', 'Perforator', '', NULL, 1, '2025-11-29 07:30:11'),
(33, '022', 'Stipo Kertas', '', NULL, 1, '2025-11-29 07:30:36'),
(34, '023', 'Baterai Alkaline AZ', '', NULL, 4, '2025-11-29 07:31:19'),
(35, '024', 'Baterai Alkaline A3', '', NULL, 1, '2025-11-29 07:47:23'),
(36, '025', 'Tinta Biru', '', NULL, 2, '2025-11-29 07:49:31'),
(37, '026', 'Tinta Hitam', '', NULL, 2, '2025-11-29 07:49:59'),
(38, '027', 'Tinta Kuning', '', NULL, 4, '2025-11-29 07:50:23'),
(39, '028', 'Tinta Merah', '', NULL, 3, '2025-11-29 07:50:59'),
(40, '029', 'Tinta Stempel biru', '', NULL, 3, '2025-11-29 07:51:34'),
(41, '030', 'Bufalo Pink', '', NULL, 1, '2025-11-29 07:52:23'),
(42, '031', 'Map Coklat', '', NULL, 1, '2025-11-29 07:52:42'),
(43, '032', 'HVS A4', '', NULL, 1, '2025-11-29 07:53:16'),
(44, '033', 'HVS F4', '', NULL, 3, '2025-11-29 07:53:58'),
(45, '034', 'Amplop Panjang', '', NULL, 7, '2025-11-29 07:54:24'),
(46, '035', 'HVS A5', '', NULL, 12, '2025-11-29 07:54:59'),
(49, '036', 'Odner', 'Stok Baru', NULL, 10, '2025-11-29 08:04:04'),
(50, '037', 'Trigonal klip', 'Stok Baru', NULL, 1, '2025-11-29 08:04:45'),
(53, '038', 'HVS A4', 'Stok Baru', NULL, 1, '2025-11-29 08:05:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `penerima` varchar(150) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', '2025-11-23 09:28:48');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
