-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Mar 2024 pada 00.52
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galeri`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `albums`
--

INSERT INTO `albums` (`album_id`, `user_id`, `title`, `description`, `created_at`) VALUES
(27, 30, 'ssss', 'ss', '2024-02-23 01:04:14'),
(28, 32, 'dd', 'dd', '2024-02-23 01:28:05'),
(30, 31, 'ujikom ', 'ujikom ', '2024-02-28 01:04:19'),
(31, 34, 'ujikom 2', 'anjay ', '2024-02-28 01:11:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `photo_id`, `comment_text`, `created_at`) VALUES
(14, 1, 26, 'ss', '2024-02-12 03:46:21'),
(17, 20, 26, 'aaa', '2024-02-12 03:55:17'),
(21, 17, 26, 'aaa', '2024-02-12 04:45:15'),
(23, 17, 26, 'aa', '2024-02-12 04:54:01'),
(26, 17, 27, 'qq', '2024-02-12 04:56:45'),
(28, 20, 31, 'ss', '2024-02-13 14:05:29'),
(30, 20, 25, 'aa', '2024-02-20 01:04:32'),
(32, 17, 25, 'abc', '2024-02-20 01:07:02'),
(33, 20, 36, 'ggg', '2024-02-20 01:53:56'),
(36, 17, 29, 'tes cuy\r\n', '2024-02-20 07:10:00'),
(40, 34, 57, 'wiiiih', '2024-02-28 02:43:18'),
(41, 34, 65, 'aa', '2024-02-28 03:48:16'),
(42, 34, 60, 'b', '2024-02-28 03:54:54'),
(44, 34, 63, 'anjay', '2024-02-28 04:19:48'),
(45, 34, 65, 'anjay ', '2024-02-28 04:35:21'),
(46, 31, 65, 'wiidih', '2024-02-28 04:37:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `photo_id`, `created_at`) VALUES
(1, 20, 5, '0000-00-00 00:00:00'),
(2, 20, 7, '2024-02-06 17:00:00'),
(3, 20, 8, '2024-02-06 17:00:00'),
(4, 20, 2, '2024-02-07 01:21:45'),
(5, 20, 17, '2024-02-09 08:59:30'),
(6, 20, 13, '2024-02-09 09:00:53'),
(7, 20, 21, '2024-02-09 09:01:22'),
(8, 20, 20, '2024-02-09 09:01:42'),
(11, 20, 27, '2024-02-09 23:47:31'),
(12, 20, 28, '2024-02-10 05:50:55'),
(13, 21, 27, '2024-02-10 05:51:25'),
(15, 20, 25, '2024-02-12 01:56:18'),
(21, 20, 30, '2024-02-12 04:22:42'),
(23, 17, 26, '2024-02-12 04:45:40'),
(24, 20, 31, '2024-02-12 05:12:05'),
(25, 17, 27, '2024-02-16 01:13:18'),
(33, 20, 29, '2024-02-20 02:30:04'),
(39, 34, 66, '2024-03-04 02:18:10'),
(40, 31, 65, '2024-03-05 01:01:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `photos`
--

CREATE TABLE `photos` (
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `photos`
--

INSERT INTO `photos` (`photo_id`, `user_id`, `album_id`, `title`, `description`, `image_path`, `created_at`) VALUES
(57, 34, 31, 'ujikooomoooo', 'mobil ', 'th (3).jpeg', '2024-03-05 03:31:40'),
(58, 34, 31, 'tugasssssss', 'ujikom', 'high-resolution-nature-landscape-l.jpg', '2024-03-05 03:29:45'),
(59, 34, 31, 'lahgfd', 'lpi98ytydfxgcvbjkl;l', '74906.jpg', '2024-02-27 17:00:00'),
(60, 34, 31, 'lkihgyffgc', 'l;oyrdsedyhjbnvcfxdhyhn', 'th (2).jpeg', '2024-02-27 17:00:00'),
(61, 34, 31, ' hvajdgfd', 'fdsawerdfcvb', 'legion-dt-1920x1080.jpg', '2024-02-27 17:00:00'),
(62, 34, 31, 'jhuytfdcgv', 'sdgfhbsndfkj', 'th (3).jpeg', '2024-02-27 17:00:00'),
(63, 34, 31, 'njbhvgcgfytfg', 'mjkhuytfghbnvgfv', 'W4A2827-1-3000x2000.jpg', '2024-02-27 17:00:00'),
(64, 34, 31, 'bhdjyfadjdgh', 'nhuhbgtrfdcx', 'legion-dt-1920x1080.jpg', '2024-02-27 17:00:00'),
(65, 34, 31, 'asdc', 'bgvfdcvbn', 'th (1).jpeg', '2024-02-27 17:00:00'),
(66, 34, 31, 'ujikkom', 'bhuiokbn', 'iStock-483771218-min.jpg', '2024-03-05 03:27:50'),
(67, 31, 30, 'mycar', 'kewren', 'th (2).jpeg', '2024-03-04 01:07:54'),
(68, 31, 30, 'pemandangan', 'sangat indah ', 'W4A2827-1-3000x2000.jpg', '2024-03-04 17:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `access_level` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `name`, `password`, `username`, `email`, `created_at`, `access_level`) VALUES
(31, 'admin', 'e3274be5c857fb42ab72d786e281b4b8', 'admin', 'admin@gmail.com', '2024-02-23 01:01:05', 'admin'),
(34, 'ahmad', '202cb962ac59075b964b07152d234b70', 'madd', 'ahmad@gmail.com', '2024-03-04 01:21:07', 'user'),
(36, 'dimas', '202cb962ac59075b964b07152d234b70', 'dim', 'dim@gmail.com', '2024-03-01 01:15:10', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`photo_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indeks untuk tabel `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `user_id` (`user_id`,`photo_id`);

--
-- Indeks untuk tabel `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `user_id` (`user_id`,`album_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
