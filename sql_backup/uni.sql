-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2024 at 01:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uni`
--

-- --------------------------------------------------------

--
-- Table structure for table `adresse`
--

CREATE TABLE `adresse` (
  `Adress_ID` int(11) NOT NULL,
  `Straße` char(64) DEFAULT NULL,
  `Hausnummer` char(64) DEFAULT NULL,
  `PLZ` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adresse`
--

INSERT INTO `adresse` (`Adress_ID`, `Straße`, `Hausnummer`, `PLZ`) VALUES
(1, 'Münsterstr', '44', '48308'),
(12, 'Wagnerstr', '25', '48308'),
(13, 'asdfas', 'asdf', 'asdf'),
(14, 'hsdgfh', 'dfghj', 'dfgh');

-- --------------------------------------------------------

--
-- Table structure for table `beinhaltet`
--

CREATE TABLE `beinhaltet` (
  `Studi_ID` int(11) NOT NULL,
  `Modul_ID` int(11) NOT NULL,
  `Semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beinhaltet`
--

INSERT INTO `beinhaltet` (`Studi_ID`, `Modul_ID`, `Semester`) VALUES
(1, 14, 1),
(3, 14, 1),
(3, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `benutzer`
--

CREATE TABLE `benutzer` (
  `ID` int(11) NOT NULL,
  `Passwort` char(64) DEFAULT NULL,
  `Benutzername` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `benutzer`
--

INSERT INTO `benutzer` (`ID`, `Passwort`, `Benutzername`) VALUES
(14, '384a701fab293a9df630a868c0d640caee9a965a8285b740039c9c0eefb15574', 'john_admin'),
(15, '80e3256d6b727f939ff0f0541d3aa8dbdea2ae6365a02762668304c0ca4a9c26', 'john'),
(16, '0f35bccadf2f265dea8d5c443650ae09b884547b226fd71e9ed9b2d65ef22d58', 'john_2'),
(19, 'e1cc83f98b05ca35a13732e323ab44c98b8198f8072ff655b990f93fc98d286a', 'kreutzer6969'),
(22, 'a726bea9419cfb20742016a7537b7730cf50765ead745fa64112fa5d4b0e5013', 'john_student'),
(23, '111457ce72d0ec36c88cd517243a3280932b901c9566c0dfd831101ae1591fc0', 'john_dozi'),
(45, 'bc71954721b0886a04c83f58cfd75fed34430c40d0bccc49720b969912a4a93b', 'john_22');

-- --------------------------------------------------------

--
-- Table structure for table `benutzer_id`
--

CREATE TABLE `benutzer_id` (
  `Ben_ID` int(11) NOT NULL,
  `Roll_ID` int(11) NOT NULL,
  `student_ID` int(11) DEFAULT NULL,
  `dozent_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `benutzer_id`
--

INSERT INTO `benutzer_id` (`Ben_ID`, `Roll_ID`, `student_ID`, `dozent_ID`) VALUES
(14, 3, NULL, NULL),
(15, 1, 18, NULL),
(16, 2, NULL, 8),
(19, 3, NULL, NULL),
(22, 1, 19, NULL),
(23, 2, NULL, 11),
(24, 3, NULL, NULL),
(25, 3, NULL, NULL),
(26, 3, NULL, NULL),
(27, 3, NULL, NULL),
(28, 3, NULL, NULL),
(29, 3, NULL, NULL),
(30, 3, NULL, NULL),
(31, 3, NULL, NULL),
(32, 3, NULL, NULL),
(33, 3, NULL, NULL),
(34, 3, NULL, NULL),
(35, 3, NULL, NULL),
(36, 3, NULL, NULL),
(37, 3, NULL, NULL),
(38, 3, NULL, NULL),
(39, 3, NULL, NULL),
(40, 3, NULL, NULL),
(41, 3, NULL, NULL),
(42, 3, NULL, NULL),
(43, 3, NULL, NULL),
(44, 3, NULL, NULL),
(45, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dozent`
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

--
-- Dumping data for table `dozent`
--

INSERT INTO `dozent` (`Dozi_ID`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Adress_ID`) VALUES
(8, 'john', 'john', '1212-12-12', 'mänlich', 'eva', 'as', 12),
(11, 'john_dozi', 'asdfa', '2222-12-23', 'mänlich', 'sdfsd', 'sdfs', 14);

-- --------------------------------------------------------

--
-- Table structure for table `konkrete_veranstaltung`
--

CREATE TABLE `konkrete_veranstaltung` (
  `KonVer_ID` int(11) NOT NULL,
  `Datum` date DEFAULT NULL,
  `Veranstaltungs_ID` int(11) NOT NULL,
  `Semi_ID` int(11) NOT NULL,
  `Dozi_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konkrete_veranstaltung`
--

INSERT INTO `konkrete_veranstaltung` (`KonVer_ID`, `Datum`, `Veranstaltungs_ID`, `Semi_ID`, `Dozi_ID`) VALUES
(1, '2024-05-05', 2, 1, 8),
(2, '2024-05-08', 3, 1, 8),
(4, '2024-05-17', 4, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `Modul_ID` int(11) NOT NULL,
  `Bezeichnung` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`Modul_ID`, `Bezeichnung`) VALUES
(14, 'Datenbanken'),
(15, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `plz`
--

CREATE TABLE `plz` (
  `PLZ` char(64) NOT NULL,
  `Ort` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plz`
--

INSERT INTO `plz` (`PLZ`, `Ort`) VALUES
('30303', 'toll'),
('48155', 'Münster'),
('48308', 'Senden'),
('48329', 'Havixbeck'),
('asdf', 'asdf'),
('dfgh', 'dfgh');

-- --------------------------------------------------------

--
-- Table structure for table `rollen`
--

CREATE TABLE `rollen` (
  `Roll_ID` int(11) NOT NULL,
  `Rolle` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rollen`
--

INSERT INTO `rollen` (`Roll_ID`, `Rolle`) VALUES
(1, 'student'),
(2, 'dozent'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `Semi_ID` int(11) NOT NULL,
  `Semester` char(64) DEFAULT NULL,
  `Jahr` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`Semi_ID`, `Semester`, `Jahr`) VALUES
(1, 'Sommer', '2024'),
(2, 'Winter', '2024/2025');

-- --------------------------------------------------------

--
-- Table structure for table `student`
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

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Matrikelnummer`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Adress_ID`, `Studi_ID`) VALUES
(18, 'john', 'schingarjow', '2005-01-10', 'mänlich', 'eva', 'de', 1, 3),
(19, 'john_student', 'as', '0023-12-31', 'mänlich', 'sdfs', 'sdf', 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_konver`
--

CREATE TABLE `student_konver` (
  `KonVer_ID` int(11) NOT NULL,
  `Matrikelnummer` int(11) NOT NULL,
  `Note` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_konver`
--

INSERT INTO `student_konver` (`KonVer_ID`, `Matrikelnummer`, `Note`) VALUES
(1, 18, ''),
(1, 19, ''),
(4, 18, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studiengang`
--

CREATE TABLE `studiengang` (
  `Studi_ID` int(11) NOT NULL,
  `Bezeichnung` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studiengang`
--

INSERT INTO `studiengang` (`Studi_ID`, `Bezeichnung`) VALUES
(1, 'Informatik'),
(3, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `veranstaltung`
--

CREATE TABLE `veranstaltung` (
  `Veranstaltungs_ID` int(11) NOT NULL,
  `Bezeichnung` char(64) DEFAULT NULL,
  `CP` char(64) DEFAULT NULL,
  `Modul_ID` int(11) NOT NULL,
  `Art_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veranstaltung`
--

INSERT INTO `veranstaltung` (`Veranstaltungs_ID`, `Bezeichnung`, `CP`, `Modul_ID`, `Art_ID`) VALUES
(2, 'Datenbank Vorlesung', '8', 14, 1),
(3, 'test veranstaltung', '4', 15, 2),
(4, 'C# Grundlagen', '6', 15, 1),
(5, 'ASM Grundlagen', '6', 15, 2);

-- --------------------------------------------------------

--
-- Table structure for table `veranstaltungsart`
--

CREATE TABLE `veranstaltungsart` (
  `Art_ID` int(11) NOT NULL,
  `Bezeichnung` char(64) DEFAULT NULL,
  `Beschreibung` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veranstaltungsart`
--

INSERT INTO `veranstaltungsart` (`Art_ID`, `Bezeichnung`, `Beschreibung`) VALUES
(1, 'Vorlesung', 'Dozent erklärt ein thema'),
(2, 'Übung', 'Praktische anwendung von erlangten wissen aus den Vorlesung'),
(3, 'Modul Prüfung', 'Finale Prüfung');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`Adress_ID`),
  ADD KEY `PLZ` (`PLZ`);

--
-- Indexes for table `beinhaltet`
--
ALTER TABLE `beinhaltet`
  ADD PRIMARY KEY (`Studi_ID`,`Modul_ID`),
  ADD KEY `Modul_ID` (`Modul_ID`),
  ADD KEY `Semester` (`Semester`);

--
-- Indexes for table `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `benutzer_id`
--
ALTER TABLE `benutzer_id`
  ADD PRIMARY KEY (`Ben_ID`),
  ADD KEY `student_ID` (`student_ID`),
  ADD KEY `Roll_ID` (`Roll_ID`) USING BTREE,
  ADD KEY `dozent_ID` (`dozent_ID`);

--
-- Indexes for table `dozent`
--
ALTER TABLE `dozent`
  ADD PRIMARY KEY (`Dozi_ID`),
  ADD KEY `Adress_ID` (`Adress_ID`);

--
-- Indexes for table `konkrete_veranstaltung`
--
ALTER TABLE `konkrete_veranstaltung`
  ADD PRIMARY KEY (`KonVer_ID`),
  ADD KEY `Veranstaltungs_ID` (`Veranstaltungs_ID`),
  ADD KEY `Semi_ID` (`Semi_ID`),
  ADD KEY `Dozi_ID` (`Dozi_ID`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`Modul_ID`);

--
-- Indexes for table `plz`
--
ALTER TABLE `plz`
  ADD PRIMARY KEY (`PLZ`);

--
-- Indexes for table `rollen`
--
ALTER TABLE `rollen`
  ADD PRIMARY KEY (`Roll_ID`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`Semi_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Matrikelnummer`),
  ADD KEY `Studi_ID` (`Studi_ID`),
  ADD KEY `Adress_ID` (`Adress_ID`);

--
-- Indexes for table `student_konver`
--
ALTER TABLE `student_konver`
  ADD PRIMARY KEY (`KonVer_ID`,`Matrikelnummer`),
  ADD KEY `Matrikelnummer` (`Matrikelnummer`) USING BTREE;

--
-- Indexes for table `studiengang`
--
ALTER TABLE `studiengang`
  ADD PRIMARY KEY (`Studi_ID`);

--
-- Indexes for table `veranstaltung`
--
ALTER TABLE `veranstaltung`
  ADD PRIMARY KEY (`Veranstaltungs_ID`),
  ADD KEY `Modul_ID` (`Modul_ID`),
  ADD KEY `Art_ID` (`Art_ID`);

--
-- Indexes for table `veranstaltungsart`
--
ALTER TABLE `veranstaltungsart`
  ADD PRIMARY KEY (`Art_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `Adress_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `benutzer_id`
--
ALTER TABLE `benutzer_id`
  MODIFY `Ben_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `dozent`
--
ALTER TABLE `dozent`
  MODIFY `Dozi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `konkrete_veranstaltung`
--
ALTER TABLE `konkrete_veranstaltung`
  MODIFY `KonVer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `Modul_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rollen`
--
ALTER TABLE `rollen`
  MODIFY `Roll_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `Semi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Matrikelnummer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `studiengang`
--
ALTER TABLE `studiengang`
  MODIFY `Studi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `veranstaltung`
--
ALTER TABLE `veranstaltung`
  MODIFY `Veranstaltungs_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `veranstaltungsart`
--
ALTER TABLE `veranstaltungsart`
  MODIFY `Art_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `adresse_ibfk_1` FOREIGN KEY (`PLZ`) REFERENCES `plz` (`PLZ`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `beinhaltet`
--
ALTER TABLE `beinhaltet`
  ADD CONSTRAINT `beinhaltet_ibfk_1` FOREIGN KEY (`Studi_ID`) REFERENCES `studiengang` (`Studi_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beinhaltet_ibfk_2` FOREIGN KEY (`Modul_ID`) REFERENCES `modul` (`Modul_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beinhaltet_ibfk_3` FOREIGN KEY (`Semester`) REFERENCES `semester` (`Semi_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `benutzer`
--
ALTER TABLE `benutzer`
  ADD CONSTRAINT `Ben_ID` FOREIGN KEY (`ID`) REFERENCES `benutzer_id` (`Ben_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `benutzer_id`
--
ALTER TABLE `benutzer_id`
  ADD CONSTRAINT `Roll_ID` FOREIGN KEY (`Roll_ID`) REFERENCES `rollen` (`Roll_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dozent_ID` FOREIGN KEY (`dozent_ID`) REFERENCES `dozent` (`Dozi_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ID` FOREIGN KEY (`student_ID`) REFERENCES `student` (`Matrikelnummer`) ON UPDATE CASCADE;

--
-- Constraints for table `dozent`
--
ALTER TABLE `dozent`
  ADD CONSTRAINT `dozent_ibfk_2` FOREIGN KEY (`Adress_ID`) REFERENCES `adresse` (`Adress_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `konkrete_veranstaltung`
--
ALTER TABLE `konkrete_veranstaltung`
  ADD CONSTRAINT `konkrete_veranstaltung_ibfk_1` FOREIGN KEY (`Veranstaltungs_ID`) REFERENCES `veranstaltung` (`Veranstaltungs_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `konkrete_veranstaltung_ibfk_2` FOREIGN KEY (`Semi_ID`) REFERENCES `semester` (`Semi_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `konkrete_veranstaltung_ibfk_3` FOREIGN KEY (`Dozi_ID`) REFERENCES `dozent` (`Dozi_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`Studi_ID`) REFERENCES `studiengang` (`Studi_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`Adress_ID`) REFERENCES `adresse` (`Adress_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `student_konver`
--
ALTER TABLE `student_konver`
  ADD CONSTRAINT `student_konver_ibfk_1` FOREIGN KEY (`KonVer_ID`) REFERENCES `konkrete_veranstaltung` (`KonVer_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_konver_ibfk_2` FOREIGN KEY (`Matrikelnummer`) REFERENCES `student` (`Matrikelnummer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `veranstaltung`
--
ALTER TABLE `veranstaltung`
  ADD CONSTRAINT `veranstaltung_ibfk_1` FOREIGN KEY (`Modul_ID`) REFERENCES `modul` (`Modul_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `veranstaltung_ibfk_2` FOREIGN KEY (`Art_ID`) REFERENCES `veranstaltungsart` (`Art_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
