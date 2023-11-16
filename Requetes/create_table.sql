
CREATE TABLE Zone (
	id_Zone varchar(50) NOT NULL,
 	nom_Zone varchar(50) DEFAULT NULL,
  	CONSTRAINT pk_zone PRIMARY KEY (id_Zone)
 );

CREATE TABLE Famille (
	id_famille varchar(50) NOT NULL,
	nom_famille varchar(50) DEFAULT NULL,
	CONSTRAINT pk_famille PRIMARY KEY(id_famille)
);

CREATE TABLE Manege (
	id_M varchar(50) NOT NULL,
  	nom_M varchar(50) DEFAULT NULL,
  	description_M varchar(50) DEFAULT NULL,
  	taille_M float DEFAULT 0,
  	id_Zone varchar(50) NOT NULL,
  	id_famille varchar(50) NOT NULL,
  	CONSTRAINT fk_manege_zone FOREIGN KEY(id_Zone) REFERENCES Zone(id_Zone),
  	CONSTRAINT fk_manege_famille FOREIGN KEY(id_famille) REFERENCES Famille(id_famille),
  	CONSTRAINT pk_manege PRIMARY KEY(id_M)
);

CREATE TABLE Clients_Manege (
	date_cli_M date NOT NULL,
  	nb_cli_M_matin int DEFAULT 0,
  	nb_cli_M_soir int DEFAULT 0,
  	id_M varchar(50) NOT NULL,
  	CONSTRAINT fk_manege FOREIGN KEY(id_M) references Manege(id_M),
  	CONSTRAINT pk_manege PRIMARY KEY(id_m, date_cli_M)
);

CREATE TABLE Boutique (
	id_bout varchar(50) NOT NULL,
  	type_bout varchar(50) DEFAULT NULL,
  	CA_bout float DEFAULT 0,
  	id_Zone varchar(50) NOT NULL,
  	CONSTRAINT fk_boutique FOREIGN KEY(id_Zone) references Zone(id_Zone),
  	CONSTRAINT pk_boutique PRIMARY KEY(id_bout)
);

CREATE TABLE Clients_Boutique (
	id_bout varchar(50) NOT NULL,
	date_cli_bout date NOT NULL,
  	nb_cli_bout int DEFAULT 0,
  	CONSTRAINT fk_cli_bout FOREIGN KEY(id_bout) references Boutique(id_bout),
  	CONSTRAINT pk_cli_bout PRIMARY KEY(id_bout, date_cli_bout)
);

CREATE TABLE Objets (
	id_objet varchar(50) NOT NULL,
  	prix_objet float DEFAULT 0,
  	qte_objet int DEFAULT 0,
  	type_objet varchar(50) DEFAULT NULL,
  	CONSTRAINT pk_objets PRIMARY KEY(id_objet)
);

CREATE TABLE Possede (
	id_bout varchar(50) NOT NULL,
  	id_objet varchar(50) NOT NULL,
  	CONSTRAINT fk_possede_bout FOREIGN KEY(id_bout) references Boutique(id_bout),
  	CONSTRAINT fk_possede_objet FOREIGN KEY(id_objet) references Objets(id_objet),
  	CONSTRAINT pk_possede PRIMARY KEY(id_bout, id_objet)
);

CREATE TABLE Vends (
	id_bout varchar(50) NOT NULL,
  	id_objet varchar(50) NOT NULL,
  	date_vente date NOT NULL,
  	qte_vente int DEFAULT 1,
  	CONSTRAINT fk_vends_bout FOREIGN KEY(id_bout) REFERENCES Boutique(id_bout),
  	CONSTRAINT fk_vends_objet FOREIGN KEY(id_objet) REFERENCES Objets(id_objet),
  	CONSTRAINT pk_vends PRIMARY KEY(id_bout, id_objet, date_vente)
);

CREATE TABLE Personnel (
	Numero_SS_P varchar(15) NOT NULL,
  	Type_P varchar(50) NOT NULL,
  	Nom_P varchar(50) NOT NULL,
  	Prenom_P varchar(50) NOT NULL,
  	Naissance_P date NOT NULL,
  	Mot_de_passe_P varchar(32) DEFAULT NULL,
  	CONSTRAINT pk_personnel PRIMARY KEY(Numero_SS_P)
);

