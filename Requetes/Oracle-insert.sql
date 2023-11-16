INSERT INTO Zone (id_Zone, nom_Zone)
 VALUES 
('Z001', 'Vertige'),
('Z002', 'Aquatique'),
('Z003', 'Western'),
('Z004', 'Pirate'),
('Z005', 'Futuriste'),
('Z006', 'Fantaisie'),
('Z007', 'Jurassique'),
('Z008', 'Médiéval'),
('Z009', 'Carnaval'),
('Z010', 'Science-fiction');

INSERT INTO Famille (id_famille, nom_famille) 
VALUES ('F001', 'Montagnes Russes'),
       ('F002', 'Carrousels'),
       ('F003', 'Manèges à sensation forte'),
       ('F004', 'Manèges pour enfants'),
       ('F005', 'Manèges aquatiques'),
       ('F006', 'Manèges de réalité virtuelle'),
       ('F007', 'Manèges à thème'),
       ('F008', 'Manèges musicaux'),
       ('F009', 'Manèges horreur'),
       ('F010', 'Manèges de cirque');
       
INSERT INTO Manege (id_M, nom_M, description_M, taille_M, id_Zone, id_famille) 
VALUES 
('M001', 'Big Noise', 'Montagne russe à grande vitesse', 1.5, 'Z001', 'F003'),
('M002', 'High-Speed', 'Montagne russe à haute vitesse', 1.4, 'Z001', 'F003'),
('M003', 'Wild River', 'Attraction de rafting en eaux vives', 1.2, 'Z002', 'F003'),
('M004', 'Crazy Loop', 'Montagne russe à loopings', 1.3, 'Z003', 'F003'),
('M005', 'Flying Chairs', 'Manège de chaises volantes', 1.1, 'Z004', 'F001'),
('M006', 'The Tower', 'Tour de chute libre', 1.4, 'Z002', 'F001'),
('M007', 'Roller Coaster', 'Montagnes russes classiques', 1.2, 'Z005', 'F001'),
('M008', 'Bumper Cars', 'Manège de voitures tamponneuses', 1.1, 'Z006', 'F004'),
('M009', 'Ferris Wheel', 'Grande roue panoramique', 1.0, 'Z007', 'F004'),
('M010', 'Pirate Ship', 'Manège de bateau pirate', 1.2, 'Z002', 'F007');

INSERT INTO Clients_Manege VALUES 
(TO_DATE('01/03/2022', 'DD/MM/YYYY'), '50', '80', 'M001'),
(TO_DATE('02/03/2022', 'DD/MM/YYYY'), '60', '100', 'M002'),
(TO_DATE('03/03/2022', 'DD/MM/YYYY'), '40', '70', 'M003'),
(TO_DATE('04/03/2022', 'DD/MM/YYYY'), '70', '120', 'M004'),
(TO_DATE('05/03/2022', 'DD/MM/YYYY'), '55', '90', 'M005'),
(TO_DATE('06/03/2022', 'DD/MM/YYYY'), '80', '130', 'M006'),
(TO_DATE('07/03/2022', 'DD/MM/YYYY'), '45', '75', 'M007'),
(TO_DATE('08/03/2022', 'DD/MM/YYYY'), '65', '110', 'M008'),
(TO_DATE('09/03/2022', 'DD/MM/YYYY'), '75', '140', 'M009'),
(TO_DATE('10/03/2022', 'DD/MM/YYYY'), '90', '160', 'M010');

INSERT INTO Boutique (id_bout, type_bout, CA_bout, id_Zone)
 VALUES
('B001', 'Souvenir', 12000, 'Z001'),
('B002', 'Déguisement', 15000, 'Z002'),
('B003', 'Nourriture', 10000, 'Z003'),
('B004', 'Boisson', 8000, 'Z004'),
('B005', 'Jouet', 5000, 'Z005'),
('B006', 'Accessoire', 6000, 'Z006'),
('B007', 'Souvenir', 11000, 'Z007'),
('B008', 'Déguisement', 13000, 'Z008'),
('B009', 'Nourriture', 9000, 'Z009'),
('B010', 'Boisson', 7500, 'Z010');

