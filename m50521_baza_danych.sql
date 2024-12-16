-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql.ct8.pl
-- Generation Time: Dec 16, 2024 at 03:55 PM
-- Wersja serwera: 8.0.39
-- Wersja PHP: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `m50521_baza_danych`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adresy`
--

CREATE TABLE `adresy` (
  `id_adresu` int NOT NULL,
  `ulica` varchar(100) NOT NULL,
  `nr_domu` varchar(10) NOT NULL,
  `nr_mieszkania` varchar(10) DEFAULT NULL,
  `miasto` varchar(100) NOT NULL,
  `kod_pocztowy` varchar(10) NOT NULL,
  `id_uzytkownika` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `adresy`
--

INSERT INTO `adresy` (`id_adresu`, `ulica`, `nr_domu`, `nr_mieszkania`, `miasto`, `kod_pocztowy`, `id_uzytkownika`) VALUES
(13, 'Domanicka', '51', '', 'Siedlce', '08-110', 17);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aktualnosci`
--

CREATE TABLE `aktualnosci` (
  `id_aktualnosci` int NOT NULL,
  `tytul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tresc` text COLLATE utf8mb4_general_ci NOT NULL,
  `data_utworzenia` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktualnosci`
--

INSERT INTO `aktualnosci` (`id_aktualnosci`, `tytul`, `tresc`, `data_utworzenia`) VALUES
(1, 'PROMOCJE', 'Za tydzień nowe promki ', '2024-11-25 10:24:22'),
(6, 'Nowy asortyment ', 'Niedługo nowe rzeczy będą ', '2024-11-30 18:35:29'),
(7, 'nowa', 'nowa', '2024-12-04 13:30:00'),
(8, 'Krystian', 'Krystian sie spocił', '2024-12-07 21:05:21'),
(9, 'NOWE PROMOCJE', 'niedlugo nowe promocje', '2024-12-08 14:57:53');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostawcy`
--

CREATE TABLE `dostawcy` (
  `id_dostawcy` int NOT NULL,
  `nazwa_dostawcy` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kraj_pochodzenia` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dostawcy`
--

INSERT INTO `dostawcy` (`id_dostawcy`, `nazwa_dostawcy`, `kraj_pochodzenia`) VALUES
(1, 'NVIDIA', 'USA'),
(2, 'AMD', 'USA'),
(3, 'INTEL', 'USA'),
(4, 'Apple', 'USA');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id_kategorii` int NOT NULL,
  `nazwa_kategorii` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id_kategorii`, `nazwa_kategorii`) VALUES
(1, 'Karty graficzne'),
(2, 'Procesory');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kontakty`
--

CREATE TABLE `kontakty` (
  `id_kontaktu` int NOT NULL,
  `nr_tel` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_uzytkownika` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `kontakty`
--

INSERT INTO `kontakty` (`id_kontaktu`, `nr_tel`, `email`, `id_uzytkownika`) VALUES
(13, '517343028', 'u20_kacpergajowniczek@zsp1.siedlce.pl', 17);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `id_koszyka` int NOT NULL,
  `id_uzytkownika` int DEFAULT NULL,
  `id_produktu` int NOT NULL,
  `ilosc` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id_prac` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `haslo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `imie` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nazwisko` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`id_prac`, `username`, `email`, `haslo`, `imie`, `nazwisko`) VALUES
(1, 'radzik', 'radzik@gmail.com', '$2y$10$FtcmAno6NSb2CdHn3X4bLOHVHp1WqWloW5SwXpf4ed1jTEL2EGMVe', 'Jakub', 'Radzikowski'),
(2, 'kosiorek', 'kosior@gmail.com', '$2y$10$6RkJoweIZMHmYAe3HKy9muO6zKP1mm82w6JT1e165wb4lBOxTD7ZO', 'Ernest', 'Kosieradzki'),
(3, 'dejmix', 'u20_damianborysiewicz@zsp1.siedlce.pl', '$2y$10$kuvGkZt0al2ApshkWQcYNegLTKx8a0lLyV9L/KtPQm.7Abx67IAzm', 'Damian', 'Borysiewicz');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produktu` int NOT NULL,
  `nazwa` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_kategorii` int DEFAULT NULL,
  `id_dostawcy` int DEFAULT NULL,
  `cena` decimal(10,2) NOT NULL,
  `parametry` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zdjecie` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id_produktu`, `nazwa`, `id_kategorii`, `id_dostawcy`, `cena`, `parametry`, `zdjecie`) VALUES
(2, 'AMD Radeon RX 6800', 1, 2, 3000.00, 'Mid-range GPU, 16GB GDDR6', './css/img/RX6800.png'),
(3, 'NVIDIA GeForce RTX 4090', 1, 1, 7500.00, 'Top-tier GPU, 24GB GDDR6X', './css/img/rtx4090.png'),
(4, 'AMD Radeon RX 7900 XT', 1, 2, 6000.00, 'High-performance GPU, 20GB GDDR6', './css/img/rx7900xt.png'),
(5, 'NVIDIA RTX 4080', 1, 1, 1199.99, 'Next-gen GPU, 16GB GDDR6X', './css/img/rtx4080.png'),
(6, 'AMD Radeon RX 7900 XTX', 1, 2, 999.99, 'Premium GPU, 24GB GDDR6', './css/img/rx7900xtx.png'),
(7, 'AMD Ryzen 9 7950X', 2, 2, 699.99, '16-core CPU, 32 threads, 5.7GHz', './css/img/ryzen97950.png'),
(8, 'Intel Core i9-13900K', 2, 3, 659.99, '24-core CPU, 32 threads, 5.8GHz', './css/img/i913900.png'),
(9, 'AMD Ryzen 7 7800X3D', 2, 2, 499.99, '8-core CPU, 16 threads, 5.0GHz', './css/img/ryzen77800x3d.png'),
(10, 'Intel Core i7-13700K', 2, 3, 419.99, '16-core CPU, 24 threads, 5.4GHz', './css/img/i713700.png'),
(11, 'AMD Ryzen 5 7600X', 2, 2, 299.99, '6-core CPU, 12 threads, 5.2GHz', './css/img/ryzen57600x.png'),
(12, 'Intel Core i5-13600K', 2, 3, 319.99, '14-core CPU, 20 threads, 5.1GHz', './css/img/i513600.png'),
(13, 'iPhone 16', NULL, 4, 4999.00, 'Kolor: Różowy, Pamięć: 256GB, Aparat: 48 MP', './css/img/iphone16.png'),
(14, 'iPhone 15', NULL, 4, 5799.00, 'Kolor: Czarny, Pamięć: 256GB, Aparat: 48 MP', './css/img/iphone15.png'),
(15, 'iPhone 14', NULL, 4, 5199.00, 'Kolor: Niebieski, Pamięć: 128GB, Aparat: 48 MP', './css/img/iphone14.png'),
(16, 'iPhone 13', NULL, 4, 4599.00, 'Kolor: Zielony, Pamięć: 128GB, Aparat: 12 MP', './css/img/iphone13.png'),
(17, 'iPhone 12', NULL, 4, 3999.00, 'Kolor: Biały, Pamięć: 64GB, Aparat: 12 MP', './css/img/iphone12.png'),
(18, 'iPhone 11', NULL, 4, 3399.00, 'Kolor: Żółty, Pamięć: 64GB, Aparat: 12 MP', './css/img/iphone11.png'),
(21, 'nowy', 1, 3, 1200.00, 'parametr', 'css/img/okok.jpg'),
(22, 'jurek', 1, 1, 2999.99, 'fajny jurek', 'css/img/jurek_1.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ulubione`
--

CREATE TABLE `ulubione` (
  `id_ulubione` int NOT NULL,
  `id_uzytkownika` int NOT NULL,
  `id_produktu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulubione`
--

INSERT INTO `ulubione` (`id_ulubione`, `id_uzytkownika`, `id_produktu`) VALUES
(20, 17, 4),
(18, 17, 8),
(17, 17, 11),
(21, 17, 13),
(24, 17, 14),
(23, 17, 17);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownika` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `notatka` varchar(255) DEFAULT NULL,
  `rola` enum('admin','uzytkownik') NOT NULL DEFAULT 'uzytkownik',
  `reset_token_hash` varchar(255) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_uzytkownika`, `username`, `email`, `haslo`, `imie`, `nazwisko`, `notatka`, `rola`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(2, 'Harnoldzik', 'u20_karolhernandez@zsp1.siedlce.pl', '$2y$10$Xb.FvrwLbK0yoarZGzZSjuwUjs.k93XdPf3iWuUGwhVT5a17wmgqa', '', '', 'glupi trch karol hernandez ale lubie go', 'uzytkownik', NULL, NULL),
(4, 'jurzyk', 'u21_wiktorradzikowski@zsp1.siedlce.pl', '$2y$10$KiIq5tU4zj4DXXF0gx6djeeY3Vk3GFz0fgbZx1xInFqioMUkJt3hi', '', '', NULL, 'uzytkownik', NULL, NULL),
(5, 'andrzej', 'u21_katerynanahajevska@zsp1.sielce.pl', '$2y$10$Uzm/SEF8aZz.T2ZiEl/YTeWT1rBI6vJF5fmM6OBBeC0u56NT.U0HC', '', '', NULL, 'uzytkownik', NULL, NULL),
(6, 'jurzyczek', 'dsadsadsadsa@wp.pl', '$2y$10$PVX/4arhu/fdVnHl.dkttemlB.2wnclvMgvllUrcAb9VEOxPfPkD6', '', '', NULL, 'uzytkownik', NULL, NULL),
(7, 'dsadsadsa', 'maksym.jagodzinski@gmail.com', '$2y$10$ZJM3v2c8HypOZxrRKIE9COebXhy.bjgSIwId0wHvXEDMgMtjleADW', '', '', NULL, 'uzytkownik', NULL, NULL),
(11, 'admin_gajos', 'panbulwa11333@gmail.com', '$2y$10$kwWNXJ/iPyjFUNichz/VHuZzsUJYaPaRfxF/esfKEc21vChrUHAP.', '', '', NULL, 'admin', NULL, NULL),
(13, 'glutek', 'jarekparek02@gmail.com', '$2y$10$Gf1tcrAtQtQQ/OFB.6kePOOXjMHcgXXbAjgqQCzYy.YEOERE5La72', '', '', NULL, 'uzytkownik', NULL, NULL),
(17, 'gajos', 'u20_kacpergajowniczek@zsp1.siedlce.pl', '$2y$10$lhgY7be1lKrn715TJpfUzOaYXQ.fr2tA.xM33q3PawFEVoLU/pzZa', 'Kacper', 'Gajowniczek', NULL, 'uzytkownik', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zamowienia` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imie` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nazwisko` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_zamowienia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_uzytkownika` int DEFAULT NULL,
  `status` enum('Oczekujące','W trakcie','Zrealizowane','Anulowane') COLLATE utf8mb4_general_ci DEFAULT 'Oczekujące'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`id_zamowienia`, `username`, `email`, `imie`, `nazwisko`, `data_zamowienia`, `id_uzytkownika`, `status`) VALUES
(19, NULL, 'kacper66286@wp.pl', 'Jurzyk', 'Bąkrecki', '2024-11-24 13:38:20', NULL, 'Oczekujące'),
(20, NULL, 'jarekparek06@wp.pl', 'Duzy', 'Jurzy', '2024-11-24 13:39:39', 9, 'Oczekujące'),
(21, NULL, 'kacper66286@wp.pl', 'Jurzyk', 'Bąkrecki', '2024-11-24 13:52:50', NULL, 'Oczekujące'),
(22, NULL, 'jarekparek06@wp.pl', 'Duzy', 'Jurzy', '2024-11-24 13:57:53', 9, 'Oczekujące'),
(24, NULL, 'jarekparek06@wp.pl', 'Duzy', 'Jurzy', '2024-11-25 00:07:23', 9, 'Oczekujące'),
(25, NULL, 'jarekparek06@wp.pl', 'Duzy', 'Jurzy', '2024-11-25 01:03:12', 9, 'Oczekujące'),
(26, NULL, 'jakub.wozny@gmail.com', 'Jakub', 'Wozny', '2024-11-25 14:14:08', NULL, 'Oczekujące'),
(27, NULL, 'krystiano0107@gmail.com', 'Mia', 'khalifa', '2024-11-25 14:18:28', NULL, 'Oczekujące'),
(29, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-11-26 08:30:41', 17, 'Oczekujące'),
(30, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-11-26 09:47:25', 17, 'Oczekujące'),
(31, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-11-26 16:17:11', 17, 'Oczekujące'),
(32, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-11-27 19:26:40', 17, 'Zrealizowane'),
(33, NULL, 'aaa@aaa.pl', 'aaa', 'aaa', '2024-11-28 08:00:37', NULL, 'Oczekujące'),
(34, NULL, 'kep@gmail.com', 'jakub', 'okasja', '2024-11-28 09:02:22', 19, 'Oczekujące'),
(35, NULL, 'aaa@aaa.pl', 'aaa', 'aaa', '2024-11-28 09:04:05', NULL, 'Oczekujące'),
(36, NULL, 'bbb@gmail.com', 'bbb', 'bbb', '2024-11-28 21:18:40', NULL, 'Oczekujące'),
(37, NULL, 'aaa@aaa.pl', 'aaa', 'Tokajuk', '2024-11-29 07:52:59', NULL, 'Oczekujące'),
(38, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-11-29 16:35:11', 17, 'Oczekujące'),
(39, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-11-30 17:31:58', 17, 'Oczekujące'),
(40, NULL, 'kacper.gajowniczek02@gmail.com', 'Kacper', 'Gajowniczek', '2024-12-04 12:25:28', NULL, 'Oczekujące'),
(41, NULL, 'radzik@gmail.com', 'Kacper', 'Gajowniczek', '2024-12-04 12:27:11', 20, 'Oczekujące'),
(42, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-12-07 20:07:54', 17, 'Oczekujące'),
(43, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-12-08 13:59:13', 17, 'Oczekujące'),
(44, NULL, 'u20_kacpergajowniczek@zsp1.siedlce.pl', 'Kacper', 'Gajowniczek', '2024-12-08 16:06:24', 17, 'Oczekujące');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia_adresy`
--

CREATE TABLE `zamowienia_adresy` (
  `id_adresu` int NOT NULL,
  `id_zamowienia` int DEFAULT NULL,
  `ulica` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nr_domu` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nr_mieszkania` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `miasto` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kod_pocztowy` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia_adresy`
--

INSERT INTO `zamowienia_adresy` (`id_adresu`, `id_zamowienia`, `ulica`, `nr_domu`, `nr_mieszkania`, `miasto`, `kod_pocztowy`) VALUES
(18, 19, 'Domanicka 51', '51', '', 'Grabianów', '08-110'),
(19, 20, 'Fajowa', '14', '31', 'Siedlce', '08-110'),
(20, 21, 'Domanicka 51', '51', '', 'Siedlce', '08-110'),
(21, 22, 'Fajowa', '14', '31', 'Siedlce', '08-110'),
(23, 24, 'Fajowa', '14', '31', 'Siedlce', '08-110'),
(24, 25, 'Fajowa', '14', '31', 'Siedlce', '08-110'),
(25, 26, 'Seminaryjna', '37', '', 'Nowe Opole', '08-103'),
(26, 27, 'ostrowek', '1', '2', 'ostrowek', '08-103'),
(28, 29, 'Domanicka', '51', '', 'Siedlce', '08-110'),
(29, 30, 'Domanicka', '51', '', 'Siedlce', '08-110'),
(30, 31, 'Domanicka', '51', '', 'Siedlce', '08-110'),
(31, 32, 'Domanicka', '51', '', 'Siedlce', '08-110'),
(32, 33, 'aaa', '12', '12', 'aaa', '08-110'),
(33, 34, 'okada', '32', '21', 'q', '08-103'),
(34, 35, 'aaa', '12', '12', 'Ipsa nihil sint fac', '12-122'),
(35, 36, 'bbb', '12', '12', 'bbbb', '08-110'),
(36, 37, 'aaa', '12', '12', 'Quos elit aut error', '08-110'),
(37, 38, 'Domanicka', '51', '', 'Siedlce', '08-110'),
(38, 39, 'Domanicka', '51', '', 'Siedlce', '08-110'),
(39, 40, 'Fajna', '11', '12', 'Siedlce', '08-110'),
(40, 41, 'DOmincka', '51', '', 'Siedlce', '08-110'),
(41, 42, 'Domanicka', '51', '', 'Siedlce', '08-110'),
(42, 43, 'Domanicka', '51', '', 'Siedlce', '08-110'),
(43, 44, 'Domanicka', '51', '', 'Siedlce', '08-110');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia_produkty`
--

CREATE TABLE `zamowienia_produkty` (
  `id` int NOT NULL,
  `id_zamowienia` int NOT NULL,
  `id_produktu` int NOT NULL,
  `ilosc` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia_produkty`
--

INSERT INTO `zamowienia_produkty` (`id`, `id_zamowienia`, `id_produktu`, `ilosc`) VALUES
(19, 22, 2, 1),
(21, 24, 6, 3),
(22, 25, 2, 1),
(23, 26, 5, 1),
(24, 27, 13, 1),
(26, 29, 7, 2),
(27, 30, 18, 2),
(28, 31, 5, 3),
(29, 32, 13, 1),
(30, 33, 2, 3),
(31, 33, 18, 2),
(32, 34, 13, 1),
(34, 35, 4, 2),
(35, 35, 8, 1),
(36, 36, 18, 1),
(37, 36, 3, 1),
(38, 36, 6, 1),
(39, 36, 12, 1),
(40, 37, 9, 1),
(41, 37, 2, 1),
(44, 40, 8, 3),
(45, 40, 18, 1),
(47, 40, 10, 1),
(48, 41, 10, 1),
(49, 41, 4, 1),
(50, 42, 6, 1),
(51, 43, 2, 2),
(52, 43, 4, 3),
(53, 44, 12, 2),
(54, 44, 13, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `adresy`
--
ALTER TABLE `adresy`
  ADD PRIMARY KEY (`id_adresu`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `aktualnosci`
--
ALTER TABLE `aktualnosci`
  ADD PRIMARY KEY (`id_aktualnosci`);

--
-- Indeksy dla tabeli `dostawcy`
--
ALTER TABLE `dostawcy`
  ADD PRIMARY KEY (`id_dostawcy`),
  ADD UNIQUE KEY `nazwa_dostawcy` (`nazwa_dostawcy`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id_kategorii`),
  ADD UNIQUE KEY `nazwa_kategorii` (`nazwa_kategorii`);

--
-- Indeksy dla tabeli `kontakty`
--
ALTER TABLE `kontakty`
  ADD PRIMARY KEY (`id_kontaktu`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD PRIMARY KEY (`id_koszyka`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`),
  ADD KEY `id_produktu` (`id_produktu`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id_prac`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id_produktu`),
  ADD KEY `id_kategorii` (`id_kategorii`),
  ADD KEY `id_dostawcy` (`id_dostawcy`);

--
-- Indeksy dla tabeli `ulubione`
--
ALTER TABLE `ulubione`
  ADD PRIMARY KEY (`id_ulubione`),
  ADD UNIQUE KEY `user_product_unique` (`id_uzytkownika`,`id_produktu`),
  ADD KEY `id_produktu` (`id_produktu`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownika`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`);

--
-- Indeksy dla tabeli `zamowienia_adresy`
--
ALTER TABLE `zamowienia_adresy`
  ADD PRIMARY KEY (`id_adresu`),
  ADD KEY `id_zamowienia` (`id_zamowienia`);

--
-- Indeksy dla tabeli `zamowienia_produkty`
--
ALTER TABLE `zamowienia_produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_zamowienia` (`id_zamowienia`),
  ADD KEY `id_produktu` (`id_produktu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresy`
--
ALTER TABLE `adresy`
  MODIFY `id_adresu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `aktualnosci`
--
ALTER TABLE `aktualnosci`
  MODIFY `id_aktualnosci` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dostawcy`
--
ALTER TABLE `dostawcy`
  MODIFY `id_dostawcy` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id_kategorii` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kontakty`
--
ALTER TABLE `kontakty`
  MODIFY `id_kontaktu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `koszyk`
--
ALTER TABLE `koszyk`
  MODIFY `id_koszyka` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id_prac` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produktu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ulubione`
--
ALTER TABLE `ulubione`
  MODIFY `id_ulubione` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownika` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `zamowienia_adresy`
--
ALTER TABLE `zamowienia_adresy`
  MODIFY `id_adresu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `zamowienia_produkty`
--
ALTER TABLE `zamowienia_produkty`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adresy`
--
ALTER TABLE `adresy`
  ADD CONSTRAINT `Adresy_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id_uzytkownika`) ON DELETE CASCADE;

--
-- Constraints for table `kontakty`
--
ALTER TABLE `kontakty`
  ADD CONSTRAINT `Kontakty_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id_uzytkownika`) ON DELETE CASCADE;

--
-- Constraints for table `koszyk`
--
ALTER TABLE `koszyk`
  ADD CONSTRAINT `koszyk_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id_uzytkownika`) ON DELETE CASCADE,
  ADD CONSTRAINT `koszyk_ibfk_2` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`) ON DELETE CASCADE;

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`id_kategorii`) REFERENCES `kategorie` (`id_kategorii`) ON DELETE SET NULL,
  ADD CONSTRAINT `produkty_ibfk_2` FOREIGN KEY (`id_dostawcy`) REFERENCES `dostawcy` (`id_dostawcy`) ON DELETE SET NULL;

--
-- Constraints for table `ulubione`
--
ALTER TABLE `ulubione`
  ADD CONSTRAINT `ulubione_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id_uzytkownika`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulubione_ibfk_2` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`) ON DELETE CASCADE;

--
-- Constraints for table `zamowienia_adresy`
--
ALTER TABLE `zamowienia_adresy`
  ADD CONSTRAINT `zamowienia_adresy_ibfk_1` FOREIGN KEY (`id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`) ON DELETE CASCADE;

--
-- Constraints for table `zamowienia_produkty`
--
ALTER TABLE `zamowienia_produkty`
  ADD CONSTRAINT `zamowienia_produkty_ibfk_1` FOREIGN KEY (`id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`) ON DELETE CASCADE,
  ADD CONSTRAINT `zamowienia_produkty_ibfk_2` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
