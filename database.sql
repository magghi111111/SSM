-- Active: 1769622808934@@127.0.0.1@3306@gestore_magazzino
-- ====================================
-- DATABASE MAGAZZINO - VERSIONE COMPLETA CON CASCADE E INT(10)
-- ====================================
CREATE DATABASE gestore_magazzino;
USE gestore_magazzino;

-- ====================================
-- TABELLA UTENTI
-- ====================================
CREATE TABLE utenti (
    id INT(5) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(30) UNIQUE NOT NULL,
    password_hash VARCHAR(20) NOT NULL,
    ruolo ENUM('WAREHOUSE', 'ADMIN') NOT NULL DEFAULT 'WAREHOUSE'
);

-- ====================================
-- TABELLA CLIENTI
-- ====================================
CREATE TABLE cliente (
    codice INT(5) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(20) NOT NULL,
    cognome VARCHAR(20) NOT NULL,
    email VARCHAR(40) UNIQUE NOT NULL,
    numero VARCHAR(15)
);

-- ====================================
-- TABELLA COMPONENTI
-- ====================================
CREATE TABLE componenti (
    id INT(5) AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) UNIQUE NOT NULL,
    nome VARCHAR(30) NOT NULL,
    qrcode VARCHAR(100) UNIQUE,
    unita_misura VARCHAR(10),
    tipo ENUM('RAW', 'ASSEMBLY') NOT NULL
);

SELECT c.*, p.quantita
    FROM parti_componente p
    join componenti c on p.id_raw = c.id
    WHERE id_assembly = :id_assembly;

-- ====================================
-- TABELLA STOCK
-- ====================================
CREATE TABLE stock (
    id_componente INT PRIMARY KEY,
    quantita INT NOT NULL DEFAULT 0,
    ultima_modifica DATETIME NOT NULL 
        DEFAULT CURRENT_TIMESTAMP 
        ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_stock_quantita CHECK (quantita >= 0)
);

-- ====================================
-- TABELLA ORDINI
-- ====================================
CREATE TABLE ordini (
    id INT(5) AUTO_INCREMENT PRIMARY KEY,
    id_shopify INt(5) NOT NULL UNIQUE,
    data_creazione DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_preparazione DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    stato ENUM('PENDING','IN_PICK','PREPARED') NOT NULL DEFAULT 'PENDING',
    id_cliente INT(5) NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES cliente(codice)
        ON DELETE CASCADE ON UPDATE CASCADE
);

SELECT o.id_shopify, o.data_creazione,o.stato, c.nome, c.cognome
FROM ordini o
JOIN cliente c ON o.id_cliente = c.codice
WHERE o.data_creazione >= DATE_SUB(CURDATE(), INTERVAL 7 DAY);