INSERT INTO Clients_Boutique
VALUES
 ('C001', TO_DATE('12/02/2022', 'DD/MM/YYYY'), '10'),
('C002', TO_DATE('05/03/2022', 'DD/MM/YYYY'), '23'),
 ('C003', TO_DATE('20/04/2022', 'DD/MM/YYYY'), '6'),
('C004', TO_DATE('10/05/2022', 'DD/MM/YYYY'), '20'),
 ('C005', TO_DATE('18/06/2022', 'DD/MM/YYYY'), '10'),
('C006', TO_DATE('03/07/2022', 'DD/MM/YYYY'), '16'),
 ('C007', TO_DATE('09/08/2022', 'DD/MM/YYYY'), '18'),
 ('C008', TO_DATE('24/09/2022', 'DD/MM/YYYY'), '30'),
 ('C009', TO_DATE('16/10/2022', 'DD/MM/YYYY'), '29'),
 ('C010', TO_DATE('02/11/2022', 'DD/MM/YYYY'), '40');
 
INSERT INTO Objets (id_objet, prix_objet, qte_objet, type_objet)
VALUES
('O01', 50.00, '10', 'Montre'),
('O02', 2.50, '20', 'Stylo'),
('O03', 1.50, '15', 'Crayon'),
('O04', 10.99, '50', 'souvenir'),
 ('O05', 29.99, '20', 'déguisement'),
('O06', 5.50, '100', 'jouet'),
('O07', 12.99, '50', 'Livre'),
('O08', 2.99, '100', 'Porte-clés'),
('O09', 10, '20', 'Lunettes de soleil'),
('O10', 25.00, '5', 'Maillot de bain');

INSERT INTO Possede (id_bout, id_objet)
VALUES 
('B01', 'O01'),
('B02', 'O02'),
('B03', 'O03'),
('B04', 'O04'),
('B05', 'O05'),
('B06', 'O06'),
('B07', 'O07'),
('B08', 'O08'),
('B09', 'O09'),
('B10', 'O10');

INSERT INTO Vends(id_bout, id_objet, date_vente, qte_vente)
VALUES 
('B01', 'O01', TO_DATE('01/05/2022', 'DD/MM/YYYY'), 10),
('B02', 'O02', TO_DATE('15/06/2022', 'DD/MM/YYYY'), 5),
('B03', 'O03', TO_DATE('30/07/2022', 'DD/MM/YYYY'), 8),
('B04', 'O04', TO_DATE('20/08/2022', 'DD/MM/YYYY'), 3),
('B05', 'O05', TO_DATE('05/09/2022', 'DD/MM/YYYY'), 12),
('B06', 'O06', TO_DATE('10/10/2022', 'DD/MM/YYYY'), 6),
('B07', 'O07', TO_DATE('15/11/2022', 'DD/MM/YYYY'), 7),
('B08', 'O08', TO_DATE('05/01/2023', 'DD/MM/YYYY'), 9),
('B09', 'O09', TO_DATE('28/02/2023', 'DD/MM/YYYY'), 4),
('B10', 'O10', TO_DATE('11/11/2023', 'DD/MM/YYYY'), 2);

INSERT INTO Personnel (Numero_SS_P, Type_p, Nom_P, Prenom_P, Naissance_P, Mot_de_passe_P)
VALUES
('100011223344511', 'CM', 'Dupont', 'Paul', TO_DATE('12/05/1980', 'DD/MM/YYYY'), 'paul123'),
('100022334455611', 'vendeur', 'Martin', 'Sophie', TO_DATE('20/02/1995', 'DD/MM/YYYY'), 'sophie456'),
('100033445566711', 'serveur', 'Garcia', 'Luis', TO_DATE('07/10/1987', 'DD/MM/YYYY'), 'luis789'),
('100044556677811', 'technicien', 'Lefevre', 'Antoine', TO_DATE('16/08/1992', 'DD/MM/YYYY'), 'antoine123'),
('100055667788911', 'directeur', 'Leclerc', 'François', TO_DATE('01/12/1975', 'DD/MM/YYYY'), 'francois123'),
('100066778899011', 'CM', 'Dumont', 'Marie', TO_DATE('18/06/1991', 'DD/MM/YYYY'), 'marie123'),
('100077889900111', 'vendeur', 'Dubois', 'Luc', TO_DATE('02/04/1985', 'DD/MM/YYYY'), 'luc456'),
('100088900011211', 'serveur', 'Roux', 'Emma', TO_DATE('27/11/1993', 'DD/MM/YYYY'), 'emma789'),
('100099011122311', 'technicien', 'Petit', 'Jean', TO_DATE('14/09/1988', 'DD/MM/YYYY'), 'jean123'),
('100010112233411', 'CM', 'Moreau', 'Julie', TO_DATE('05/01/1999', 'DD/MM/YYYY'), 'julie123');

