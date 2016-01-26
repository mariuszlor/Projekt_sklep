-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Sty 2016, 08:11
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `projekt_bazy_sklep`
--
CREATE DATABASE IF NOT EXISTS `projekt_bazy_sklep` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `projekt_bazy_sklep`;

DELIMITER $$
--
-- Procedury
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `kategoria_lista_podrzednych`(IN `id_kat` INT UNSIGNED)
    NO SQL
BEGIN
DECLARE n INT;
SET n=1;
CREATE TEMPORARY TABLE podrzedne (`kategoria_id` int(10) unsigned NOT NULL,`nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `id_nadrzednej` int(10) unsigned, `przetworzona` tinyint(1) DEFAULT 0);
CREATE TEMPORARY TABLE podrzedne2 (`kategoria_id` int(10) unsigned NOT NULL,`nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `id_nadrzednej` int(10) unsigned, `przetworzona` tinyint(1) DEFAULT 0);

INSERT INTO podrzedne SELECT kategoria_id, nazwa, id_nadrzednej, 0 FROM kategoria WHERE kategoria_id=id_kat;

WHILE n>0 DO
INSERT INTO podrzedne2 SELECT kategoria_id, nazwa, id_nadrzednej, 0 FROM kategoria WHERE id_nadrzednej IN (SELECT kategoria_id FROM podrzedne WHERE przetworzona=0);
UPDATE podrzedne SET przetworzona=1;
INSERT INTO podrzedne SELECT * FROM podrzedne2;
TRUNCATE TABLE podrzedne2;
SELECT COUNT(*) FROM podrzedne WHERE przetworzona=0 INTO n;
END WHILE;

SELECT * FROM podrzedne;

DROP TEMPORARY TABLE podrzedne;
DROP TEMPORARY TABLE podrzedne2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `menu_drzewo_kat`(IN `pkat_id` INT)
    READS SQL DATA
BEGIN
DECLARE kat_id INT;
IF pkat_id IS NOT NULL THEN
SET kat_id = pkat_id;
WHILE kat_id IS NOT NULL DO
SELECT * FROM kategoria WHERE id_nadrzednej=kat_id;
SELECT id_nadrzednej FROM kategoria WHERE kategoria_id=kat_id INTO kat_id;
END WHILE;
END IF;
SELECT * FROM kategoria WHERE id_nadrzednej IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `produkt_by_kategoria`(IN `id_kat` INT UNSIGNED)
    NO SQL
BEGIN
DECLARE n INT;
SET n=1;
CREATE TEMPORARY TABLE podrzedne (`kategoria_id` int(10) unsigned NOT NULL, `przetworzona` tinyint(1) DEFAULT 0);
CREATE TEMPORARY TABLE podrzedne2 (`kategoria_id` int(10) unsigned NOT NULL, `przetworzona` tinyint(1) DEFAULT 0);

INSERT INTO podrzedne VALUES(id_kat,0);

WHILE n>0 DO
INSERT INTO podrzedne2 SELECT kategoria_id, 0 FROM kategoria WHERE id_nadrzednej IN (SELECT kategoria_id FROM podrzedne WHERE przetworzona=0);
UPDATE podrzedne SET przetworzona=1;
INSERT INTO podrzedne SELECT * FROM podrzedne2;
TRUNCATE TABLE podrzedne2;
SELECT COUNT(*) FROM podrzedne WHERE przetworzona=0 INTO n;
END WHILE;

SELECT p.produkt_id, p.nazwa, p.kategoria_id, k.nazwa AS nazwa_kat  FROM produkt p JOIN kategoria k USING(kategoria_id) WHERE p.blokada=0 AND k.kategoria_id IN (SELECT kategoria_id FROM podrzedne);

DROP TEMPORARY TABLE podrzedne;
DROP TEMPORARY TABLE podrzedne2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `produkt_hist`(IN `pprodukt_edycja_id` INT UNSIGNED)
    NO SQL
