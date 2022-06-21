-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jun 2022 pada 02.09
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `suratm`
--

CREATE TABLE `suratm` (
  `id` int(11) NOT NULL,
  `arsip` varchar(50) NOT NULL,
  `tgl` varchar(70) NOT NULL,
  `nosurat` varchar(200) NOT NULL,
  `tglsurat` varchar(100) NOT NULL,
  `dari` varchar(200) NOT NULL,
  `hal` varchar(200) NOT NULL,
  `surat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `suratm`
--

INSERT INTO `suratm` (`id`, `arsip`, `tgl`, `nosurat`, `tglsurat`, `dari`, `hal`, `surat`) VALUES
(1, 'asepsan', '2022-06-28', '90', '2022-06-18', 'bang bang', 'sangkuriang', '62b05be9ccd91.pdf'),
(2, 'abb', '2022-06-28', 'sks', '2022-06-21', 'sekolah', 'slkn', '62b0d056715ae.'),
(3, 'asep san', '2022-06-28', 'suak ', '2022-06-18', 'sda', 'suaka', '62b0d056715ae.'),
(4, 'kasn', '2022-06-30', 'index', '', 'camita', '', '62b0d0a8dad19.');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `suratm`
--
ALTER TABLE `suratm`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `suratm`
--
ALTER TABLE `suratm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
