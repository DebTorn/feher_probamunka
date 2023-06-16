-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Jún 16. 10:04
-- Kiszolgáló verziója: 10.4.25-MariaDB
-- PHP verzió: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `probamunka`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `chat`
--

CREATE TABLE `chat` (
  `userId` int(11) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `sent` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `nev` varchar(255) NOT NULL,
  `csaladi_allapot` enum('egyedulallo','hazas','elvalt') NOT NULL,
  `szuletesi_ido` date DEFAULT NULL,
  `weboldal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `chat`
--
ALTER TABLE `chat`
  ADD KEY `user_chat_kotes` (`userId`);

--
-- A tábla indexei `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `user_chat_kotes` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
