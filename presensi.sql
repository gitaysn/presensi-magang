-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Des 2024 pada 15.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bidang`
--

CREATE TABLE `bidang` (
  `id` int(11) NOT NULL,
  `bidang` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bidang`
--

INSERT INTO `bidang` (`id`, `bidang`) VALUES
(1, 'Umum dan Kepegawaian'),
(2, 'Keuangan'),
(3, 'Pengusunan Program dan Anggaran'),
(4, 'Ajudan'),
(5, 'Sarana dan Prasarana'),
(6, 'Kemasyarakatan'),
(7, 'Pemerintahan'),
(8, 'Pembangunan Ekonomi'),
(9, 'Record Center'),
(10, 'EJSC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `jurusan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `jurusan`) VALUES
(9, 'Teknologi Informasi'),
(10, 'Akuntansi'),
(12, 'Pendidikan Teknologi Informasi'),
(13, 'Administrasi Bisnis'),
(14, 'Ekonomi Pembangunan'),
(15, 'Ekonomi Keuangan dan Perbankan'),
(16, 'Ilmu Perpustakaan'),
(17, 'Ilmu Komputer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ketidakhadiran`
--

CREATE TABLE `ketidakhadiran` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `keterangan` varchar(225) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` varchar(225) NOT NULL,
  `file` varchar(225) NOT NULL,
  `status_pengajuan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ketidakhadiran`
--

INSERT INTO `ketidakhadiran` (`id`, `id_mahasiswa`, `keterangan`, `tanggal`, `deskripsi`, `file`, `status_pengajuan`) VALUES
(10, 19, 'Sakit', '2024-12-02', 'Demam', 'contohsurat.jpeg', 'PENDING'),
(11, 19, 'Izin', '2024-12-10', 'Bimbingan', 'WhatsApp Image 2024-12-09 at 10.04.52.jpeg', 'APPROVED'),
(12, 19, 'Dinas luar', '2024-12-12', 'Dinas Luar ke Surabaya', 'WhatsApp Image 2024-12-09 at 10.04.52.jpeg', 'REJECTED');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi_presensi`
--

CREATE TABLE `lokasi_presensi` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(225) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `radius` int(11) NOT NULL,
  `zona_waktu` varchar(4) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lokasi_presensi`
--

INSERT INTO `lokasi_presensi` (`id`, `nama_lokasi`, `latitude`, `longitude`, `radius`, `zona_waktu`, `jam_masuk`, `jam_pulang`) VALUES
(10, 'Bakorwil III Malang', '-7.963323', '112.624069', 300, 'WIB', '08:00:00', '09:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `kode` varchar(225) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `no_handphone` varchar(20) NOT NULL,
  `jurusan` varchar(225) NOT NULL,
  `bidang` varchar(225) NOT NULL,
  `lokasi_presensi` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `kode`, `nama`, `jenis_kelamin`, `no_handphone`, `jurusan`, `bidang`, `lokasi_presensi`) VALUES
(1, 'MAH-0001', 'gita', 'Perempuan', '08998155154', 'Teknologi Informasi', 'Umum dan Kepegawaian', 'Bakorwil III Malang'),
(2, 'MAH-0002', 'Lintang Sururum S.M', 'Perempuan', '082337434160', 'Teknologi Informasi', 'Umum dan Kepegawaian', 'Bakorwil III Malang'),
(18, 'MAH-0003', 'Nadea Mefira', 'Perempuan', '081235934490', 'Teknologi Informasi', 'Umum dan Kepegawaian', 'Bakorwil III Malang'),
(19, 'MAH-0004', 'Gita Yasinda Putri Cahyani', 'Perempuan', '08998155154', 'Teknologi Informasi', 'Umum dan Kepegawaian', 'Bakorwil III Malang'),
(20, 'MAH-0005', 'Cyntia Fitriyana', 'Perempuan', '089516088918', 'Akuntansi', 'Keuangan', 'Bakorwil III Malang'),
(21, 'MAH-0006', 'Atika Rosidah Hamidah', 'Perempuan', '08973263356', 'Pendidikan Teknologi Informasi', 'Umum dan Kepegawaian', 'Bakorwil III Malang'),
(22, 'MAH-0007', 'Daffa’ Putri Dzakiyyah Rachma', 'Perempuan', '08885864812', 'Administrasi Bisnis', 'Pembangunan Ekonomi', 'Bakorwil III Malang'),
(23, 'MAH-0008', 'Paskah L. Tampubolon', 'Perempuan', '085975452174', 'Administrasi Bisnis', 'Kemasyarakatan', 'Bakorwil III Malang'),
(24, 'MAH-0009', 'Aprilia Eka Shalsa Bila', 'Perempuan', '081390236395', 'Administrasi Bisnis', 'Pemerintahan', 'Bakorwil III Malang'),
(25, 'MAH-0010', 'Nisa Putri Fortuna', 'Perempuan', '083135070275', 'Administrasi Bisnis', 'Sarana dan Prasarana', 'Bakorwil III Malang'),
(26, 'MAH-0011', 'Adios Amigo Zikri', 'Laki-laki', '082277338586', 'Ekonomi Keuangan dan Perbankan', 'Ajudan', 'Bakorwil III Malang'),
(27, 'MAH-0012', 'Yovankha Devi', 'Perempuan', '087771516892', 'Ekonomi Keuangan dan Perbankan', 'Pemerintahan', 'Bakorwil III Malang'),
(28, 'MAH-0013', 'Alvira Nur Fitri	', 'Perempuan', '081314160989', 'Ekonomi Keuangan dan Perbankan', 'Ajudan', 'Bakorwil III Malang'),
(29, 'MAH-0014', 'Bayu Seno Aji', 'Laki-laki', '089529945538', 'Ekonomi Keuangan dan Perbankan', 'Kemasyarakatan', 'Bakorwil III Malang'),
(30, 'MAH-0015', 'Dita Selsabillah', 'Perempuan', '085784649258', 'Akuntansi', 'Keuangan', 'Bakorwil III Malang'),
(31, 'MAH-0016', 'Radina Kasyfa Shula', 'Perempuan', '081335010410', 'Akuntansi', 'Keuangan', 'Bakorwil III Malang'),
(32, 'MAH-0017', 'Izzatul Laila Arofah', 'Perempuan', '081252785702', 'Ilmu Perpustakaan', 'Record Center', 'Bakorwil III Malang'),
(33, 'MAH-0018', 'Maya Miftakhul Laili', 'Perempuan', '08563410246', 'Ilmu Perpustakaan', 'Record Center', 'Bakorwil III Malang'),
(34, 'MAH-0019', 'Leo Satrrio', 'Laki-laki', '087866929787', 'Ilmu Perpustakaan', 'Record Center', 'Bakorwil III Malang'),
(35, 'MAH-0020', 'Gita Candra Swari', 'Perempuan', '082332181528', 'Administrasi Bisnis', 'Pembangunan Ekonomi', 'Bakorwil III Malang'),
(36, 'MAH-0021', 'Yehuda Kristiawan', 'Laki-laki', '085648194351', 'Ilmu Komputer', 'EJSC', 'Bakorwil III Malang'),
(37, 'MAH-0022', 'Vermelnea Zhuna I', 'Laki-laki', '082229531601', 'Ilmu Komputer', 'EJSC', 'Bakorwil III Malang'),
(39, 'MAH-0023', 'Vira Asmania', 'Perempuan', '082143000500', 'Administrasi Bisnis', 'EJSC', 'Bakorwil III Malang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `foto_masuk` varchar(225) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `jam_keluar` time NOT NULL,
  `foto_keluar` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `id_mahasiswa`, `tanggal_masuk`, `jam_masuk`, `foto_masuk`, `tanggal_keluar`, `jam_keluar`, `foto_keluar`) VALUES
(34, 2, '2024-12-02', '08:49:02', 'masuk2024-12-02_02-50-03.png', '0000-00-00', '00:00:00', ''),
(35, 2, '2024-12-05', '08:00:42', 'masuk2024-12-05_02-01-01.png', '0000-00-00', '00:00:00', ''),
(36, 19, '2024-12-06', '09:32:34', 'masuk2024-12-06_03-32-52.png', '2024-12-06', '09:33:42', 'keluar2024-12-06_03-34-18.png'),
(37, 19, '2024-12-11', '08:39:32', 'masuk2024-12-11_02-39-51.png', '0000-00-00', '00:00:00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `status` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_mahasiswa`, `username`, `password`, `status`, `role`) VALUES
(1, 1, 'gita', '$2y$10$Exo0VkJ9kw4iyfZkbIeU2OSt2expX9TZVCj3KOV0wi5w6VXdDukuy', 'Aktif', 'admin'),
(2, 2, 'Lintang', '$2y$10$2NycH8x4zi4.Q3Zar4fdw.YNRfMJvh6Xs7mmgrUbSn2sTkeyJZXgu', 'Aktif', 'mahasiswa'),
(20, 18, 'Nadea', '$2y$10$Be5h.KbckpmCzimjmedwiuXpus11wQ7RLFFdE/SBct3/wAVjJHoBy', 'Aktif', 'mahasiswa'),
(21, 19, 'Gita Yasinda', '$2y$10$wv4Y7c5uB4u236khfOBMp.ap3n3Va.GchdsHnDm4OjiI/ZuELtj0a', 'Aktif', 'mahasiswa'),
(22, 20, 'Cyntia', '$2y$10$6xoC4rjeW.7z5.AU1ntgEu1I0.GLmK6tc6Ro2SQSnaoZKOjoCOjgC', 'Aktif', 'mahasiswa'),
(23, 21, 'Atika ', '$2y$10$wv4Y7c5uB4u236khfOBMp.ap3n3Va.GchdsHnDm4OjiI/ZuELtj0a', 'Aktif', 'mahasiswa'),
(24, 22, 'Daffa', '$2y$10$6xoC4rjeW.7z5.AU1ntgEu1I0.GLmK6tc6Ro2SQSnaoZKOjoCOjgC', 'Aktif', 'mahasiswa'),
(25, 23, 'Paskah ', '$2y$10$hIOqBBIt/EWRaW7r6Te57OzJcdfuWT5MUmh1DGXj.zsfdMjnzgpAy', 'Aktif', 'mahasiswa'),
(26, 24, 'April', '$2y$10$6xoC4rjeW.7z5.AU1ntgEu1I0.GLmK6tc6Ro2SQSnaoZKOjoCOjgC', 'Aktif', 'mahasiswa'),
(27, 25, 'Nisa ', '$2y$10$JmZLeL9p7ioLKtdJYVFa2.9Aj9f.1rqHCyay1Hgq8.uNYxwzUmOXO', 'Aktif', 'mahasiswa'),
(28, 26, 'Adios', '$2y$10$nJDMSCh0OBFAJlIM4OYXd.UJqLf25GO2kfIUkdDymxfFQW4Pga8gK', 'Aktif', 'mahasiswa'),
(29, 27, 'Yovankha', '$2y$10$jzgOvThwqSF7heRRlvb7ReHDP5mCyozTbgNPap9TT8G9DDs3E3Gya', 'Aktif', 'mahasiswa'),
(30, 28, 'Alvira', '$2y$10$rxdB7kNaNDGteVTcWeJWzew2o6yK8qMhS9/59H2RT1zpHDeUZy8wW', 'Aktif', 'mahasiswa'),
(31, 29, 'Bayu ', '$2y$10$jzgOvThwqSF7heRRlvb7ReHDP5mCyozTbgNPap9TT8G9DDs3E3Gya', 'Aktif', 'mahasiswa'),
(32, 30, 'Selsa', '$2y$10$CwBKX.grEN2RhAn.4gCNz.4LcX.imrJkHj2bMVtmozOKKvlTcpKwa', 'Aktif', 'mahasiswa'),
(33, 31, 'Dina', '$2y$10$/PR0NK5gj8.b8AJIS.fgvudHbduxsk9i3SGbwfVKBbbm4Ef0zgTx.', 'Aktif', 'mahasiswa'),
(34, 32, 'Ela', '$2y$10$bFLv.Wl9anw6ul7Qz62UceJUGK2jrkKUNLwSKkth6F6TUn2Tkvt1u', 'Aktif', 'mahasiswa'),
(35, 33, 'Maya', '$2y$10$/PR0NK5gj8.b8AJIS.fgvudHbduxsk9i3SGbwfVKBbbm4Ef0zgTx.', 'Aktif', 'mahasiswa'),
(36, 34, 'Leo ', '$2y$10$bFLv.Wl9anw6ul7Qz62UceJUGK2jrkKUNLwSKkth6F6TUn2Tkvt1u', 'Aktif', 'mahasiswa'),
(37, 35, 'Gita Candra ', '$2y$10$/PR0NK5gj8.b8AJIS.fgvudHbduxsk9i3SGbwfVKBbbm4Ef0zgTx.', 'Aktif', 'mahasiswa'),
(38, 36, 'Yehuda ', '$2y$10$qyM2cmqZwqfslcwl7ebB8.MlpmGmRJUCJG14pIhif/kdgpVqX2fJm', 'Aktif', 'mahasiswa'),
(39, 37, 'Vermelnea ', '$2y$10$hYvMxZeiH/YIuwmt7YwKsOHwWmOlY/MelDU2NpAyr7W1xeEPCpXTK', 'Aktif', 'mahasiswa'),
(41, 39, 'Nia ', '$2y$10$SqQ9Z/d.9J6OE5R9xAJrauRMoA9xrMCwgJVTZogMA3n7PThSGvUAG', 'Aktif', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ketidakhadiran`
--
ALTER TABLE `ketidakhadiran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indeks untuk tabel `lokasi_presensi`
--
ALTER TABLE `lokasi_presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `ketidakhadiran`
--
ALTER TABLE `ketidakhadiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `lokasi_presensi`
--
ALTER TABLE `lokasi_presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `ketidakhadiran`
--
ALTER TABLE `ketidakhadiran`
  ADD CONSTRAINT `ketidakhadiran_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