-- ====================================
-- TABELLA RIGHE ORDINE
-- ====================================
CREATE TABLE righe_ordini(
    id_ordine INT(5) NOT NULL,
    id_componente INT(5) NOT NULL,
    quantita INT(5) NOT NULL ,
    PRIMARY KEY (id_ordine, id_componente),
    FOREIGN KEY (id_ordine) REFERENCES ordini(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_componente) REFERENCES componenti(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT quantita_riga_ordine_negativa CHECK (quantita>0)
);

-- ====================================
-- TABELLA MOVIMENTI
-- ====================================
CREATE TABLE movimenti (
    id INT(5) AUTO_INCREMENT PRIMARY KEY,
    delta INT(10) NOT NULL,
    tipo ENUM('ORDER','DELIVERY','MANUAL','ASSEMBLY') NOT NULL,
    id_ordine INT(5) NULL,
    id_consegna INT(5) NULL,
    id_assemblaggio INT(5) NULL,
    data_movimento DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    note text,
    foreign key (id_ordine) references ordini(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key (id_consegna) references consegna(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key (id_assemblaggio) references assemblaggi(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

SELECT c.nome, m.delta, m.tipo, m.note, m.data_movimento
FROM movimenti m
left JOIN componenti c ON m.id_componente = c.id
left JOIN consegna d ON m.id_consegna = d.id
left JOIN ordini o ON m.id_ordine = o.id;

alter table movimenti
add COLUMN id_componente INT(5) null REFERENCES componenti(id) AFTER id;

SELECT delta, tipo, note
from movimenti
ORDER BY data_movimento
LIMIT 10;

-- ====================================
-- TABELLA PARTI COMPONENTE
-- ====================================
CREATE TABLE parti_componente (
    id_assembly INT(5) NOT NULL,
    id_raw INT(5) NOT NULL,
    quantita INT(10) NOT NULL,
    PRIMARY KEY (id_assembly, id_raw),
    FOREIGN KEY (id_assembly) REFERENCES componenti(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_raw) REFERENCES componenti(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- ====================================
-- TABELLA ASSEMBLAGGI
-- ====================================
CREATE TABLE assemblaggi (
    id INT(5) AUTO_INCREMENT PRIMARY KEY,
    id_componente INT(5) NOT NULL,
    id_utente INT(5) NOT NULL,
    quantita INT(10) NOT NULL,
    data_assemblaggio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    note text,
    FOREIGN KEY (id_componente) REFERENCES componenti(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_utente) REFERENCES utenti(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- ====================================
-- TABELLA FORNITORI
-- ====================================
CREATE TABLE fornitore (
    id INT(5) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL,
    email VARCHAR(30) UNIQUE,
    telefono VARCHAR(15)
);

-- ====================================
-- TABELLA CONSEGNE
-- ====================================
CREATE TABLE consegna (
    id INT(5) AUTO_INCREMENT PRIMARY KEY,
    id_fornitore INT(5) NOT NULL,
    data_ordine DATETIME NOT NULL,
    data_ricezione DATETIME NULL,
    note text,
    FOREIGN KEY (id_fornitore) REFERENCES fornitore(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- ====================================
-- TABELLA RIGHE CONSEGNA
-- ====================================
CREATE TABLE righe_consegna (
    id_consegna INT(5) NOT NULL,
    id_componente INT(5) NOT NULL,
    qta_ordinata INT(5) NOT NULL ,
    CONSTRAINT qta_ordinata_negativa CHECK (qta_ordinata >= 0),
    qta_ricevuta INT(5) DEFAULT 0 ,
    CONSTRAINT qta_ricevuta_negativa CHECK (qta_ricevuta >= 0),
    PRIMARY KEY (id_consegna, id_componente),
    FOREIGN KEY (id_consegna) REFERENCES consegna(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_componente) REFERENCES componenti(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO utenti (email, password_hash, ruolo) VALUES
('admin@magazzino.it', '$2y$10$OqBkbLEnrVOq8q/Ts4tMZuG2iPwTudlKtevWcIYzr2yE.DsxVBPSe', 'ADMIN'),--admin
('warehouse1@magazzino.it', '$2y$10$G2K33oWL57BzCb6S2qiTze4YODnpolcZP.UqEX/KBU8M..5NYBS.G', 'WAREHOUSE'),--wh1
('warehouse2@magazzino.it', '$2y$10$IcoA4Qh89UMk0tjnkPE3VOwjk1RvAnK.huRWBQ9V9o/FkRPJg92hK', 'WAREHOUSE');--wh2

INSERT INTO cliente (nome, cognome, email, numero) VALUES
('Mario', 'Rossi', 'mario.rossi@email.it', '3331112222'),
('Luca', 'Bianchi', 'luca.bianchi@email.it', '3332223333'),
('Anna', 'Verdi', 'anna.verdi@email.it', '3334445555');

INSERT INTO componenti (sku, nome, qrcode, unita_misura, tipo) VALUES
('RAW-RES-10K', 'Resistenza 10K', 'QR-RAW-10K', 'pz', 'RAW'),
('RAW-CAP-100uF', 'Condensatore 100uF', 'QR-RAW-100uF', 'pz', 'RAW'),
('RAW-IC-555', 'Timer NE555', 'QR-RAW-555', 'pz', 'RAW'),
('ASM-MOD-001', 'Modulo Timer', 'QR-ASM-001', 'pz', 'ASSEMBLY');

INSERT INTO stock (id_componente, quantita) VALUES
(1, 500),
(2, 300),
(3, 200),
(4, 20);

INSERT INTO parti_componente (id_assembly, id_raw, quantita) VALUES
(4, 1, 2),   -- 2 resistenze
(4, 2, 1),   -- 1 condensatore
(4, 3, 1);   -- 1 IC

INSERT INTO fornitore (nome, email, telefono) VALUES
('ElectroSupply SRL', 'ordini@electrosupply.it', '021234567'),
('Componenti Italia', 'info@componentitalia.it', '029876543');

INSERT INTO consegna (id_fornitore, data_ordine, data_ricezione, note) VALUES
(1, '2025-01-10 09:00:00', '2025-01-12 15:30:00', 'Consegna completa'),
(2, '2025-01-14 10:00:00', NULL, 'In attesa di ricezione');

INSERT INTO righe_consegna (id_consegna, id_componente, qta_ordinata, qta_ricevuta) VALUES
(1, 1, 200, 200),
(1, 2, 150, 150),
(2, 3, 100, 0);

INSERT INTO ordini (id_shopify, stato, id_cliente) VALUES 
(10001, 'PENDING', 1),
(10002, 'IN_PICK', 2),
(10003, 'PREPARED', 3);

INSERT INTO righe_ordini (id_ordine, id_componente, quantita) VALUES
(1, 4, 2),
(2, 4, 1),
(3, 1, 10),
(3, 2, 5);

INSERT INTO assemblaggi (id_componente, id_utente, quantita, note) VALUES
(4, 2, 10, 'Assemblaggio lotto gennaio'),
(4, 3, 5, 'Assemblaggio urgente');

INSERT INTO movimenti (delta, tipo, id_ordine,id_consegna,id_assemblaggio, note) VALUES
(-2, 'ORDER', 1, NULL, NULL, 'Ordine cliente 10001'),
(200,  'DELIVERY', NULL, 1, NULL, 'Carico da fornitore'),
(-20, 'ASSEMBLY', NULL, NULL, 1, 'Usate per assemblaggio'),
(10, 'ASSEMBLY', NULL, NULL, 1, 'Assemblati moduli');