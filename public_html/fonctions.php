<?php
/*===================================================*/
					//Personnel
/*===================================================*/
function getTypePers($idcom) {
	$i=0;
	$requete="SELECT DISTINCT Type_P From Personnel";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		while($row=mysqli_fetch_array($result)) {
			$type[$i++]=$row[0];
		}
		return $type;
	}
	return null;
}	

/*Fonction renvoyant tous les attributs du personnel connecté*/
function estPersonnel($numSS, $mdp, $idcom) {
	$requete = "SELECT * FROM Personnel WHERE Numero_SS_P = '$numSS' AND Mot_de_passe_P = '$mdp'";
	$result = @mysqli_query($idcom, $requete);
	if ($result) {
		if (mysqli_num_rows($result) > 0) return $result;
	}
	return null;
}

function remplacePrenom($numSS, $prenom, $idcom) {
	$requete = "UPDATE Personnel SET Prenom_P = '$prenom' WHERE Numero_SS_P = '$numSS'";
	if (@mysqli_query($idcom, $requete)) return TRUE;
	return FALSE;
}

function remplaceNom($numSS, $nom, $idcom) {
	$requete = "UPDATE Personnel SET Nom_P = '$nom' WHERE Numero_SS_P = '$numSS'";
	if (@mysqli_query($idcom, $requete)) return TRUE;
	return FALSE;
}

function suppPersonnel($idcom, $numSS) {
	$requete="DELETE FROM Personnel WHERE Numero_SS_P = '$numSS'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Personne supprimé. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur suppression personnel. </span></p>\n";
	}
}

function getPersonnel($idcom) {
	$i=0;
	$requete="SELECT * FROM Personnel";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		while($row=mysqli_fetch_array($result)) {
			$tab[$i++]=array("NumSS"=>$row[0], "Type"=>$row[1], "Nom"=>$row[2], "Prenom"=>$row[3], "Naissance"=>$row[4], "Mdp"=>$row[5]);
		}
		return $tab;
	}
	return null;
}

function addPersonnel($idcom, $numSS, $type_p, $nom_p, $prenom_p, $date, $mdp) {
	$requete="INSERT INTO Personnel VALUES ('$numSS', '$type_p', '$nom_p', '$prenom_p', '$date', '$mdp')";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Personnel '$nom_p $prenom_p' ajouté. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur ajout personnel. </span></p>\n";
	}
}

function modPersonnel($idcom, $numSS_ori, $numSS, $type_p, $nom_p, $prenom_p, $date, $mdp) {
	$requete="UPDATE Personnel SET Numero_SS_P='$numSS', Type_P='$type_p', Nom_P='$nom_p', Prenom_P='$prenom_p', Naissance_P='$date', Mot_de_passe_P='$mdp' WHERE Numero_SS_P='$numSS_ori'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Personnel '$numSS_ori' modifié. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur modification personnel. </span></p>\n";
	}
}
/*===================================================*/
					//Manege
/*===================================================*/

//Renvoie un tableau associatif avec les noms des maneges, leurs descritpions,leurs familles, leurs zones 
function getManege($idcom) {
	$i = 0;
	$requete = "SELECT id_M, nom_M, description_M, taille_M, nom_famille, nom_zone FROM Manege m, Famille f, Zone z WHERE m.id_zone=z.id_zone AND m.id_famille=f.id_famille";
	$result = @mysqli_query($idcom, $requete);
	if ($result) {
		while ($row = mysqli_fetch_array($result)) {
			$manege[$i++] = array("Id"=>$row[0], "Nom"=>$row[1], "Description"=>$row[2],"Taille"=>$row[3], "Famille"=>$row[4], "Zone"=>$row[5]);
		}
		/*for($i=0; $i<mysqli_num_rows($result); ++$i) {
			foreach ($manege[$i] as $cle => $val) {
				echo $cle."=>".$val. " | ";
			}
			echo "<br>";
		}*/
		return $manege;
	}
	return null;
}

function addManege($idcom, $id_m, $nom_m, $descr_m, $taille_m, $id_zone, $id_famille) {
	$requete="INSERT INTO Manege VALUES ('$id_m', '$nom_m', '$descr_m', $taille_m, '$id_zone', '$id_famille')";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Manège ajouté. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur ajout manège. </span></p>\n";
	}
}

function suppManege($idcom, $id_m) {
	$requete = "DELETE FROM Manege WHERE id_M='$id_m'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Manège '$id_m' supprimé. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur suppression manège. </span></p>\n";
	}
}

function modManege($idcom, $id_m, $mod_id_m, $nom_m, $desc_m, $taille_m, $zone_m, $famille_m) {
	$requete="UPDATE Manege SET id_M='$mod_id_m', nom_M='$nom_m', description_M='$desc_m', taille_M=$taille_m, id_Zone='$zone_m', id_famille='$famille_m'  WHERE id_M = '$id_m'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Manège '$id_m' modifié. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur modification manège. </span></p>\n";
	}
}

