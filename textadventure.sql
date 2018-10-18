-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 18 okt 2018 kl 11:08
-- Serverversion: 10.1.29-MariaDB
-- PHP-version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `textadventure`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `story`
--

CREATE TABLE `story` (
  `id` int(16) UNSIGNED NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `place` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `story`
--

INSERT INTO `story` (`id`, `text`, `place`) VALUES
(1, 'Vem gillar du?', 'Festen'),
(2, 'Synd, personen gillar inte dig och du kommer dö ensam.', 'Festen'),
(3, 'Är du säker på det?', 'Festen'),
(4, 'Du spenderar ditt liv lycklig och ensam. Du dör tids nog lyckligt där du vill vara, med dig själv.', 'Hus på landet'),
(5, 'Jag förstår dig, alla älskar ju honom. Tyvärr är Jörgen inte tillgänglig för dig.', 'Festen'),
(6, 'Vad kul för dig! Vill du försöka hitta en person som du kan spendera ditt liv med?', 'Festen'),
(7, 'Du går ut i världen och vandrar 805 km och sedan 805 km till, vilket leder dig till en dörr. Där knackar du på, men ingen svarar. Du känner hur marken börjar röra på sig och det öppnas en fallucka under dina fötter. Du ramlar ner och ser dig omkring och du får syn på tre andra personer. Det är dina bekanta Violetta, Doktorn och Flora. Vad gör du?', 'Världen'),
(8, 'Violetta börjar gå mot dig med bestämda steg samtidigt som doktorn och Flora försvinner in i mörkret så du inte ser dem längre. Violetta sträcker fram hennes vänstra hand och lägger den på din axel. Hon vill säkert ha en kram då hon inte träffat dig på länge. Hon sträcker fram andra handen och omfamnar dig och börjar fråga hur du haft det, hur du mår och hur du kom hit.', 'Grottan');

-- --------------------------------------------------------

--
-- Tabellstruktur `storylinks`
--

CREATE TABLE `storylinks` (
  `id` int(16) UNSIGNED NOT NULL,
  `storyid` int(10) UNSIGNED NOT NULL,
  `target` int(10) UNSIGNED NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `storylinks`
--

INSERT INTO `storylinks` (`id`, `storyid`, `target`, `text`) VALUES
(1, 1, 5, 'Jörgen'),
(2, 1, 2, 'Violetta'),
(3, 1, 2, 'Doktorn'),
(4, 1, 3, 'Dig Själv'),
(5, 3, 6, 'Ja!'),
(6, 3, 1, 'Nej'),
(7, 6, 4, 'Nej, jag vill leva ensam.'),
(8, 6, 7, 'Ja, jag vill leta efter någon att spendera mitt liv med.'),
(9, 7, 8, 'Närma dig dina bekanta.'),
(10, 7, 8, 'Försöka leta efter en väg ut.'),
(11, 8, 9, '\"Jag har haft det bara bra och jag mår bra. Jag kom hit via att jag vandrade dag och natt, sammanlagt 1610 km långt.\"');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `storylinks`
--
ALTER TABLE `storylinks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `storyid` (`storyid`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `story`
--
ALTER TABLE `story`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT för tabell `storylinks`
--
ALTER TABLE `storylinks`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