INSERT INTO est_Associe (Numero_SS_P, id_famille) VALUES
 ('100011223344511', 'F001'),
('100022334455611', 'F002'),
 ('100033445566711', 'F003'),
 ('100044556677811', 'F004'),
('100055667788911', 'F005'),
 ('100066778899011', 'F006'),
 ('100077889900111', 'F007'),
 ('100088900011211', 'F008'),
 ('100099011122311', 'F009'),
 ('100010112233411', 'F001');

INSERT INTO Gere_manege (id_M, Numero_SS_P, id_famille, date_fin_gere, date_deb_gere)
VALUES 
('M001', '123456789012345', 'F001', TO_DATE('30/03/2023', 'DD/MM/YYYY'), TO_DATE('01/01/2022', 'DD/MM/YYYY')),
('M002', '100011223344511', 'F002', TO_DATE('30/06/2022', 'DD/MM/YYYY'), TO_DATE('01/01/2022', 'DD/MM/YYYY')),
('M003', '100022334455611', 'F003', TO_DATE('31/12/2023', 'DD/MM/YYYY'), TO_DATE('01/01/2023', 'DD/MM/YYYY')),
('M004', '100033445566711', 'F004', TO_DATE('31/12/2022', 'DD/MM/YYYY'), TO_DATE('01/01/2022', 'DD/MM/YYYY')),
('M005', '100044556677811', 'F005', TO_DATE('30/06/2023', 'DD/MM/YYYY'), TO_DATE('01/01/2023', 'DD/MM/YYYY')),
('M006', '100055667788911', 'F006', TO_DATE('31/12/2022', 'DD/MM/YYYY'), TO_DATE('01/01/2022', 'DD/MM/YYYY')),
('M007', '100066778899011', 'F007', TO_DATE('31/12/2023', 'DD/MM/YYYY'), TO_DATE('01/01/2023', 'DD/MM/YYYY')),
('M008', '100088900011211', 'F008', TO_DATE('30/06/2022', 'DD/MM/YYYY'), TO_DATE('01/01/2022', 'DD/MM/YYYY')),
('M009', '100099011122311', 'F009', TO_DATE('30/06/2023', 'DD/MM/YYYY'), TO_DATE('01/01/2023', 'DD/MM/YYYY')),
('M010', '100010112233411', 'F001', TO_DATE('31/12/2023', 'DD/MM/YYYY'), TO_DATE('01/01/2023', 'DD/MM/YYYY'));

INSERT INTO Remplacant_Manege (Id_M, Numero_SS_P, id_famille, date_fin_gere, date_deb_gere)
VALUES
('M001', '100011223344511', 'F001', TO_DATE('30/03/2023', 'DD/MM/YYYY'), TO_DATE('30/03/2023', 'DD/MM/YYYY')),
('M002', '100022334455611', 'F001', TO_DATE('01/04/2023', 'DD/MM/YYYY'), TO_DATE('14/04/2023', 'DD/MM/YYYY')),
('M003', '100033445566711', 'F002', TO_DATE('15/04/2023', 'DD/MM/YYYY'), TO_DATE('29/04/2023', 'DD/MM/YYYY')),
('M004', '100044556677811', 'F002', TO_DATE('30/04/2023', 'DD/MM/YYYY'), TO_DATE('30/04/2023', 'DD/MM/YYYY')),
('M005', '100055667788911', 'F003', TO_DATE('01/05/2023', 'DD/MM/YYYY'), TO_DATE('14/05/2023', 'DD/MM/YYYY')),
('M006', '100066778899011', 'F003', TO_DATE('15/05/2023', 'DD/MM/YYYY'), TO_DATE('29/05/2023', 'DD/MM/YYYY')),
('M007', '100077889900111', 'F004', TO_DATE('30/05/2023', 'DD/MM/YYYY'), TO_DATE('30/06/2023', 'DD/MM/YYYY')),
('M008', '100088900011211', 'F004', TO_DATE('01/06/2023', 'DD/MM/YYYY'), TO_DATE('12/06/2023', 'DD/MM/YYYY')),
('M009', '100099011122311', 'F005', TO_DATE('15/06/2023', 'DD/MM/YYYY'), TO_DATE('29/06/2023', 'DD/MM/YYYY')),
('M010', '100010112233411', 'F005', TO_DATE('30/06/2023', 'DD/MM/YYYY'), TO_DATE('12/07/2023', 'DD/MM/YYYY'));