function getCM($idcom, $id_M) {
	$i=0;
	$tab=array();
	$requete="SELECT Nom_P, Prenom_P, P.Numero_SS_P, date_deb_gere, date_fin_gere FROM Personnel P, Gere_Manege G WHERE P.Numero_SS_P=G.Numero_SS_P AND id_M='$id_M'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		while($row=mysqli_fetch_array($result)) {
			$tab[$i++]=array("Nom"=>$row[0], "Prenom"=>$row[1], "NumSS"=>$row[2], "Deb"=>$row[3], "Fin"=>$row[4]);
		}
	}
	return $tab;
}

function getCMRemp($idcom, $id_M) {
	$i=0;
	$tab=array();
	$requete="SELECT Nom_P, Prenom_P, P.Numero_SS_P, date_deb_remp, date_fin_remp FROM Personnel P, Remplacant_Manege R WHERE P.Numero_SS_P=R.Numero_SS_P AND id_M='$id_M'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		while($row=mysqli_fetch_array($result)) {
			$tab[$i++]=array("Nom"=>$row[0], "Prenom"=>$row[1], "NumSS"=>$row[2], "Deb"=>$row[3], "Fin"=>$row[4]);
		}
	}
	return $tab;
}

function addGerant($idcom, $id_M, $numSS, $id_famille, $date_deb, $date_fin) {
	$requete="INSERT INTO Gere_Manege VALUES ('$id_M', '$numSS', '$id_famille', '$date_fin', '$date_deb')";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'>Gérant ajouté.</span></p>";
	}
	else {
		echo "<p><span class='request'>Erreur ajout gérant.</span></p>";
	}
}

function addRemplacant($idcom, $id_M, $numSS, $id_famille, $date_deb, $date_fin) {
	$requete="INSERT INTO Remplacant_Manege VALUES ('$id_M', '$numSS', '$id_famille', '$date_fin', '$date_deb')";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'>Remplaçant ajouté.</span></p>";
	}
	else {
		echo "<p><span class='request'>Erreur ajout remplaçant.</span></p>";
	}
}

function suppGerant($idcom, $numSS, $id_M, $date_deb) {
	$requete="DELETE FROM Gere_Manege WHERE Numero_SS_P='$numSS' AND id_M='$id_M' AND DATE_FORMAT(date_deb_gere, '%Y-%m-%d')='$date_deb'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'>Gérant supprimé.</span></p>";
	}
	else echo "<p><span class='request'>Erreur suppression gérant.</span></p>";
}

function suppRemplacant($idcom, $numSS, $id_M, $date_deb) {
	$requete="DELETE FROM Remplacant_Manege WHERE Numero_SS_P='$numSS' AND id_M='$id_M' AND DATE_FORMAT(date_deb_remp, '%Y-%m-%d')='$date_deb'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'>Remplaçant supprimé.</span></p>";
	}
	else echo "<p><span class='request'>Erreur suppression remplaçant.</span></p>";
}

/*===================================================*/
					//Boutique
/*===================================================*/

function getBoutique($idcom) {
	$i=0;
	$boutique=array();
	$requete = "SELECT id_bout, type_bout, CA_bout, nom_zone FROM Boutique b, Zone z WHERE b.id_zone=z.id_zone";
	$result = @mysqli_query($idcom, $requete);
	if ($result) {
		while ($row = mysqli_fetch_array($result)) {
			$boutique[$i++] = array("Id"=>$row[0], "Type"=>$row[1], "CA"=>$row[2] ,"Zone"=>$row[3]);	
		}
	}
	return $boutique;
}

function addBoutique($idcom, $id_bout, $type_bout, $CA_bout ,$id_zone) {
	$requete="INSERT INTO Boutique VALUES ('$id_bout', '$type_bout', $CA_bout,'$id_zone')";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Boutique ajoutée. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur ajout boutique. </span></p>\n";
	}
}

function suppBoutique($idcom, $id_bout) {
	$requete = "DELETE FROM Boutique WHERE id_bout='$id_bout'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Boutique '$id_bout' supprimé. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur suppression boutique. </span></p>\n";
	}
}

function modBoutique($idcom, $id_bout, $mod_id_bout, $type_bout, $CA_bout, $zone_bout) {
	$requete="UPDATE Boutique SET id_bout='$mod_id_bout', type_bout='$type_bout', CA_bout='$CA_bout', id_Zone='$zone_bout' WHERE id_bout = '$id_bout'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Boutique '$id_bout' modifié. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur modification boutique. </span></p>\n";
	}
}

function getVendeurs($idcom, $id_bout) {
	$i=0;
	$tab=array();
	$requete="SELECT Nom_P, Prenom_P, P.Numero_SS_P, estResponsable FROM Personnel P, Gere G WHERE G.Numero_SS_P=P.Numero_SS_P AND id_bout='$id_bout'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		while ($row=mysqli_fetch_array($result)) {
			$tab[$i++]=array("Nom"=>$row[0], "Prenom"=>$row[1], "NumSS"=>$row[2], "estResp"=>$row[3]);
		}
	}
	return $tab;
}

