-- ====================================
-- DATI AGGIUNTIVI COMPLETI
-- ====================================

-- CLIENTI
INSERT INTO cliente (nome, cognome, email, numero) VALUES
('Giulia', 'Neri', 'giulia.neri@email.it', '3336667777'),
('Paolo', 'Galli', 'paolo.galli@email.it', '3338889999'),
('Sara', 'Fontana', 'sara.fontana@email.it', '3341112222');

-- COMPONENTI
INSERT INTO componenti (sku, nome, qrcode, unita_misura, tipo) VALUES
('RAW-RES-1K', 'Resistenza 1K', 'RAW-97cbac6c-397d-431f-82c0-88521e3b9760', 'pz', 'RAW'),
('RAW-LED-RED', 'LED Rosso', 'RAW-52356207-755d-4390-b816-cdd2f7c9af7b', 'pz', 'RAW'),
('RAW-LED-GREEN', 'LED Verde', 'RAW-8b83b328-d6de-475f-9ee3-310b389ff4dd', 'pz', 'RAW'),
('ASM-MOD-002', 'Modulo LED', 'ASSEMBLY-89975a2b-ecb3-4911-8bd7-70f228f7e298', 'pz', 'ASSEMBLY');

-- STOCK
INSERT INTO stock (id_componente, quantita) VALUES
(5, 800),
(6, 500),
(7, 450),
(8, 30);

-- PARTI COMPONENTE (DISTINTA BASE)
INSERT INTO parti_componente (id_assembly, id_raw, quantita) VALUES
(8, 5, 1),
(8, 6, 1),
(8, 7, 1);

-- FORNITORI
INSERT INTO fornitore (nome, email, telefono) VALUES
('Global Electronics', 'sales@globalelectronics.com', '021111222'),
('Fast Components', 'orders@fastcomponents.it', '023334445');

-- CONSEGNE
INSERT INTO consegna (id_fornitore, data_ordine, data_ricezione, note) VALUES
(3, '2025-01-20 08:30:00', '2025-01-22 11:00:00', 'Consegna rapida'),
(4, '2025-01-25 14:00:00', NULL, 'Ordine urgente');

-- RIGHE CONSEGNA
INSERT INTO righe_consegna (id_consegna, id_componente, qta_ordinata, qta_ricevuta) VALUES
(3, 5, 300, 300),
(3, 6, 200, 200),
(4, 7, 400, 0);

-- ORDINI
INSERT INTO ordini (id_shopify, stato, id_cliente) VALUES
(10004, 'PENDING', 4),
(10005, 'IN_PICK', 5),
(10006, 'PENDING', 6);

-- RIGHE ORDINI
INSERT INTO righe_ordini (id_ordine, id_componente, quantita) VALUES
(4, 8, 3),
(5, 4, 2),
(6, 1, 20),
(6, 2, 10);

-- ASSEMBLAGGI
INSERT INTO assemblaggi (id_componente, id_utente, quantita, note) VALUES
(8, 2, 15, 'Produzione moduli LED'),
(4, 2, 8, 'Assemblaggio extra febbraio');

-- MOVIMENTI
INSERT INTO movimenti (delta, tipo, id_ordine, id_consegna, id_assemblaggio, id_componente, note) VALUES
(-3, 'ORDER', 4, NULL, NULL, 8, 'Ordine cliente 10004'),
(-2, 'ORDER', 5, NULL, NULL, 4, 'Ordine cliente 10005'),
(300, 'DELIVERY', NULL, 3, NULL, 5, 'Carico resistenze 1K'),
(200, 'DELIVERY', NULL, 3, NULL, 6, 'Carico LED rossi'),
(-15, 'ASSEMBLY', NULL, NULL, 3, 8, 'Componenti usati per assemblaggio'),
(15, 'ASSEMBLY', NULL, NULL, 3, 8, 'Assemblati moduli LED');