INSERT INTO Atelier(id_Atelier, id_Zone)
VALUES 
('A01', 'Z001'),
('A02', 'Z002'),
('A03', 'Z003'),
('A04', 'Z004'),
('A05', 'Z005'),
('A06', 'Z006'),
('A07', 'Z007'),
('A08', 'Z008'),
('A09', 'Z009'),
('A10', 'Z010');

INSERT INTO Pieces (id_piece, nom_piece)
VALUES 
('P001', 'Visserie'),
('P002', 'Roulements'),
('P003', 'Courroies'),
('P004', 'Charnières'),
('P005', 'Pompes hydrauliques'),
('P006', 'Filtres'),
('P007', 'Capteurs'),
('P008', 'Cylindres hydrauliques'),
('P009', 'Joints'),
('P010', 'Engrenages');

INSERT INTO Maintenance(id_M, Numero_SS_P, id_piece, date_maintenance)
VALUES 
('M01', '100011223344511', 'P01', TO_DATE('01/01/2022', 'DD/MM/YYYY')),
('M02', '100022334455611', 'P02', TO_DATE('02/01/2022', 'DD/MM/YYYY')),
('M03', '100033445566711', 'P03', TO_DATE('03/01/2022', 'DD/MM/YYYY')),
('M04', '100044556677811', 'P04', TO_DATE('04/01/2022', 'DD/MM/YYYY')),
('M05', '100055667788911', 'P05', TO_DATE('05/01/2022', 'DD/MM/YYYY')),
('M06', '100066778899011', 'P06', TO_DATE('06/01/2022', 'DD/MM/YYYY')),
('M07', '100077889900111', 'P07', TO_DATE('07/01/2022', 'DD/MM/YYYY')),
('M08', '100088900011211', 'P08', TO_DATE('08/01/2022', 'DD/MM/YYYY')),
('M09', '100099011122311', 'P09', TO_DATE('09/01/2022', 'DD/MM/YYYY')),
('M10', '100010112233411', 'P10', TO_DATE('10/01/2022', 'DD/MM/YYYY'));

INSERT INTO Travaille (Numero_SS_P, id_atelier, estResponsable) 
VALUES 
('100011223344511', 'A01', TRUE),
('100022334455611', 'A02', FALSE),
 ('100033445566711', 'A03', TRUE),
 ('100044556677811', 'A04', FALSE),
 ('100055667788911', 'A05', TRUE),
 ('100066778899011', 'A06', FALSE),
 ('100077889900111', 'A07', TRUE),
 ('100088900011211', 'A08', FALSE),
 ('100099011122311', 'A09', TRUE),
 ('100010112233411', 'A10', FALSE);


INSERT INTO Gere (Numero_SS_P, id_bout, estResponsable) VALUES 
('100011223344511', 'B001', TRUE),
('100022334455611', 'B001', FALSE),
('100033445566711', 'B002', TRUE),
('100044556677811', 'B002', FALSE),
('100055667788911', 'B003', TRUE),
('100066778899011', 'B003', FALSE),
('100077889900111', 'B004', TRUE),
('100088900011211', 'B004', FALSE),
('100099011122311', 'B005', TRUE),
('100010112233411', 'B005', FALSE);
