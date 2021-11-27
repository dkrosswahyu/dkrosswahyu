-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Nov 2021 pada 07.55
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kucingdb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_diagnosa`
--

CREATE TABLE `hasil_diagnosa` (
  `id` int(11) NOT NULL,
  `id_pasien` varchar(100) CHARACTER SET latin1 NOT NULL,
  `1` double NOT NULL,
  `2` double NOT NULL,
  `3` double NOT NULL,
  `4` double NOT NULL,
  `5` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_user`
--

CREATE TABLE `jawaban_user` (
  `id` int(11) NOT NULL,
  `id_pasien` varchar(100) CHARACTER SET latin1 NOT NULL,
  `0` int(11) NOT NULL,
  `1` int(11) NOT NULL,
  `2` int(11) NOT NULL,
  `3` int(11) NOT NULL,
  `4` int(11) NOT NULL,
  `5` int(11) NOT NULL,
  `6` int(11) NOT NULL,
  `7` int(11) NOT NULL,
  `8` int(11) NOT NULL,
  `9` int(11) NOT NULL,
  `10` int(11) NOT NULL,
  `11` int(11) NOT NULL,
  `12` int(11) NOT NULL,
  `13` int(11) NOT NULL,
  `14` int(11) NOT NULL,
  `15` int(11) NOT NULL,
  `16` int(11) NOT NULL,
  `17` int(11) NOT NULL,
  `18` int(11) NOT NULL,
  `19` int(11) NOT NULL,
  `20` int(11) NOT NULL,
  `21` int(11) NOT NULL,
  `22` int(11) NOT NULL,
  `23` int(11) NOT NULL,
  `24` int(11) NOT NULL,
  `25` int(11) NOT NULL,
  `26` int(11) NOT NULL,
  `27` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit_kucing`
--

CREATE TABLE `penyakit_kucing` (
  `id` int(11) NOT NULL,
  `nama_penyakit` varchar(100) NOT NULL,
  `0` double NOT NULL,
  `1` double NOT NULL,
  `2` double NOT NULL,
  `3` double NOT NULL,
  `4` double NOT NULL,
  `5` double NOT NULL,
  `6` double NOT NULL,
  `7` double NOT NULL,
  `8` double NOT NULL,
  `9` double NOT NULL,
  `10` double NOT NULL,
  `11` double NOT NULL,
  `12` double NOT NULL,
  `13` double NOT NULL,
  `14` double NOT NULL,
  `15` double NOT NULL,
  `16` double NOT NULL,
  `17` double NOT NULL,
  `18` double NOT NULL,
  `19` double NOT NULL,
  `20` double NOT NULL,
  `21` double NOT NULL,
  `22` double NOT NULL,
  `23` double NOT NULL,
  `24` double NOT NULL,
  `25` double NOT NULL,
  `26` double NOT NULL,
  `27` double NOT NULL,
  `solusi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penyakit_kucing`
--

INSERT INTO `penyakit_kucing` (`id`, `nama_penyakit`, `0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `solusi`) VALUES
(1, 'p1', 0.5, 0.02, 0.04, 0, 0, 0, 0, 1, 0.5, 0.6, 0, 0.8, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'penyakit asdasdasjdkbkjadb');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `hasil_diagnosa`
--
ALTER TABLE `hasil_diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jawaban_user`
--
ALTER TABLE `jawaban_user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penyakit_kucing`
--
ALTER TABLE `penyakit_kucing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `hasil_diagnosa`
--
ALTER TABLE `hasil_diagnosa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jawaban_user`
--
ALTER TABLE `jawaban_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penyakit_kucing`
--
ALTER TABLE `penyakit_kucing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