BEGIN
DECLARE vprodukt_id INT;
DECLARE poprz_nazwa VARCHAR(50);
DECLARE poprz_cena DECIMAL(10,2);
DECLARE poprz_opis TEXT;
DECLARE poprz_blokada TINYINT(1);
SELECT produkt_id INTO vprodukt_id FROM produkt_edycja WHERE produkt_edycja_id=pprodukt_edycja_id;
SELECT poprz_wartosc INTO poprz_nazwa FROM produkt_edycja WHERE produkt_edycja_id>pprodukt_edycja_id AND produkt_id=vprodukt_id AND kolumna='nazwa' ORDER BY produkt_edycja_id ASC LIMIT 1;
SELECT poprz_wartosc INTO poprz_cena FROM produkt_edycja WHERE produkt_edycja_id>pprodukt_edycja_id AND produkt_id=vprodukt_id AND kolumna='cena' ORDER BY produkt_edycja_id ASC LIMIT 1;
SELECT poprz_wartosc INTO poprz_opis FROM produkt_edycja WHERE produkt_edycja_id>pprodukt_edycja_id AND produkt_id=vprodukt_id AND kolumna='opis' ORDER BY produkt_edycja_id ASC LIMIT 1;
SELECT poprz_wartosc INTO poprz_blokada FROM produkt_edycja WHERE produkt_edycja_id>pprodukt_edycja_id AND produkt_id=vprodukt_id AND kolumna='blokada' ORDER BY produkt_edycja_id ASC LIMIT 1;

SELECT COALESCE(poprz_nazwa,nazwa) AS nazwa, COALESCE(poprz_cena,cena) AS cena, COALESCE(poprz_opis,opis) AS opis, COALESCE(poprz_blokada,blokada) AS blokada FROM produkt WHERE produkt_id=vprodukt_id; 
END$$

--
-- Funkcje
--
CREATE DEFINER=`root`@`localhost` FUNCTION `ostatnia_produkt_edycja_id`(`produktid` INT(10) UNSIGNED) RETURNS int(10) unsigned
    NO SQL
