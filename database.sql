-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 03:41 PM
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
-- Database: `gestore_magazzino`
--

-- --------------------------------------------------------

--
-- Table structure for table `assemblaggi`
--

use gestore_magazzino;

CREATE TABLE `assemblaggi` (
  `id` int(5) NOT NULL,
  `id_componente` int(5) NOT NULL,
  `id_utente` int(5) NOT NULL,
  `quantita` int(10) NOT NULL,
  `data_inizio` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `data_fine` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assemblaggi`
--

INSERT INTO `assemblaggi` (`id`, `id_componente`, `id_utente`, `quantita`, `data_inizio`, `note`, `data_fine`) VALUES
(1, 4, 2, 10, '2026-02-07 18:53:47', 'Assemblaggio lotto gennaio', '2026-02-23 16:30:46'),
(2, 4, 3, 5, '2026-02-07 18:53:47', 'Assemblaggio urgente', '2026-02-23 16:30:46'),
(3, 4, 1, 1, '2026-02-08 18:13:14', 'Assemblaggio resistenze 08/02', '2026-02-23 16:30:46'),
(4, 8, 2, 15, '2026-02-09 17:03:45', 'Produzione moduli LED', '2026-02-23 16:30:46'),
(5, 4, 2, 8, '2026-02-09 17:03:45', 'Assemblaggio extra febbraio', '2026-02-23 16:30:46'),
(6, 4, 1, 20, '2026-02-14 17:10:53', 'Assemblaggio 14 febbraio', '2026-02-23 16:30:46'),
(7, 4, 1, 5, '2026-02-20 16:09:06', 'festa', '2026-02-23 16:30:46'),
(8, 4, 1, 1, '2026-02-25 16:00:38', '', NULL),
(9, 4, 1, 1, '2026-02-25 16:01:39', '', NULL),
(10, 4, 1, 1, '2026-02-25 16:06:18', 'Assemblaggio effettuato il 2026-02-25 16:06:18', NULL),
(11, 4, 1, 1, '2026-02-25 16:08:40', 'Assemblaggio effettuato il 2026-02-25 16:08:40', NULL),
(12, 4, 1, 1, '2026-02-25 16:11:19', 'Assemblaggio effettuato il 2026-02-25 16:11:19', NULL),
(13, 4, 1, 1, '2026-02-25 17:05:41', 'Assemblaggio effettuato il 2026-02-25 17:05:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `codice` int(5) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `numero` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`codice`, `nome`, `cognome`, `email`, `numero`) VALUES
(1, 'Mario', 'Rossi', 'mario.rossi@email.it', '3331112222'),
(2, 'Luca', 'Bianchi', 'luca.bianchi@email.it', '3332223333'),
(3, 'Anna', 'Verdi', 'anna.verdi@email.it', '3334445555'),
(4, 'Giulia', 'Neri', 'giulia.neri@email.it', '3336667777'),
(5, 'Paolo', 'Galli', 'paolo.galli@email.it', '3338889999'),
(6, 'Sara', 'Fontana', 'sara.fontana@email.it', '3341112222');

-- --------------------------------------------------------

--
-- Table structure for table `componenti`
--

CREATE TABLE `componenti` (
  `id` int(5) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `qrcode` varchar(100) DEFAULT NULL,
  `unita_misura` varchar(10) DEFAULT NULL,
  `tipo` enum('RAW','ASSEMBLY') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `componenti`
--

INSERT INTO `componenti` (`id`, `sku`, `nome`, `qrcode`, `unita_misura`, `tipo`) VALUES
(1, 'CE-CTR-PCB', 'PCB', 'RAW-ae01dd61-abd2-4f70-ac61-59d876f64727', 'pz', 'RAW'),
(2, 'CE-CTR-CASE', 'Case ', 'RAW-c717c533-d27b-41b0-8918-10c0a3aad3e1', 'pz', 'RAW'),
(3, 'CE-CBL', 'Cablaggio', 'RAW-88c1bc69-8381-4704-909b-31aa63350d14', 'pz', 'ASSEMBLY'),
(4, 'CE-CTR', 'Centralina', 'ASSEMBLY-02c9a9cc-a8bd-4caa-831d-afb6ff9894f7', 'pz', 'ASSEMBLY'),
(5, 'CE-CLB-INT', 'Interruttore', 'RAW-97cbac6c-397d-431f-82c0-88521e3b9760', 'pz', 'ASSEMBLY'),
(6, 'CE-PED-SCO', 'Scocca', 'RAW-52356207-755d-4390-b816-cdd2f7c9af7b', 'pz', 'RAW'),
(7, 'CE-PED-PUL', 'Pulsante', 'RAW-8b83b328-d6de-475f-9ee3-310b389ff4dd', 'pz', 'RAW'),
(8, 'CE-PED', 'Pedalina', 'ASSEMBLY-89975a2b-ecb3-4911-8bd7-70f228f7e298', 'pz', 'ASSEMBLY'),
(14, 'CE-PED-MOL', 'Molla', 'RAW-24622795-471c-4167-bb9c-12b2ce086b05', 'pz', 'RAW'),
(15, 'CE-PED-REED', 'Ampolla Reed', 'RAW-a289153d-a306-477e-a281-da1b884e564a', 'pz', 'RAW'),
(16, 'CE-PED-PER', 'Perno', 'RAW-e18bb0bf-d07e-4859-b724-eccea3025716', 'pz', 'RAW'),
(17, 'CE-PED-MAG', 'Magnete', 'RAW-ae5a4e84-23da-4e0e-a481-65e08909ce8b', 'pz', 'RAW'),
(18, 'CE-ASM', 'Cambio Elettronico', 'ASSEMBLY-e83ec0d7-100b-4e88-bf9d-8fdc59fd82c1', 'pz', 'ASSEMBLY'),
(19, 'CE-CLB-CCLB', 'Corpo Cablaggio', 'RAW-c19a2a20-b42c-4963-b9c0-e4aeae51bab5', 'pz', 'RAW'),
(20, 'CE-CLB-INT-STA', 'Staffa', 'RAW-568130d0-e608-4893-96a9-870fe11c359b', 'pz', 'RAW'),
(21, 'CE-CBL-CLG', 'Collegamento Batteria', 'RAW-604e9ba8-b31f-4ee8-b060-b23ba156387c', 'pz', 'RAW');

-- --------------------------------------------------------

--
-- Table structure for table `consegna`
--

CREATE TABLE `consegna` (
  `id` int(5) NOT NULL,
  `id_fornitore` int(5) NOT NULL,
  `data_ordine` datetime NOT NULL,
  `data_ricezione` datetime DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consegna`
--

INSERT INTO `consegna` (`id`, `id_fornitore`, `data_ordine`, `data_ricezione`, `note`) VALUES
(1, 1, '2025-01-10 09:00:00', '2025-01-12 15:30:00', 'Consegna completa'),
(2, 2, '2025-01-14 10:00:00', NULL, 'In attesa di ricezione'),
(3, 3, '2025-01-20 08:30:00', '2025-01-22 11:00:00', 'Consegna rapida'),
(4, 4, '2025-01-25 14:00:00', NULL, 'Ordine urgente'),
(7, 1, '2026-02-08 17:01:00', '2026-02-10 17:02:00', 'Festa'),
(8, 4, '2026-02-05 17:02:00', '2026-02-10 17:02:00', 'Ponari'),
(9, 3, '2026-02-10 17:09:00', '2026-02-13 17:09:00', '+50 Resistenze 10k'),
(10, 2, '2026-02-20 16:49:00', '2026-02-20 16:49:00', 'j');

-- --------------------------------------------------------

--
-- Table structure for table `fornitore`
--

CREATE TABLE `fornitore` (
  `id` int(5) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fornitore`
--

INSERT INTO `fornitore` (`id`, `nome`, `email`, `telefono`) VALUES
(1, 'ElectroSupply SRL', 'ordini@electrosupply.it', '021234567'),
(2, 'Componenti Italia', 'info@componentitalia.it', '029876543'),
(3, 'Global Electronics', 'sales@globalelectronics.com', '021111222'),
(4, 'Fast Components', 'orders@fastcomponents.it', '023334445');

-- --------------------------------------------------------

--
-- Table structure for table `movimenti`
--

CREATE TABLE `movimenti` (
  `id` int(5) NOT NULL,
  `delta` int(10) NOT NULL,
  `tipo` enum('ORDER','DELIVERY','MANUAL','ASSEMBLY') NOT NULL,
  `id_ordine` int(5) DEFAULT NULL,
  `id_consegna` int(5) DEFAULT NULL,
  `id_assemblaggio` int(5) DEFAULT NULL,
  `id_componente` int(5) DEFAULT NULL,
  `data_movimento` datetime NOT NULL DEFAULT current_timestamp(),
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movimenti`
--

INSERT INTO `movimenti` (`id`, `delta`, `tipo`, `id_ordine`, `id_consegna`, `id_assemblaggio`, `id_componente`, `data_movimento`, `note`) VALUES
(1, -2, 'ORDER', 1, NULL, NULL, NULL, '2026-02-07 18:53:48', 'Ordine cliente 10001'),
(2, 200, 'DELIVERY', NULL, 1, NULL, NULL, '2026-02-07 18:53:48', 'Carico da fornitore'),
(3, -20, 'ASSEMBLY', NULL, NULL, 1, 4, '2026-02-07 18:53:48', 'Usate per assemblaggio'),
(4, 10, 'ASSEMBLY', NULL, NULL, 1, 4, '2026-02-07 18:53:48', 'Assemblati moduli'),
(5, 1, 'ASSEMBLY', NULL, NULL, NULL, 4, '2026-02-08 18:13:14', 'Assemblaggio resistenze 08/02'),
(6, -3, 'ORDER', 4, NULL, NULL, 8, '2026-02-09 17:03:46', 'Ordine cliente 10004'),
(7, -2, 'ORDER', 5, NULL, NULL, 4, '2026-02-09 17:03:46', 'Ordine cliente 10005'),
(8, 300, 'DELIVERY', NULL, 3, NULL, 5, '2026-02-09 17:03:46', 'Carico resistenze 1K'),
(9, 200, 'DELIVERY', NULL, 3, NULL, 6, '2026-02-09 17:03:46', 'Carico LED rossi'),
(10, -15, 'ASSEMBLY', NULL, NULL, 3, 8, '2026-02-09 17:03:46', 'Componenti usati per assemblaggio'),
(11, 15, 'ASSEMBLY', NULL, NULL, 3, 8, '2026-02-09 17:03:46', 'Assemblati moduli LED'),
(12, 5, 'MANUAL', NULL, NULL, NULL, 4, '2026-02-10 16:49:18', 'Kujtime ponari'),
(13, 1, 'DELIVERY', NULL, 7, NULL, 3, '2026-02-10 17:02:10', 'Festa'),
(14, 1, 'DELIVERY', NULL, 8, NULL, 2, '2026-02-10 17:02:49', 'Ponari'),
(15, 1, 'DELIVERY', NULL, 8, NULL, 3, '2026-02-10 17:02:49', 'Ponari'),
(16, 50, 'DELIVERY', NULL, 9, NULL, 1, '2026-02-10 17:10:07', '+50 Resistenze 10k'),
(20, 20, 'ASSEMBLY', NULL, NULL, 6, 4, '2026-02-14 17:10:53', 'Assemblaggio 14 febbraio'),
(21, 5, 'ASSEMBLY', NULL, NULL, 7, 4, '2026-02-20 16:09:06', 'festa'),
(22, 100, 'DELIVERY', NULL, 10, NULL, 2, '2026-02-20 16:50:04', 'j'),
(23, 0, 'MANUAL', NULL, NULL, NULL, 14, '2026-02-23 16:39:32', 'Nuovo componente'),
(24, 0, 'MANUAL', NULL, NULL, NULL, 15, '2026-02-23 16:40:30', 'aggiunta\r\n'),
(25, 0, 'MANUAL', NULL, NULL, NULL, 16, '2026-02-23 16:40:57', 'aggiunta'),
(26, 0, 'MANUAL', NULL, NULL, NULL, 17, '2026-02-23 16:42:01', 'festa\r\n'),
(27, 1, 'ASSEMBLY', NULL, NULL, 8, 1, '2026-02-25 16:00:38', ''),
(28, 1, 'ASSEMBLY', NULL, NULL, 9, 4, '2026-02-25 16:01:39', ''),
(29, 1, 'ASSEMBLY', NULL, NULL, 10, 4, '2026-02-25 16:06:18', 'Assemblaggio effettuato il 2026-02-25 16:06:18'),
(30, 1, 'ASSEMBLY', NULL, NULL, 11, 4, '2026-02-25 16:08:40', 'Assemblaggio effettuato il 2026-02-25 16:08:40'),
(31, 1, 'ASSEMBLY', NULL, NULL, 12, 4, '2026-02-25 16:11:19', 'Assemblaggio effettuato il 2026-02-25 16:11:19'),
(32, 1, 'ASSEMBLY', NULL, NULL, 13, 4, '2026-02-25 17:05:41', 'Assemblaggio effettuato il 2026-02-25 17:05:41'),
(33, 10, 'MANUAL', NULL, NULL, NULL, 19, '2026-02-26 15:32:44', 'Aggiunta componente'),
(34, 10, 'MANUAL', NULL, NULL, NULL, 20, '2026-02-26 15:34:10', 'Aggiunta componente'),
(35, 10, 'MANUAL', NULL, NULL, NULL, 21, '2026-02-26 15:39:34', 'Aggiunta componente');

-- --------------------------------------------------------

--
-- Table structure for table `ordini`
--

CREATE TABLE `ordini` (
  `id` int(5) NOT NULL,
  `id_shopify` int(5) NOT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `stato` enum('PENDING','OUT_OF_STOCK','PREPARED') NOT NULL DEFAULT 'PENDING',
  `id_cliente` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordini`
--

INSERT INTO `ordini` (`id`, `id_shopify`, `data_creazione`, `stato`, `id_cliente`) VALUES
(1, 10001, '2026-02-07 18:53:44', 'PENDING', 1),
(2, 10002, '2026-02-07 18:53:44', 'PENDING', 2),
(3, 10003, '2026-01-07 18:53:44', 'PREPARED', 3),
(4, 10004, '2026-01-09 17:03:45', 'PENDING', 4),
(5, 10005, '2026-02-09 17:03:45', 'PENDING', 5),
(6, 10006, '2026-02-09 17:03:45', 'PENDING', 6);

-- --------------------------------------------------------

--
-- Table structure for table `parti_componente`
--

CREATE TABLE `parti_componente` (
  `id_assembly` int(5) NOT NULL,
  `id_raw` int(5) NOT NULL,
  `quantita` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parti_componente`
--

INSERT INTO `parti_componente` (`id_assembly`, `id_raw`, `quantita`) VALUES
(4, 1, 1),
(4, 2, 1),
(8, 6, 1),
(8, 7, 1),
(8, 14, 1),
(8, 15, 1),
(8, 16, 1),
(8, 17, 1),
(18, 3, 1),
(18, 4, 1),
(18, 8, 1);

insert into parti_componente (id_assembly, id_raw, quantita) values
(5, 20, 1),
(5, 7, 1),
(3, 19, 1),
(3, 5, 1),
(3, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `righe_consegna`
--

CREATE TABLE `righe_consegna` (
  `id_consegna` int(5) NOT NULL,
  `id_componente` int(5) NOT NULL,
  `qta_ordinata` int(5) NOT NULL,
  `qta_ricevuta` int(5) DEFAULT 0
) ;

--
-- Dumping data for table `righe_consegna`
--

INSERT INTO `righe_consegna` (`id_consegna`, `id_componente`, `qta_ordinata`, `qta_ricevuta`) VALUES
(1, 1, 200, 200),
(1, 2, 150, 150),
(2, 3, 100, 0),
(3, 5, 300, 300),
(3, 6, 200, 200),
(4, 7, 400, 0),
(7, 3, 0, 1),
(8, 2, 0, 1),
(8, 3, 0, 1),
(9, 1, 0, 50),
(10, 2, 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `righe_ordini`
--

CREATE TABLE `righe_ordini` (
  `id_ordine` int(5) NOT NULL,
  `id_componente` int(5) NOT NULL,
  `quantita` int(5) NOT NULL
) ;

--
-- Dumping data for table `righe_ordini`
--

INSERT INTO `righe_ordini` (`id_ordine`, `id_componente`, `quantita`) VALUES
(1, 4, 2),
(2, 4, 1),
(3, 18, 10),
(3, 3, 5),
(4, 8, 3),
(5, 18, 2),
(6, 18, 20),
(6, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_componente` int(11) NOT NULL,
  `quantita` int(11) NOT NULL DEFAULT 0,
  `ultima_modifica` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id_componente`, `quantita`, `ultima_modifica`) VALUES
(1, 494, '2026-02-25 17:05:41'),
(2, 369, '2026-02-25 17:05:41'),
(3, 174, '2026-02-20 16:09:06'),
(4, 56, '2026-02-25 17:05:41'),
(5, 800, '2026-02-09 17:03:45'),
(6, 500, '2026-02-09 17:03:45'),
(7, 450, '2026-02-09 17:03:45'),
(8, 30, '2026-02-09 17:03:45'),
(14, 0, '2026-02-23 16:39:32'),
(15, 0, '2026-02-23 16:40:30'),
(16, 0, '2026-02-23 16:40:57'),
(17, 0, '2026-02-23 16:42:01'),
(18, 20, '2026-02-23 16:47:07'),
(19, 10, '2026-02-26 15:32:44'),
(20, 10, '2026-02-26 15:34:10'),
(21, 10, '2026-02-26 15:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id` int(5) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `ruolo` enum('WAREHOUSE','ADMIN') NOT NULL DEFAULT 'WAREHOUSE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id`, `email`, `password_hash`, `ruolo`) VALUES
(1, 'admin@magazzino.it', '$2y$10$OqBkbLEnrVOq8q/Ts4tMZuG2iPwTudlKtevWcIYzr2yE.DsxVBPSe', 'ADMIN'),
(2, 'warehouse1@magazzino.it', '$2y$10$G2K33oWL57BzCb6S2qiTze4YODnpolcZP.UqEX/KBU8M..5NYBS.G', 'WAREHOUSE'),
(3, 'warehouse2@magazzino.it', '$2y$10$IcoA4Qh89UMk0tjnkPE3VOwjk1RvAnK.huRWBQ9V9o/FkRPJg92hK', 'WAREHOUSE'),
(5, 'marcello.celani@studenti.iispa', '$2y$10$S1cfunUV5aAGBkSdMZMFcuBPxI/PSk7ZJwSgIFVtKWW/ExWop1FwW', 'WAREHOUSE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assemblaggi`
--
ALTER TABLE `assemblaggi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_componente` (`id_componente`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`codice`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `componenti`
--
ALTER TABLE `componenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD UNIQUE KEY `qrcode` (`qrcode`);

--
-- Indexes for table `consegna`
--
ALTER TABLE `consegna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_fornitore` (`id_fornitore`);

--
-- Indexes for table `fornitore`
--
ALTER TABLE `fornitore`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `movimenti`
--
ALTER TABLE `movimenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ordine` (`id_ordine`),
  ADD KEY `id_consegna` (`id_consegna`),
  ADD KEY `id_assemblaggio` (`id_assemblaggio`),
  ADD KEY `id_componente` (`id_componente`);

--
-- Indexes for table `ordini`
--
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_shopify` (`id_shopify`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indexes for table `parti_componente`
--
ALTER TABLE `parti_componente`
  ADD PRIMARY KEY (`id_assembly`,`id_raw`),
  ADD KEY `id_raw` (`id_raw`);

--
-- Indexes for table `righe_consegna`
--
ALTER TABLE `righe_consegna`
  ADD PRIMARY KEY (`id_consegna`,`id_componente`),
  ADD KEY `id_componente` (`id_componente`);

--
-- Indexes for table `righe_ordini`
--
ALTER TABLE `righe_ordini`
  ADD PRIMARY KEY (`id_ordine`,`id_componente`),
  ADD KEY `id_componente` (`id_componente`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_componente`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assemblaggi`
--
ALTER TABLE `assemblaggi`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `codice` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `componenti`
--
ALTER TABLE `componenti`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `consegna`
--
ALTER TABLE `consegna`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fornitore`
--
ALTER TABLE `fornitore`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `movimenti`
--
ALTER TABLE `movimenti`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `ordini`
--
ALTER TABLE `ordini`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assemblaggi`
--
ALTER TABLE `assemblaggi`
  ADD CONSTRAINT `assemblaggi_ibfk_1` FOREIGN KEY (`id_componente`) REFERENCES `componenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assemblaggi_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `consegna`
--
ALTER TABLE `consegna`
  ADD CONSTRAINT `consegna_ibfk_1` FOREIGN KEY (`id_fornitore`) REFERENCES `fornitore` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `movimenti`
--
ALTER TABLE `movimenti`
  ADD CONSTRAINT `movimenti_ibfk_1` FOREIGN KEY (`id_ordine`) REFERENCES `ordini` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimenti_ibfk_2` FOREIGN KEY (`id_consegna`) REFERENCES `consegna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimenti_ibfk_3` FOREIGN KEY (`id_assemblaggio`) REFERENCES `assemblaggi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimenti_ibfk_4` FOREIGN KEY (`id_componente`) REFERENCES `componenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ordini`
--
ALTER TABLE `ordini`
  ADD CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parti_componente`
--
ALTER TABLE `parti_componente`
  ADD CONSTRAINT `parti_componente_ibfk_1` FOREIGN KEY (`id_assembly`) REFERENCES `componenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parti_componente_ibfk_2` FOREIGN KEY (`id_raw`) REFERENCES `componenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `righe_consegna`
--
ALTER TABLE `righe_consegna`
  ADD CONSTRAINT `righe_consegna_ibfk_1` FOREIGN KEY (`id_consegna`) REFERENCES `consegna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `righe_consegna_ibfk_2` FOREIGN KEY (`id_componente`) REFERENCES `componenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `righe_ordini`
--
ALTER TABLE `righe_ordini`
  ADD CONSTRAINT `righe_ordini_ibfk_1` FOREIGN KEY (`id_ordine`) REFERENCES `ordini` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `righe_ordini_ibfk_2` FOREIGN KEY (`id_componente`) REFERENCES `componenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
