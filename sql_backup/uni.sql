-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 04. Mrz 2024 um 20:04
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `uni`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adresse`
--

CREATE TABLE `adresse` (
  `Adress_ID` int(11) NOT NULL,
  `Straße` char(64) DEFAULT NULL,
  `Hausnummer` char(64) DEFAULT NULL,
  `PLZ` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `adresse`
--

INSERT INTO `adresse` (`Adress_ID`, `Straße`, `Hausnummer`, `PLZ`) VALUES
(1, 'Münsterstr', '44', '48308'),
(2, 'Liboristr', '13', '48155');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beinhaltet`
--

CREATE TABLE `beinhaltet` (
  `Studi_ID` int(11) NOT NULL,
  `Modul_ID` int(11) NOT NULL,
  `Semester` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `beinhaltet`
--

INSERT INTO `beinhaltet` (`Studi_ID`, `Modul_ID`, `Semester`) VALUES
(1, 1, 'Sommer 2024');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `ID` int(11) NOT NULL,
  `Passwort` char(64) DEFAULT NULL,
  `Benutzername` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer_id`
--

CREATE TABLE `benutzer_id` (
  `Ben_ID` int(11) NOT NULL,
  `Roll_ID` int(11) NOT NULL,
  `student_ID` int(11) DEFAULT NULL,
  `dozent_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dozent`
--

CREATE TABLE `dozent` (
  `Dozi_ID` int(11) NOT NULL,
  `Name` char(64) DEFAULT NULL,
  `Vorname` char(64) DEFAULT NULL,
  `Geburtsdatum` date NOT NULL,
  `Geschlecht` char(64) DEFAULT NULL,
  `Konfession` char(64) DEFAULT NULL,
  `Staatsangehörigkeit` char(64) DEFAULT NULL,
  `Adress_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `konkrete_veranstaltung`
--

CREATE TABLE `konkrete_veranstaltung` (
  `KonVer_ID` int(11) NOT NULL,
  `Datum` date DEFAULT NULL,
  `Veranstaltungs_ID` int(11) NOT NULL,
  `Semi_ID` int(11) NOT NULL,
  `Dozi_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modul`
--

CREATE TABLE `modul` (
  `Modul_ID` int(11) NOT NULL,
  `Bezeichnung` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `modul`
--

INSERT INTO `modul` (`Modul_ID`, `Bezeichnung`) VALUES
(1, 'Informatik II');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plz`
--

CREATE TABLE `plz` (
  `PLZ` char(64) NOT NULL,
  `Ort` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `plz`
--

INSERT INTO `plz` (`PLZ`, `Ort`) VALUES
('48155', 'Münster'),
('48308', 'Senden');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rollen`
--

CREATE TABLE `rollen` (
  `Roll_ID` int(11) NOT NULL,
  `Rolle` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `rollen`
--

INSERT INTO `rollen` (`Roll_ID`, `Rolle`) VALUES
(1, 'student'),
(2, 'dozent'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `semster`
--

CREATE TABLE `semster` (
  `Semi_ID` int(11) NOT NULL,
  `Jahr` char(64) DEFAULT NULL,
  `Semester` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `semster`
--

INSERT INTO `semster` (`Semi_ID`, `Jahr`, `Semester`) VALUES
(1, '2024', 'Sommer');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `student`
--

CREATE TABLE `student` (
  `Matrikelnummer` int(11) NOT NULL,
  `Name` char(64) DEFAULT NULL,
  `Vorname` char(64) DEFAULT NULL,
  `Geburtsdatum` date NOT NULL,
  `Geschlecht` char(64) DEFAULT NULL,
  `Konfession` char(64) DEFAULT NULL,
  `Staatsangehörigkeit` char(64) DEFAULT NULL,
  `Adress_ID` int(11) NOT NULL,
  `Studi_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Studierender';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `student_konver`
--

CREATE TABLE `student_konver` (
  `KonVer_ID` int(11) NOT NULL,
  `Matrikelnummer` int(11) NOT NULL,
  `Note` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `studiengang`
--

CREATE TABLE `studiengang` (
  `Studi_ID` int(11) NOT NULL,
  `Bezeichnung` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `studiengang`
--

INSERT INTO `studiengang` (`Studi_ID`, `Bezeichnung`) VALUES
(1, 'Informatik');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `veranstaltung`
--

CREATE TABLE `veranstaltung` (
  `Veranstaltungs_ID` int(11) NOT NULL,
  `Bezeichnung` char(64) DEFAULT NULL,
  `CP` char(64) DEFAULT NULL,
  `Modul_ID` int(11) NOT NULL,
  `Art_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `veranstaltung`
--

INSERT INTO `veranstaltung` (`Veranstaltungs_ID`, `Bezeichnung`, `CP`, `Modul_ID`, `Art_ID`) VALUES
(1, 'Datenbanken', '8', 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `veranstaltungsart`
--

CREATE TABLE `veranstaltungsart` (
  `Art_ID` int(11) NOT NULL,
  `Art` char(64) DEFAULT NULL,
  `Beschreibung` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `veranstaltungsart`
--

INSERT INTO `veranstaltungsart` (`Art_ID`, `Art`, `Beschreibung`) VALUES
(1, 'Vorlesung', 'Dozent erklärt ein thema'),
(2, 'Übung', 'Praktische anwendung von erlangten wissen aus den Vorlesung'),
(3, 'Modul Prüfung', 'Finale Prüfung');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`Adress_ID`),
  ADD KEY `PLZ` (`PLZ`);

--
-- Indizes für die Tabelle `beinhaltet`
--
ALTER TABLE `beinhaltet`
  ADD PRIMARY KEY (`Studi_ID`,`Modul_ID`),
  ADD KEY `Modul_ID` (`Modul_ID`);

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indizes für die Tabelle `benutzer_id`
--
ALTER TABLE `benutzer_id`
  ADD PRIMARY KEY (`Ben_ID`),
  ADD KEY `student_ID` (`student_ID`),
  ADD KEY `Roll_ID` (`Roll_ID`) USING BTREE,
  ADD KEY `dozent_ID` (`dozent_ID`);

--
-- Indizes für die Tabelle `dozent`
--
ALTER TABLE `dozent`
  ADD PRIMARY KEY (`Dozi_ID`),
  ADD KEY `Adress_ID` (`Adress_ID`);

--
-- Indizes für die Tabelle `konkrete_veranstaltung`
--
ALTER TABLE `konkrete_veranstaltung`
  ADD PRIMARY KEY (`KonVer_ID`),
  ADD KEY `Veranstaltungs_ID` (`Veranstaltungs_ID`),
  ADD KEY `Semi_ID` (`Semi_ID`),
  ADD KEY `Dozi_ID` (`Dozi_ID`);

--
-- Indizes für die Tabelle `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`Modul_ID`);

--
-- Indizes für die Tabelle `plz`
--
ALTER TABLE `plz`
  ADD PRIMARY KEY (`PLZ`);

--
-- Indizes für die Tabelle `rollen`
--
ALTER TABLE `rollen`
  ADD PRIMARY KEY (`Roll_ID`);

--
-- Indizes für die Tabelle `semster`
--
ALTER TABLE `semster`
  ADD PRIMARY KEY (`Semi_ID`);

--
-- Indizes für die Tabelle `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Matrikelnummer`),
  ADD KEY `Studi_ID` (`Studi_ID`),
  ADD KEY `Adress_ID` (`Adress_ID`);

--
-- Indizes für die Tabelle `student_konver`
--
ALTER TABLE `student_konver`
  ADD PRIMARY KEY (`KonVer_ID`,`Matrikelnummer`),
  ADD KEY `Matrikelnummer` (`Matrikelnummer`);

--
-- Indizes für die Tabelle `studiengang`
--
ALTER TABLE `studiengang`
  ADD PRIMARY KEY (`Studi_ID`);

--
-- Indizes für die Tabelle `veranstaltung`
--
ALTER TABLE `veranstaltung`
  ADD PRIMARY KEY (`Veranstaltungs_ID`),
  ADD KEY `Modul_ID` (`Modul_ID`),
  ADD KEY `Art_ID` (`Art_ID`);

--
-- Indizes für die Tabelle `veranstaltungsart`
--
ALTER TABLE `veranstaltungsart`
  ADD PRIMARY KEY (`Art_ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `adresse`
--
ALTER TABLE `adresse`
  MODIFY `Adress_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `benutzer_id`
--
ALTER TABLE `benutzer_id`
  MODIFY `Ben_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `dozent`
--
ALTER TABLE `dozent`
  MODIFY `Dozi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `konkrete_veranstaltung`
--
ALTER TABLE `konkrete_veranstaltung`
  MODIFY `KonVer_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `modul`
--
ALTER TABLE `modul`
  MODIFY `Modul_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `rollen`
--
ALTER TABLE `rollen`
  MODIFY `Roll_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `semster`
--
ALTER TABLE `semster`
  MODIFY `Semi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `student`
--
ALTER TABLE `student`
  MODIFY `Matrikelnummer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `studiengang`
--
ALTER TABLE `studiengang`
  MODIFY `Studi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `veranstaltung`
--
ALTER TABLE `veranstaltung`
  MODIFY `Veranstaltungs_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `veranstaltungsart`
--
ALTER TABLE `veranstaltungsart`
  MODIFY `Art_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `adresse_ibfk_1` FOREIGN KEY (`PLZ`) REFERENCES `plz` (`PLZ`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints der Tabelle `beinhaltet`
--
ALTER TABLE `beinhaltet`
  ADD CONSTRAINT `beinhaltet_ibfk_1` FOREIGN KEY (`Studi_ID`) REFERENCES `studiengang` (`Studi_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beinhaltet_ibfk_2` FOREIGN KEY (`Modul_ID`) REFERENCES `modul` (`Modul_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD CONSTRAINT `Ben_ID` FOREIGN KEY (`ID`) REFERENCES `benutzer_id` (`Ben_ID`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `benutzer_id`
--
ALTER TABLE `benutzer_id`
  ADD CONSTRAINT `Roll_ID` FOREIGN KEY (`Roll_ID`) REFERENCES `rollen` (`Roll_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dozent_ID` FOREIGN KEY (`dozent_ID`) REFERENCES `dozent` (`Dozi_ID`),
  ADD CONSTRAINT `student_ID` FOREIGN KEY (`student_ID`) REFERENCES `student` (`Matrikelnummer`);

--
-- Constraints der Tabelle `dozent`
--
ALTER TABLE `dozent`
  ADD CONSTRAINT `dozent_ibfk_2` FOREIGN KEY (`Adress_ID`) REFERENCES `adresse` (`Adress_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints der Tabelle `konkrete_veranstaltung`
--
ALTER TABLE `konkrete_veranstaltung`
  ADD CONSTRAINT `konkrete_veranstaltung_ibfk_1` FOREIGN KEY (`Veranstaltungs_ID`) REFERENCES `veranstaltung` (`Veranstaltungs_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `konkrete_veranstaltung_ibfk_2` FOREIGN KEY (`Semi_ID`) REFERENCES `semster` (`Semi_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `konkrete_veranstaltung_ibfk_3` FOREIGN KEY (`Dozi_ID`) REFERENCES `dozent` (`Dozi_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints der Tabelle `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`Studi_ID`) REFERENCES `studiengang` (`Studi_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`Adress_ID`) REFERENCES `adresse` (`Adress_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints der Tabelle `student_konver`
--
ALTER TABLE `student_konver`
  ADD CONSTRAINT `student_konver_ibfk_1` FOREIGN KEY (`KonVer_ID`) REFERENCES `konkrete_veranstaltung` (`KonVer_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_konver_ibfk_2` FOREIGN KEY (`Matrikelnummer`) REFERENCES `student` (`Matrikelnummer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `veranstaltung`
--
ALTER TABLE `veranstaltung`
  ADD CONSTRAINT `veranstaltung_ibfk_1` FOREIGN KEY (`Modul_ID`) REFERENCES `modul` (`Modul_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `veranstaltung_ibfk_2` FOREIGN KEY (`Art_ID`) REFERENCES `veranstaltungsart` (`Art_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