CREATE TABLE Est_Associe (
	Numero_SS_P varchar(15) NOT NULL,
	id_famille varchar(50) NOT NULL,
	CONSTRAINT fk_assoc_SS FOREIGN KEY(Numero_SS_P) REFERENCES Personnel(Numero_SS_P),
	CONSTRAINT fk_assoc_famille FOREIGN KEY(id_famille) REFERENCES Famille(id_famille),
	CONSTRAINT pk_assoc PRIMARY KEY(Numero_SS_P, id_famille)
);

CREATE TABLE Gere_Manege (
	id_M varchar(50) NOT NULL,
  	Numero_SS_P varchar(15) NOT NULL,
  	id_famille varchar(50) NOT NULL,
  	date_fin_gere date DEFAULT NULL,
  	date_deb_gere date NOT NULL,
  	CONSTRAINT fk_gere_man_idm FOREIGN KEY(id_M) REFERENCES Manege(id_m),  
  	CONSTRAINT fk_gere_man_SS FOREIGN KEY(Numero_SS_P) REFERENCES Personnel(Numero_SS_P),
  	CONSTRAINT fk_gere_man_idf FOREIGN KEY(id_famille) REFERENCES Famille(id_famille),
  	CONSTRAINT pk_gere_man PRIMARY KEY(id_M, Numero_SS_P, id_famille, date_deb_gere)
);

CREATE TABLE Remplacant_Manege (
	id_M varchar(50) NOT NULL,
  	Numero_SS_P varchar(15) NOT NULL,
  	id_famille varchar(50) NOT NULL,
  	date_fin_remp date DEFAULT NULL,
  	date_deb_remp date NOT NULL,
  	CONSTRAINT fk_remp_man_idm FOREIGN KEY(id_M) REFERENCES Manege(id_m),  
  	CONSTRAINT fk_remp_man_SS FOREIGN KEY(Numero_SS_P) REFERENCES Personnel(Numero_SS_P),
  	CONSTRAINT fk_remp_man_idf FOREIGN KEY(id_famille) REFERENCES Famille(id_famille),
  	CONSTRAINT pk_remp_man PRIMARY KEY(id_M, Numero_SS_P, id_famille, date_deb_remp)
);

CREATE TABLE Atelier (
	id_atelier varchar(50) NOT NULL,
	id_Zone varchar(50) NOT NULL,
	CONSTRAINT fk_atelier FOREIGN KEY(id_Zone) REFERENCES Zone(id_Zone),
	CONSTRAINT pk_atelier PRIMARY KEY(id_atelier)
);

CREATE TABLE Pieces (
	id_piece varchar(50) NOT NULL,
  	nom_piece varchar(50) DEFAULT NULL,
  	CONSTRAINT pk_pieces PRIMARY KEY(id_piece)
);

CREATE TABLE Maintenance (
	id_M varchar(50) NOT NULL,
  	Numero_SS_P varchar(15) NOT NULL,
  	id_piece varchar(50) NOT NULL,
  	date_maintenance date DEFAULT NULL,
  	CONSTRAINT fk_maintenance_man FOREIGN KEY(id_M) REFERENCES Manege(id_M),
  	CONSTRAINT fk_maintenance_SS FOREIGN KEY(Numero_SS_P) REFERENCES Personnel(Numero_SS_P),
  	CONSTRAINT fk_maintenance_piece FOREIGN KEY(id_piece) REFERENCES Pieces(id_piece),
  	CONSTRAINT pk_maintenance PRIMARY KEY(id_M, Numero_SS_P, id_piece)
);

CREATE TABLE Travaille (
	Numero_SS_P varchar(15) NOT NULL,
	id_atelier varchar(50) NOT NULL,
	estResponsable bool DEFAULT FALSE,
	CONSTRAINT fk_travaille_SS FOREIGN KEY(Numero_SS_P) REFERENCES Personnel(Numero_SS_P),
	CONSTRAINT fk_travaille_atelier FOREIGN KEY(id_atelier) REFERENCES Atelier(id_atelier),
	CONSTRAINT pk_atelier PRIMARY KEY(Numero_SS_P, id_atelier)
);

CREATE TABLE Gere (
	Numero_SS_P varchar(15) NOT NULL,
	id_bout varchar(50) NOT NULL,
	estResponsable bool DEFAULT FALSE,
	CONSTRAINT fk_gere_SS FOREIGN KEY(Numero_SS_P) REFERENCES Personnel(Numero_SS_P),
	CONSTRAINT fk_gere_bout FOREIGN KEY(id_bout) REFERENCES Boutique(id_bout),
	CONSTRAINT pk_gere PRIMARY KEY(Numero_SS_P, id_bout)
);