function addVendeur($idcom, $numSS, $id_bout, $estResponsable) {
	$requete="INSERT INTO Gere VALUES ('$numSS', '$id_bout', '$estResponsable')";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'>Vendeur ajouté.</span></p>";
	}
	else {
		echo "<p><span class='request'>Erreur ajout vendeur.</span></p>";
	}
}

function suppVendeur($idcom, $numSS, $id_bout) {
	$requete="DELETE FROM Gere WHERE id_bout='$id_bout' AND Numero_SS_P='$numSS'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'>Vendeur supprimé.</span></p>";
	}
	else {
		echo "<p><span class='request'>Erreur suppression vendeur.</span></p>";
	}
}

/*===================================================*/
					//Zone
/*===================================================*/

function getZone($idcom) {
	$i=0;
	$result=array();
	$requete = "SELECT * FROM Zone";
	$res=@mysqli_query($idcom, $requete);
	while ($row = mysqli_fetch_array($res)) {
		$result[$i++] = array("id"=>$row[0], "nom"=>$row[1]);
	}
	return $result;
}

/*===================================================*/
					//Famille
/*===================================================*/

function getFamille($idcom) {
	$i=0;
	$result=array();
	$requete = "SELECT * FROM Famille";
	$res=@mysqli_query($idcom, $requete);
	while ($row = mysqli_fetch_array($res)) {
		$result[$i++] = array("id"=>$row[0], "nom"=>$row[1]);
	}
	return $result;
}

/*===================================================*/
					//Barre de recherche
/*===================================================*/

function getResultSearchBar($idcom, $search) {
	$manege=getManege($idcom);
	$boutique=getBoutique($idcom);
	$match = FALSE;
	$pattern = '/'.strtolower($search).'/';
	$j=0;

	for ($i=0; $i<count($manege); ++$i) {
		foreach($manege[$i] as $cle=>$val) {
			if (preg_match($pattern, strtolower($val))) $match = TRUE;
			if ($match) {
				$result[$j++] = $manege[$i];
				$match = FALSE;
				break;
			}
		}
	}
	for ($i=0; $i<count($boutique); ++$i) {
		foreach($boutique[$i] as $cle => $val) {
			if (preg_match($pattern, strtolower($val))) $match = TRUE;
			if ($match) {
				$result[$j++] = $boutique[$i];
				$match = FALSE;
				break;
			}
		}
	}
	return (isset($result)) ? $result : null;
}

/*===================================================*/
					//Atelier
/*===================================================*/

function getAtelier($idcom, $id_atelier) {
	$i=0;
	$tab=array();
	$result=@mysqli_query($idcom, "SELECT * FROM Atelier WHERE id_atelier='$id_atelier'");
	if (mysqli_num_rows($result)==1) {
		$row=mysqli_fetch_array($result);
		$tab=array("Id"=>$row[0], "Zone"=>$row[1]);
	}
	return $tab;
}
function modAtelier($idcom, $id_atelier, $mod_id_atelier, $id_zone) {
	$requete="UPDATE Atelier SET id_atelier='$mod_id_atelier', id_Zone='$id_zone' WHERE id_atelier = '$id_atelier'";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		echo "<p><span class='request'> Atelier '$id_atelier' modifié. </span></p>\n";
	}
	else {
		echo "<p><span class='request'> Erreur modification Atelier . </span></p>\n";
	}
}

//Renvoi les techniciens disponibles dans le zone donnée en parametres
function getTechnicien($idcom, $nom_Zone) {
	$i=0;
	$tab=array();
	$requete="SELECT Nom_P, Prenom_P, P.Numero_SS_P FROM Personnel P, Travaille T, Atelier A WHERE P.Numero_SS_P=T.Numero_SS_P AND A.id_atelier=T.id_atelier AND id_Zone=(SELECT id_Zone FROM Zone WHERE nom_Zone='$nom_Zone')";
	$result=@mysqli_query($idcom, $requete);
	if ($result) {
		while ($row=mysqli_fetch_array($result)) {
			$tab[$i++]=array("Nom"=>$row[0], "Prenom"=>$row[1], "NumSS"=>$row[2]);
		}
	}
	return $tab;
}

/*===================================================*/
					//Maintenance
/*===================================================*/

function addMaintenance($idcom, $id_M, $numSS, $id_piece, $date_maintenance) {
	$requete="INSERT INTO Maintenance (id_M, Numero_SS_P, id_piece, date_maintenance) VALUES ('$id_M', '$numSS', '$id_piece', '$date_maintenance')";
	$result=mysqli_query($idcom, $requete);
	if ($result) echo "<p><span class='request'>Maintenance ajoutée : le technicien mettra fin à la maintenance.</span></p>";
	else echo "<p><span class='request'>Erreur ajout maintenance</span></p>";
}

function addMaintenance2($idcom, $id_M, $numSS, $date_fin_maintenance) {
	$requete="UPDATE Maintenance SET date_fin_maintenance='$date_fin_maintenance' WHERE id_M='$id_M' AND date_fin_maintenance IS NULL";
	$result=mysqli_query($idcom, $requete);
	if ($result) echo "<p><span class='request'>Maintenance finie.</span></p>";
	else echo "<p><span class='request'>Erreur fin maintenance.</span></p>";
}
?>