RETURN (SELECT MAX(`produkt_edycja_id`) FROM `produkt_edycja` WHERE `produkt_id`=produktid)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria`
--

CREATE TABLE IF NOT EXISTS `kategoria` (
  `kategoria_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL DEFAULT 'Nieznana',
  `id_nadrzednej` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`kategoria_id`),
  UNIQUE KEY `unique_subcategory` (`nazwa`,`id_nadrzednej`),
  KEY `fk_id_nadrzednej` (`id_nadrzednej`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=302 ;

--
-- Zrzut danych tabeli `kategoria`
--

INSERT INTO `kategoria` (`kategoria_id`, `nazwa`, `id_nadrzednej`) VALUES
(260, 'Akcesoria kuchenne', NULL),
(281, 'Blachy', 257),
(283, 'Chlebaki', 272),
(255, 'Czajniki', NULL),
(276, 'Ekspresy do kawy', 254),
(299, 'Elektryczne', 277),
(264, 'Fartuchy', 260),
(279, 'Formy', 257),
(253, 'Garnki i patelnie', NULL),
(274, 'Grille elektryczne', 254),
(254, 'Małe AGD', NULL),
(278, 'Miksery i blendery', 254),
(287, 'Młynki do kawy', 254),
(258, 'Moździeże', NULL),
(262, 'Obieraki', 260),
(270, 'Ociekacze', 259),
(257, 'Pieczenie', NULL),
(282, 'Pojemniki', 272),
(272, 'Pojemniki kuchenne i chlebaki', NULL),
(298, 'Przeciwpancerne', 258),
(297, 'Przeciwpiechotne', 258),
(265, 'Rękawice', 260),
(275, 'Roboty kuchenne', 254),
(280, 'Stolnice i wałki', 257),
(269, 'Szczotki', 259),
(271, 'Szmatki', 259),
(268, 'Środki czystości', 259),
(263, 'Tarki', 260),
(267, 'Termometry', 260),
(301, 'Test2', 277),
(284, 'Torebki na żywność', 272),
(277, 'Tostery', 254),
(259, 'Wokół zlewu', NULL),
(261, 'Wyciskacze i praski', 260),
(285, 'Zamknięcia do torebek', 272);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klient`
--

CREATE TABLE IF NOT EXISTS `klient` (
  `klient_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typ` enum('p','f') COLLATE utf8_polish_ci NOT NULL DEFAULT 'p',
  `nazwisko` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `imie` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `NIP` bigint(20) DEFAULT NULL,
  `nazwa_firmy` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `dom_adr_wys` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`klient_id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `klient`
--

INSERT INTO `klient` (`klient_id`, `typ`, `nazwisko`, `imie`, `NIP`, `nazwa_firmy`, `dom_adr_wys`, `login`, `haslo`) VALUES
(1, 'p', 'Lorek', 'Mariusz', NULL, NULL, NULL, 'admin', 's0JPF/hkECV73tIZNLyew.yPgMbCNz2'),
(2, 'p', 'Jabłoński', 'Piotr', 56789987653456789, 'Testowa firma', 'Piotr Jabłoński\r\nMęcina 617\r\n34-654 Męcina', 'test', '9jl3qYhggtgH9DZ.dQjzSnGyrRmUKce'),
(3, 'f', 'Testowe nazwisko', 'Testowe imie', NULL, 'testowa nazwa firmy', NULL, 'testf', 'h3gFujI8fjClkHw3.7NYbvICza0ZLFS'),
(4, 'p', 't', NULL, NULL, NULL, NULL, 'test2', 'sml09kEiOG7hKbc/8F7mD0kmRxfx/Ta'),
(5, 'p', 'Testowe', 'Testowe ', NULL, NULL, 'Piekiełko 66', 'TestUpr', 'vfiKveEskxDOavuHH6rkQigKlEdjQui'),
(8, 'p', NULL, NULL, NULL, NULL, NULL, 'tesdsF', 'h3gFujI8fjClkHw3.7NYbvICza0ZLFS');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownik`
--

CREATE TABLE IF NOT EXISTS `pracownik` (
  `pracownik_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `uprawnienia` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`pracownik_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `pracownik`
--

INSERT INTO `pracownik` (`pracownik_id`, `login`, `haslo`, `uprawnienia`) VALUES
(1, 'administrator', 's0JPF/hkECV73tIZNLyew.yPgMbCNz2', 'pracownik;kategoria;produkt;wysyłka;raport;klient');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownik_uprawnienie`
--

CREATE TABLE IF NOT EXISTS `pracownik_uprawnienie` (
  `pracownik_id` int(10) unsigned DEFAULT NULL,
  `uprawnienie` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  KEY `pracownik_id_i` (`pracownik_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pracownik_uprawnienie`
--

INSERT INTO `pracownik_uprawnienie` (`pracownik_id`, `uprawnienie`) VALUES
(1, 'pracownik'),
(1, 'kategoria'),
(1, 'produkt'),
(1, 'wysyłka'),
(1, 'raport'),
(1, 'klient');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkt`
--

CREATE TABLE IF NOT EXISTS `produkt` (
  `produkt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `kategoria_id` int(10) unsigned DEFAULT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  `stan_magazyn` int(10) unsigned NOT NULL DEFAULT '0',
  `cena` decimal(10,2) unsigned NOT NULL,
  `blokada` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`produkt_id`),
  KEY `product_category` (`kategoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=15 ;

--
-- Zrzut danych tabeli `produkt`
--

INSERT INTO `produkt` (`produkt_id`, `nazwa`, `kategoria_id`, `opis`, `stan_magazyn`, `cena`, `blokada`) VALUES
(10, 'Pierwszy dodany produkt', 260, '<p>Pierwszy dodany opis</p>\r\n', 34, '99.76', 0),
(11, 'Drugi dodany produkt', 263, '<p>Tutaj jakiś&nbsp;<strong>ciekawy</strong>&nbsp;opis produktu</p>\r\n', 54, '12.00', 0),
(12, 'Trzeci prodkut', 276, '<p>fjsfj dhjkfsda jfdsa jfdsjla jlfajsk l</p>\r\n', 2, '120.00', 0),
(13, 'Produkt z historią edycji i zmienioną nazwą', 276, '<p>Pierwszy opis produktu ze sprawdzaną&nbsp;historią edycji.</p>\r\n\r\n<p>Tu jest</p>\r\n\r\n<p>drugi akapi</p>\r\n\r\n<p>tekstu</p>\r\n', 10, '79.99', 0),
(14, 'Produkt testujący uprawnienia produktu', NULL, '<p>ABC def test</p>\r\n', 399, '999.66', 0);

--
-- Wyzwalacze `produkt`
--
DROP TRIGGER IF EXISTS `produkt_insert_hist`;
DELIMITER //
CREATE TRIGGER `produkt_insert_hist` AFTER INSERT ON `produkt`
 FOR EACH ROW INSERT INTO produkt_edycja (produkt_id, kolumna, pracownik_id)
VALUES (NEW.produkt_id, 'dodanie', @pracownikid)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `produkt_update_hist`;
DELIMITER //
CREATE TRIGGER `produkt_update_hist` BEFORE UPDATE ON `produkt`
 FOR EACH ROW BEGIN
IF NEW.nazwa!=OLD.nazwa THEN
	INSERT INTO produkt_edycja (produkt_id, kolumna, poprz_wartosc, pracownik_id)
        VALUES (NEW.produkt_id, 'nazwa', OLD.nazwa, @pracownikid);
END IF;
IF NEW.opis!=OLD.opis THEN
	INSERT INTO produkt_edycja (produkt_id, kolumna, poprz_wartosc, pracownik_id)
        VALUES (NEW.produkt_id, 'opis', OLD.opis, @pracownikid);
END IF;
IF NEW.cena!=OLD.cena THEN
	INSERT INTO produkt_edycja (produkt_id, kolumna, poprz_wartosc, pracownik_id)
        VALUES (NEW.produkt_id, 'cena', OLD.cena, @pracownikid);
END IF;
IF NEW.blokada!=OLD.blokada THEN
	INSERT INTO produkt_edycja (produkt_id, kolumna, poprz_wartosc, pracownik_id)
        VALUES (NEW.produkt_id, 'blokada', OLD.blokada, @pracownikid);
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkt_edycja`
--

CREATE TABLE IF NOT EXISTS `produkt_edycja` (
  `produkt_edycja_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `produkt_id` int(10) unsigned NOT NULL,
  `kolumna` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `poprz_wartosc` text COLLATE utf8_polish_ci NOT NULL,
  `czas_edycji` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pracownik_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`produkt_edycja_id`),
  KEY `fk_produkt_id` (`produkt_id`),
  KEY `fk_pracownik_id` (`pracownik_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=31 ;

--
-- Zrzut danych tabeli `produkt_edycja`
--

INSERT INTO `produkt_edycja` (`produkt_edycja_id`, `produkt_id`, `kolumna`, `poprz_wartosc`, `czas_edycji`, `pracownik_id`) VALUES
(18, 10, 'dodanie', '', '2016-01-17 15:30:00', 1),
(19, 11, 'dodanie', '', '2016-01-17 15:30:45', 1),
(20, 12, 'dodanie', '', '2016-01-17 15:31:25', 1),
(21, 13, 'dodanie', '', '2016-01-23 15:42:05', 1),
(22, 13, 'opis', '<p>Pierwszy opis produktu ze sprawdzaną&nbsp;historią edycji</p>\n', '2016-01-23 15:43:40', 1),
(23, 13, 'cena', '9.99', '2016-01-23 15:43:40', 1),
(24, 13, 'opis', '<p>Pierwszy opis produktu ze sprawdzaną&nbsp;historią edycji.</p>\n', '2016-01-23 15:45:38', 1),
(25, 13, 'nazwa', 'Produkt z historią edycji', '2016-01-23 15:49:28', 1),
(26, 13, 'cena', '19.99', '2016-01-23 15:50:13', 1),
(27, 14, 'dodanie', '', '2016-01-25 10:35:59', 1),
(28, 14, 'nazwa', 'Produkt testujący uprawnienia', '2016-01-25 10:36:23', 1),
(29, 14, 'opis', '<p>ABC def</p>\r\n', '2016-01-25 10:36:23', 1),
(30, 14, 'cena', '99.65', '2016-01-25 10:36:23', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transakcja`
--

CREATE TABLE IF NOT EXISTS `transakcja` (
  `transakcja_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `klient_id` int(10) unsigned DEFAULT NULL,
  `adres_wysylki` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `kwota_wplacona` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('u','a','p','z','w','d') COLLATE utf8_polish_ci NOT NULL DEFAULT 'u',
  PRIMARY KEY (`transakcja_id`),
  KEY `fk_klient_id` (`klient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `transakcja`
--

INSERT INTO `transakcja` (`transakcja_id`, `klient_id`, `adres_wysylki`, `kwota_wplacona`, `status`) VALUES
(2, NULL, '', '0.00', 'u'),
(3, NULL, '', '0.00', 'u');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transakcja_produkt_v`
--

CREATE TABLE IF NOT EXISTS `transakcja_produkt_v` (
  `transakcja_id` int(10) unsigned NOT NULL,
  `sztuk` tinyint(3) unsigned NOT NULL,
  `produkt_edycja_id` int(10) unsigned NOT NULL,
  KEY `fk_transakcja_id` (`transakcja_id`),
  KEY `fk_produkt_edycja_id` (`produkt_edycja_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `transakcja_produkt_v`
--

INSERT INTO `transakcja_produkt_v` (`transakcja_id`, `sztuk`, `produkt_edycja_id`) VALUES
(2, 1, 20),
(2, 3, 26),
(3, 1, 20),
(3, 1, 26);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD CONSTRAINT `kategoria_ibfk_1` FOREIGN KEY (`id_nadrzednej`) REFERENCES `kategoria` (`kategoria_id`);

--
-- Ograniczenia dla tabeli `pracownik_uprawnienie`
--
ALTER TABLE `pracownik_uprawnienie`
  ADD CONSTRAINT `pracownik_uprawnienie_ibfk_1` FOREIGN KEY (`pracownik_id`) REFERENCES `pracownik` (`pracownik_id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_2` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`kategoria_id`) ON DELETE SET NULL;

--
-- Ograniczenia dla tabeli `produkt_edycja`
--
ALTER TABLE `produkt_edycja`
  ADD CONSTRAINT `produkt_edycja_ibfk_1` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`),
  ADD CONSTRAINT `produkt_edycja_ibfk_2` FOREIGN KEY (`pracownik_id`) REFERENCES `pracownik` (`pracownik_id`);

--
-- Ograniczenia dla tabeli `transakcja`
--
ALTER TABLE `transakcja`
  ADD CONSTRAINT `transakcja_ibfk_2` FOREIGN KEY (`klient_id`) REFERENCES `klient` (`klient_id`) ON DELETE SET NULL;

--
-- Ograniczenia dla tabeli `transakcja_produkt_v`
--
ALTER TABLE `transakcja_produkt_v`
  ADD CONSTRAINT `transakcja_produkt_v_ibfk_1` FOREIGN KEY (`transakcja_id`) REFERENCES `transakcja` (`transakcja_id`),
  ADD CONSTRAINT `transakcja_produkt_v_ibfk_2` FOREIGN KEY (`produkt_edycja_id`) REFERENCES `produkt_edycja` (`produkt_edycja_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
