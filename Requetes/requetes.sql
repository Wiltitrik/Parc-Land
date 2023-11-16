SELECT M.Numero_SS_P, Nom_P, Prenom_P FROM Personnel P, Maintenance M, Manege Ma WHERE P.Numero_SS_P = M.Numero_SS_P AND M.id_M = Ma_id_M AND upper(Ma.Nom_M) = "SPLASH" AND TO_CHAR(M.date_maintenance ,  'DD/MM/YYYY') = '12/03/2022';

SELECT Numero_SS_P FROM Remplacant_Manege R, Manege M WHERE R.id_M = M.id_M AND upper(Nom_M) = 'BIG NOISE' AND TO_CHAR(date_deb_remp, 'DD/MM/YYYY') <= '11/11/2023' AND TO_CHAR(date_deb_remp, 'DD/MM/YYYY') >= '11/11/2023';

SELECT type_objet, SUM(V.qte_vente*O.prix_objet) FROM Vends V, Objets O WHERE O.id_objet = V.id_objet GROUP BY type_objet;

SELECT id_pieces FROM Maintenance M, Manege Ma WHERE M.id_M = Ma.id_M AND upper(Ma.Nom_M) = 'HIGH-SPEED' AND date_maintenance IN (Select id_m, MAX(date_maintenance) FROM Maintenance group by id_M);

SELECT id_objet FROM Possede GROUP BY id_objet HAVING COUNT(*) = (Select COUNT(*) FROM Boutique); 

-- Quels boutiques a fait + de 1000 ventes ?
SELECT id_bout, SUM(qte_vente) FROM Vends GROUP BY id_bout HAVING SUM(qte_vente) > 1000;

--Quels objets ont été vendus + de 100 fois ?
SELECT id_objet, SUM(qte_vente) FROM Vends GROUP BY id_objet HAVING SUM(qte_vente) > 100;

-- Quels manèges sont dans la famille 'Manèges horreur' ?
SELECT nom_manege FROM Manege WHERE id_famille IN (SELECT id_famille FROM Famille WHERE nom_famille = 'Manèges horreur');
