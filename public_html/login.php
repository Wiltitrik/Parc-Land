<html>
<head> 
	<meta charset='utf-8'>
	<link rel='stylesheet' href='login.css'>
</head>
<body>
	<?php
		session_start();
		include('connex.inc.php');
		include('fonctions.php');
		
		if (isset($_SESSION["numSS"]) && isset($_SESSION["mdp"])) {
			$numSS=$_SESSION["numSS"];
			$mdp=$_SESSION["mdp"];
		}
		else if (isset($_POST["login"]) && isset($_POST["mdp"])) {
			$numSS=$_POST["login"];
			$mdp=$_POST["mdp"];
			$_SESSION["numSS"]=$numSS;
			$_SESSION["mdp"]=$mdp;
		}
		else {
			die("Mot de passe et login manquant.");
		}

		if (isset($numSS) && isset($mdp)) {
			//Connexion à la BD
			$idcom=connex("myparam");
			//Tableau nécessaire pour la section "Directeur - CM"
			$pers=getPersonnel($idcom);
			$manege=getManege($idcom);
			$bout=getBoutique($idcom);
			$zone=getZone($idcom);
			$famille=getFamille($idcom);
			$type_p=getTypePers($idcom);

			if ($idcom) {
				if ($user=estPersonnel($numSS, $mdp, $idcom)) {
					$row = mysqli_fetch_array($user);
					// Info perso
					echo "Bonjour " .$row[3]. " " .$row[2]. ".\n";
					echo "\t<div class='container'>\n";
					echo "\t\t<h3> Vos infos : </h3>\n";
					echo "\t\t<p>Numéro de sécu : ".$row[0]."\n";
					echo "\t\t<p>Poste : ".$row[1]."\n";
					echo "\t\t<p>Date de naissance : ".$row[4]."\n";
					echo "\t</div>\n";
					echo "\t<div class='container'>\n";
					echo "\t\t<h3> Changement de vos infos :</h3>\n";
					echo "\t\t<form method='POST' action='changeinfo.php'>\n";
					echo "\t\t\t<p> Changer de prénom : <input type='text' name='prenom' value='".$row[3]."'><input type='submit' name='changeprenom' value='Changer'</p>\n";
					echo "\t\t\t<p> Changer de nom : <input type='text' name='nom' value='".$row[2]."'><input type='submit' name='changenom' value='Changer'</p></p>\n";
					echo "\t\t</form>\n\t</div>\n";

					//Barre de recherche
					?>
					<div class='container'>
						<h3> Barre de recherche </h3>
						<form method='POST' action=''>
							<input type='text' name='search'required> <input type='submit' name='sub-search' value='Rechercher'>
						</form>
					<?php
					if (isset($_POST['sub-search'])) {
						$resultat=getResultSearchBar($idcom, $_POST['search']);

						if ($resultat) {
							echo "<form method='GET' action='man_bout_info.php'>";
							echo "\t<p> Nombre de résultat(s) : ".count($resultat). "</p>\n" ;
							echo "\t\t\t\t\t\t<ul>\n";
							for ($i=0; $i<count($resultat); ++$i) {
								echo "\t\t\t\t\t\t\t<li>";
								foreach($resultat[$i] as $cle => $val) {
									if (!strcmp($cle, "Id")) {
										echo "<a href='man_bout_info.php?info=$val'> $val </a>";
									}
									else echo $val. "- ";
								}
								echo "</li>\n";
							}
							echo "\t\t\t\t\t\t</ul>\n";
						}
						else {
							echo "Pas de résultat\n";
						}
					}
					echo "</form> </div>\n";
					// Directeur
					if (!strcmp($row[1], "directeur")) {
						?>
						<div class='container'>
							<h3> Fenêtre directeur </h3>
								<h4> Manèges :</h4>
								<p> <span class='choice'> Ajouter un manège : </span> </p>
								<form method='POST' action=''>
									<ul>
										<li> ID : <input type='text' name='id-man' required><span class="validity"></span></li>
										<li> Nom : <input type='text' name='nom-man' required><span class="validity"></span></li>
										<li> Description : <input type='text' name='desc-man' ></li>
										<li> Taille : <input type='number' name='taille-man' step='0.01' required><span class="validity"></span></li>
										<li> Zone : <select name='zone-man'>
													<?php
														for ($i=0; $i<count($zone); ++$i) {
															echo "<option value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
														}
													?>
													</select> </li>
										<li> Famille : <select name='fam-man'>
													<?php
														for ($i=0; $i<count($famille); ++$i) {
															echo "<option value='".$famille[$i]['id']."'>".$famille[$i]['nom']."</option>\n";
														}
													?>
													</select> </li>
										<input type='submit' value='Ajouter' class='sub-button' name='sub-addman'>
									</ul>
								</form>
								<?php
								if (isset($_POST['sub-addman'])) {
									addManege($idcom, $_POST['id-man'], $_POST['nom-man'], $_POST['desc-man'], $_POST['taille-man'], $_POST['zone-man'], $_POST['fam-man']);
									//header("refresh:0");
								}
								?>
								<form method='post' action=''>
								<p> <span class='choice'> Choisir un manège : </span>
									<select name='manege'>
										<?php 
										for ($i=0; $i<count($manege); ++$i) {
											echo "<option value='".$manege[$i]['Id']."'>".$manege[$i]['Nom']."</option>\n";
										}
										?>
									</select>
									<input type='submit' value='Supprimer' name='supp-man'> <input type='submit' value='Modifier' name='mod-man'>
								
								</p>
								</form>
								<?php
								if (isset($_POST['supp-man'])) {
									suppManege($idcom, $_POST['manege']);
									//header("refresh:0");
								}
								if (isset($_POST['mod-man'])) {
									//Sauvegarde du choix du manège
									$_SESSION['manege']=$_POST['manege'];
								}
								if (isset($_SESSION['manege'])) {
									//Recherche du manège à modifier dans l'array de manège (les infos du manege seront contenu dans mod_man[])
									$trouve=FALSE;
									for ($i=0; $i<count($manege) && !$trouve; ++$i) {
										if (!strcmp($manege[$i]['Id'], $_SESSION['manege'])) {
											$mod_man=$manege[$i];
											$trouve=TRUE;
										} 
									}
									echo "<fieldset> <legend> ".$mod_man['Nom']. "</legend>\n";
									echo "<form method='post' action=''>\n<ul>\n";
									echo "<li> ID : <input type='text' name='mod-id-man' value='".$mod_man['Id']."' required><span class='validity'></span></li>\n";
									echo "<li> Nom : <input type='text' name='mod-nom-man' value='".$mod_man['Nom']."' required><span class='validity'></span></li>\n";
									echo "<li> Description : <input type='text' name='mod-desc-man' value='".$mod_man['Description']."' required><span class='validity'></span></li>\n";
									echo "<li> Taille : <input type='number' step='0.01' name='mod-taille-man' value='".$mod_man['Taille']."' required><span class='validity'></span></li>\n";
									echo "<li> Zone : <select name='mod-zone-man'>\n";
														for ($i=0; $i<count($zone); ++$i) {
															if (!strcmp($zone[$i]['nom'], $mod_man['Zone'])) {
																echo "<option selected='selected' value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
															}
															else echo "<option value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
														}
									echo "</select> </li>\n";
									echo "<li> Famille : <select name='mod-fam-man'>\n";
														for ($i=0; $i<count($famille); ++$i) {
															if (!strcmp($famille[$i]['nom'], $mod_man['Famille'])) {
																echo "<option selected='selected' value='".$famille[$i]['id']."'>".$famille[$i]['nom']."</option>\n";
															}
															else echo "<option value='".$famille[$i]['id']."'>".$famille[$i]['nom']."</option>\n";
														}
									echo "</select> </li>\n";
									echo "<input type='submit' value='Modifier' name='sub-mod-man'>\n";
									?>
									</ul>
									<p> <span class='choice'> Personnes travaillant dans ce manège : </span> <p>
									
									<p> Gérant(s) : </p>
									<table>
										<tr><th>Nom</th><th>Prenom</th><th>Numero de sécu</th><th>Date de début</th><th>Date de fin</th></tr>
									<?php
									$pers_man=getCM($idcom, $_SESSION['manege']);
									for ($i=0; $i<count($pers_man); ++$i) {
										echo "<tr><td>".$pers_man[$i]['Nom']."</td><td>".$pers_man[$i]['Prenom']."</td><td>".$pers_man[$i]['NumSS']."</td><td>".$pers_man[$i]['Deb']."</td><td>".$pers_man[$i]['Fin']."</td></tr>\n";
									}
									echo "</table>\n";
									?>
									<p> <select name='gere-pers'>
											<?php
												for ($i=0; $i<count($pers); ++$i) {
													if (!strcmp($pers[$i]["Type"], "CM")) {
														echo "<option value='" .$pers[$i]['NumSS']."'> ".$pers[$i]['Nom']. " " .$pers[$i]['Prenom']. " (".$pers[$i]['NumSS'].") </option>\n";
													}
												}
											?>
										</select>
										<input type='date' name='date-deb-gere'>
										<input type='date' name='date-fin-gere'>
										<input type='submit' name='sub-gere-pers' value='Ajouter ce gérant'><input type='submit' name='supp-gere-pers' value='Supprimer ce gérant'>
									</p>
									<p> Remplaçant(s) : </p>
									<table>
										<tr><th>Nom</th><th>Prenom</th><th>Numero de sécu</th><th>Date de début</th><th>Date de fin</th></tr>
									<?php
									$remp_man=getCMRemp($idcom, $_SESSION['manege']);
									for ($i=0; $i<count($remp_man); ++$i) {
										echo "<tr><td>".$remp_man[$i]['Nom']."</td><td>".$remp_man[$i]['Prenom']."</td><td>".$remp_man[$i]['NumSS']."</td><td>".$remp_man[$i]['Deb']."</td><td>".$remp_man[$i]['Fin']."</td></tr>\n";
									}
									echo "</table>\n";
									?>
									<p> <select name='remp-pers'>
											<?php
												for ($i=0; $i<count($pers); ++$i) {
													if (!strcmp($pers[$i]["Type"], "CM")) {
														echo "<option value='" .$pers[$i]['NumSS']."'> ".$pers[$i]['Nom']. " " .$pers[$i]['Prenom']. " (".$pers[$i]['NumSS'].") </option>\n";
													}
												}
											?>
										</select>
										<input type='date' name='date-deb-remp'>
										<input type='date' name='date-fin-remp'>
										<input type='submit' name='sub-remp-pers' value='Ajouter ce remplaçant'><input type='submit' name='supp-remp-pers' value='Supprimer ce remplaçant'>
									</p>
									<?php
									echo "</fieldset> </form>\n";
									if (isset($_POST['sub-mod-man'])) {
										modManege($idcom, $mod_man['Id'], $_POST['mod-id-man'], $_POST['mod-nom-man'], $_POST['mod-desc-man'], $_POST['mod-taille-man'], $_POST['mod-zone-man'], $_POST['mod-fam-man']);
										unset($_SESSION['manege']);
										//header("refresh:0");
									}
									if (isset($_POST['sub-gere-pers'])) {
										addGerant($idcom, $_SESSION['manege'], $_POST['gere-pers'], $mod_man['Famille'], $_POST['date-deb-gere'], $_POST['date-fin-gere']);
									}
									if (isset($_POST['sub-remp-pers'])) {
										addRemplacant($idcom, $_SESSION['manege'], $_POST['remp-pers'], $mod_man['Famille'], $_POST['date-deb-remp'], $_POST['date-fin-remp']);
									}
									if (isset($_POST['supp-gere-pers'])) {
										suppGerant($idcom, $_POST['gere-pers'], $_SESSION['manege'], $_POST['date-deb-gere']);
									}
									if (isset($_POST['supp-remp-pers'])) {
										suppRemplacant($idcom, $_POST['remp-pers'], $_SESSION['manege'], $_POST['date-deb-remp']);
									}
								}
								?>
								<h4> Boutiques :</h4>
								<p> <span class='choice'> Ajouter une boutique : </span> </p>
								<form method='POST' action=''>
									<ul>
										<li> ID : <input type='text' name='id-bout' required><span class="validity"></span></li>
										<li> Type : <input type='text' name='type-bout' required><span class="validity"></span></li>
										<li> Chiffre d'affaires : <input type='number' name='CA-bout' value='0' required><span class="validity"></span></li>
										<li> Zone : <select name='zone-bout'>
													<?php
														for ($i=0; $i<count($zone); ++$i) {
															echo "<option value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
														}
													?>
													</select> </li>
										<input type='submit' value='Ajouter' class='sub-button' name='sub-addbout'>
									</ul>
								</form>
								<?php
								if (isset($_POST['sub-addbout'])) {
									addBoutique($idcom, $_POST['id-bout'], $_POST['type-bout'], $_POST['CA-bout'], $_POST['zone-bout']);
									//header("refresh:0");
								}
								?>
								<form method='post' action=''>
								<p> <span class='choice'> Choisir une boutique :</span> 
									<select name='boutique'>
										<?php 
										for ($i=0; $i<count($bout); ++$i) {
											echo "<option value='" .$bout[$i]['Id']."'>".$bout[$i]['Id']."</option>\n";
										}
										?>
									</select>
									<input type='submit' value='Supprimer' name='supp-bout'> <input type='submit' value='Modifier' name='mod-bout'>
								</p>
								</form>
								<?php
								if (isset($_POST['supp-bout'])) {
									suppBoutique($idcom, $_POST['boutique']);
									//header("refresh:0");
								}
								if (isset($_POST['mod-bout'])) {
									$_SESSION['boutique']=$_POST['boutique'];
								}
								if (isset($_SESSION['boutique'])) {
									//Recherche de la boutique à modifier dans l'array de boutique (les infos de la boutique seront contenu dans mod_bout[])
									$trouve=FALSE;
									for ($i=0; $i<count($bout) && !$trouve; ++$i) {
										if (!strcmp($bout[$i]['Id'], $_SESSION['boutique'])) {
											$mod_bout=$bout[$i];
											$trouve=TRUE;
										} 
									}
									echo "<fieldset> <legend> ".$mod_bout['Id']. "</legend>\n";
									echo "<form method='post' action=''>\n<ul>\n";
									echo "<li> ID : <input type='text' name='mod-id-bout' value='".$mod_bout['Id']."' required><span class='validity'></span></li>\n";
									echo "<li> Type : <input type='text' name='mod-type-bout' value='".$mod_bout['Type']."' required><span class='validity'></span></li>\n";
									echo "<li> CA : <input type='number' name='mod-ca-bout' value='".$mod_bout['CA']."' required><span class='validity'></span></li>\n";
									echo "<li> Zone : <select name='mod-zone-bout'>\n";
														for ($i=0; $i<count($zone); ++$i) {
															if (!strcmp($zone[$i]['nom'], $mod_man['Zone'])) {
																echo "<option selected='selected' value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
															}
															else echo "<option value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
														}
									echo "</select> </li>\n";
									echo "<input type='submit' value='Modifier' name='sub-mod-bout'>\n";
									?>
									</ul>
									<p><span class='choice'>Personnes travaillant dans cette boutique : </span></p>
									<table>
									<tr><th>Nom</th><th>Prenom</th><th>Numéro de sécu.</th><th>Est Responsable</th></tr>
									<?php
										$pers_bout=getVendeurs($idcom, $_SESSION['boutique']);
										for ($i=0; $i<count($pers_bout); ++$i) {
											echo "<tr><td>".$pers_bout[$i]['Nom']."</td><td>".$pers_bout[$i]['Prenom']."</td><td>".$pers_bout[$i]['NumSS']."</td><td>".(($pers_bout[$i]['estResp']) ? "Oui" : "Non")."</td></tr>";
										}
									?>
									</table>
									<p> <select name='gere-vendeur'>
											<?php
												for ($i=0; $i<count($pers); ++$i) {
													if (!strcmp($pers[$i]["Type"], "vendeur")) {
														echo "<option value='" .$pers[$i]['NumSS']."'> ".$pers[$i]['Nom']. " " .$pers[$i]['Prenom']. " (".$pers[$i]['NumSS'].") </option>\n";
													}
												}
											?>
										</select>
										<select name='gere-estResp'>
											<option value='1'>est responsable</option>
											<option value='0'>n'est pas responsable</option>
										</select>
										<input type='submit' name='sub-gere-bout'  value='Ajouter vendeur'>
										<input type='submit' name='supp-vendeur' value='Supprimer vendeur'>
									</p>
									<?php
									echo "</fieldset> </form>\n";
									if (isset($_POST['sub-mod-bout'])) {
										modBoutique($idcom, $mod_bout['Id'], $_POST['mod-id-bout'], $_POST['mod-type-bout'], $_POST['mod-ca-bout'], $_POST['mod-zone-bout']);
										unset($_SESSION['boutique']);
										//header("refresh:0");
									}
									if (isset($_POST['sub-gere-bout'])) {
										addVendeur($idcom, $_POST['gere-vendeur'], $_SESSION['boutique'], $_POST['gere-estResp']);
									}
									if (isset($_POST['supp-vendeur'])) {
										suppVendeur($idcom, $_POST['gere-vendeur'], $_SESSION['boutique']);
									}
								}
								
								?>
								<h4> Personnels :</h4>
								<p> <span class='choice'> Ajouter une personne : </span> </p>
								<form method='post' action=''>
									<ul>
										<li> Numéro de sécurité sociale : <input type='text' name='numSS-P' required><span class='validity'></span></li>
										<li> Type : <select name='type-p'>
											<option value='CM'> Chargé de manège </option>
											<option value='vendeur'> Vendeur </option>
											<option value='serveur'> Serveur </option>
											<option value='technicien'> Technicien </option>
											<option value='directeur'> Directeur </option>
											</select>
										</li>
										<li> Nom : <input type='text' name='nom-P' required><span class='validity'></span></li>
										<li> Prénom : <input type='text' name='prenom-P' required><span class='validity'></span></li>
										<li> Date de naissance : <input type='date' name='date-P' required><span class='validity'></span></li>
										<li> Mot de passe : <input type='text' name='mdp-P' required><span class='validity'></span></li>
										<input type='submit' class='sub-button' name='sub-P' value='Ajouter'>
									</ul>
								</form>
								<?php
									if (isset($_POST['sub-P'])) {
										addPersonnel($idcom, $_POST['numSS-P'], $_POST['type-p'], $_POST['nom-P'], $_POST['prenom-P'], $_POST['date-P'], $_POST['mdp-P']);
									}
								?>
								<form method='POST' action=''>
									<p> <span class='choice'> Choisir une personne : </span>
										<select name='personne'>
											<?php
												for ($i=0; $i<count($pers); ++$i) {
													echo "<option value='" .$pers[$i]['NumSS']."'> ".$pers[$i]['Nom']. " " .$pers[$i]['Prenom']. " (".$pers[$i]['NumSS'].") </option>\n";
												}
											?>
										</select>
										<input type='submit' name='supp-P' value='Supprimer'> <input type='submit' name='mod-P' value='Modifier'>
									</p>
								</form>
								<?php
								if (isset($_POST['supp-P'])) {
									suppPersonnel($idcom, $_POST['personne']);
								}
								if (isset($_POST['mod-P'])) {
									$_SESSION['personne']=$_POST['personne'];
								}
								if (isset($_SESSION['personne'])) {
									$trouve=FALSE;
									for ($i=0; $i<count($pers) && !$trouve; ++$i) {
										if (!strcmp($pers[$i]['NumSS'], $_SESSION['personne'])) {
											$mod_pers=$pers[$i];
											$trouve=TRUE;
										} 
									}
									echo "<fieldset> <legend> ".$mod_pers['Nom']. " " .$mod_pers['Prenom']. "</legend>\n";
									echo "<form method='post' action=''>\n<ul>\n";
									echo "<li> NumSS : <input type='text' name='mod-numSS-pers' value='".$mod_pers['NumSS']."' required><span class='validity'></span></li>\n";
									echo "<li> Type : <select name='mod-type-pers'>\n";
										for ($i=0; $i<count($type_p); ++$i) {
											if (!strcmp($type_p[$i], $mod_pers['Type'])) {
												echo "<option selected='selected' value='".$type_p[$i]."'>".$type_p[$i]."</option>\n";
											}
											else echo "<option value='".$type_p[$i]."'>".$type_p[$i]."</option>\n";
										}
									echo "</select> </li>\n";
									echo "<li> Nom : <input type='text' name='mod-nom-pers' value='".$mod_pers['Nom']."' required><span class='validity'></span></li>\n";
									echo "<li> Prenom : <input type='text' name='mod-prenom-pers' value='".$mod_pers['Prenom']."' required><span class='validity'></span></li>\n";
									echo "<li> Date : <input type='date' name='mod-date-pers' value='".$mod_pers['Naissance']."' required><span class='validity'></span></li>\n";
									echo "<li> Mot de passe : <input type='text' name='mod-mdp-pers' value='".$mod_pers['Mdp']."' required><span class='validity'></span></li>\n";
									
									echo "<input type='submit' value='Modifier' name='sub-mod-pers'>\n";
									echo "</ul> </fieldset> </form>\n";
									if (isset($_POST['sub-mod-pers'])) {
										modPersonnel($idcom, $mod_pers['NumSS'], $_POST['mod-numSS-pers'], $_POST['mod-type-pers'], $_POST['mod-nom-pers'], $_POST['mod-prenom-pers'], $_POST['mod-date-pers'], $_POST['mod-mdp-pers']);
										unset($_SESSION['personne']);
										//header("refresh:0");
									}
								}
								?>
						</div>
					<?php
					} 
					// Chargé de manège
					if (!strcmp($row[1], "CM")) {
						?>
						<div class='container'>
						<h3> Fenêtre chargé de manège </h3>
						<?php
						$res=@mysqli_query($idcom, "SELECT id_M FROM Gere_Manege WHERE Numero_SS_P='".$row[0]."' AND date_deb_gere <= '".date("Y-m-d")."' AND date_fin_gere >= '".date("Y-m-d")."'");
						$man=mysqli_fetch_array($res);
						$trouve=FALSE;
						if(!empty($man)){
							for ($i=0; $i<count($manege) && !$trouve; ++$i) {
								if (!strcmp($manege[$i]['Id'], $man[0])) {
									$mod_man=$manege[$i];
									$trouve=TRUE;
								} 
							}
						}		
						if (isset($mod_man)) {
							echo "<p><span class='choice'>Modifier votre manège : </span></p>";
							echo "<fieldset> <legend> ".$mod_man['Nom']. "</legend>\n";
							echo "<form method='post' action=''>\n<ul>\n";
							echo "<li> ID : <input type='text' name='mod-id-man' value='".$mod_man['Id']."' required><span class='validity'></span></li>\n";
							echo "<li> Nom : <input type='text' name='mod-nom-man' value='".$mod_man['Nom']."' required><span class='validity'></span></li>\n";
							echo "<li> Description : <input type='text' name='mod-desc-man' value='".$mod_man['Description']."' required><span class='validity'></span></li>\n";
							echo "<li> Taille : <input type='number' step='0.01' name='mod-taille-man' value='".$mod_man['Taille']."' required><span class='validity'></span></li>\n";
							echo "<li> Zone : <select name='mod-zone-man'>\n";
												for ($i=0; $i<count($zone); ++$i) {
													if (!strcmp($zone[$i]['nom'], $mod_man['Zone'])) {
														echo "<option selected='selected' value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
													}
													else echo "<option value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
												}
							echo "</select> </li>\n";
							echo "<li> Famille : <select name='mod-fam-man'>\n";
												for ($i=0; $i<count($famille); ++$i) {
													if (!strcmp($famille[$i]['nom'], $mod_man['Famille'])) {
														echo "<option selected='selected' value='".$famille[$i]['id']."'>".$famille[$i]['nom']."</option>\n";
													}
													else echo "<option value='".$famille[$i]['id']."'>".$famille[$i]['nom']."</option>\n";
												}
							echo "</select> </li>\n";
							echo "<input type='submit' value='Modifier' name='sub-mod-man'></ul></fieldset>\n";
							?>
							<p><span class='choice'>Ajouter le manège à la maintenance : </span></p>
							<p> Choix du technicien : <select name='technicien-maint'>
								<?php
								$temp=getTechnicien($idcom, $mod_man['Zone']);
								for ($i=0; $i<count($temp); $i++) {
									echo "<option value='".$temp[$i]['NumSS']."'>".$temp[$i]['Nom']." ".$temp[$i]['Prenom']." (".$temp[$i]['NumSS'].") </option>\n";
								}
								?>
								</select>
							</p>
							<p> ID de la pièce : <select name='piece-maint'>
								<?php
								//Selectionne les pieces qui n'ont pas été utilisés
								$piece_maint=@mysqli_query($idcom, "SELECT id_piece FROM Pieces WHERE id_piece NOT IN (SELECT id_piece FROM Maintenance)");
								while($piece=mysqli_fetch_array($piece_maint)) {
									echo "<option value='".$piece[0]."'>".$piece[0]."</option>\n";
								}
								?>
								</select>
							</p>
							<p>Date de début : <input type='date' name='date-maint' value='<?php echo date("Y-m-d");?>' required><span class='validity'></span></p>
							<p><input type='submit' name='sub-maint' value='Ajouter'></p>
							</form>
							<?php
							if (isset($_POST['sub-mod-man'])) {
								modManege($idcom, $man[0], $_POST['mod-id-man'], $_POST['mod-nom-man'], $_POST['mod-desc-man'], $_POST['mod-taille-man'], $_POST['mod-zone-man'], $_POST['mod-fam-man']);
							}
							if (isset($_POST['sub-maint'])) {
								addMaintenance($idcom, $man[0], $_POST['technicien-maint'], $_POST['piece-maint'], $_POST['date-maint']);
							}
						}
						else echo "<p>Vous ne gérez aucun manège.</p>\n"
						?>
						</div>
					<?php
					}
					else if (!strcmp($row[1], "vendeur")) {
						?>
						<div class='container'>
						<h3> Fenêtre vendeurs :</h3>
						<p> <span class='choice'> Ajouter une boutique : </span> </p>
							<form method='POST' action=''>
						<ul>
						<li> ID : <input type='text' name='id-bout' required><span class="validity"></span></li>
						<li> Type : <input type='text' name='type-bout' required><span class="validity"></span></li>
						<li> Chiffre d'affaires : <input type='number' name='CA-bout' value='0' required><span class="validity"></span></li>
						<li> Zone : <select name='zone-bout'>
									<?php
										for ($i=0; $i<count($zone); ++$i) {
											echo "<option value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
										}
									?>
									</select> </li>
						<input type='submit' value='Ajouter' class='sub-button' name='sub-addbout'>
						</ul>
						</form>
						<?php
						if (isset($_POST['sub-addbout'])) {
							addBoutique($idcom, $_POST['id-bout'], $_POST['type-bout'], $_POST['CA-bout'], $_POST['zone-bout']);
							//header("refresh:0");
						}
						?>
						<form method='post' action=''>
						<p> <span class='choice'> Choisir une boutique :</span> 
							<select name='boutique'>
								<?php 
								for ($i=0; $i<count($bout); ++$i) {
									echo "<option value='" .$bout[$i]['Id']."'>".$bout[$i]['Id']."</option>\n";
								}
								?>
							</select>
							<input type='submit' value='Supprimer' name='supp-bout'> <input type='submit' value='Modifier' name='mod-bout'>
						</p>
						</form>
						<?php
						if (isset($_POST['supp-bout'])) {
							suppBoutique($idcom, $_POST['boutique']);
							//header("refresh:0");
						}
						if (isset($_POST['mod-bout'])) {
							$_SESSION['boutique']=$_POST['boutique'];
						}
						if (isset($_SESSION['boutique'])) {
							//Recherche de la boutique à modifier dans l'array de boutique (les infos de la boutique seront contenu dans mod_bout[])
							$trouve=FALSE;
							for ($i=0; $i<count($bout) && !$trouve; ++$i) {
								if (!strcmp($bout[$i]['Id'], $_SESSION['boutique'])) {
									$mod_bout=$bout[$i];
									$trouve=TRUE;
								} 
							}
							echo "<fieldset> <legend> ".$mod_bout['Id']. "</legend>\n";
							echo "<form method='post' action=''>\n<ul>\n";
							echo "<li> ID : <input type='text' name='mod-id-bout' value='".$mod_bout['Id']."' required><span class='validity'></span></li>\n";
							echo "<li> Type : <input type='text' name='mod-type-bout' value='".$mod_bout['Type']."' required><span class='validity'></span></li>\n";
							echo "<li> CA : <input type='number' name='mod-ca-bout' value='".$mod_bout['CA']."' required><span class='validity'></span></li>\n";
							echo "<li> Zone : <select name='mod-zone-bout'>\n";
													for ($i=0; $i<count($zone); ++$i) {
														if (!strcmp($zone[$i]['nom'], $mod_man['Zone'])) {
															echo "<option selected='selected' value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
														}
														else echo "<option value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
													}
								echo "</select> </li>\n";
								echo "<input type='submit' value='Modifier' name='sub-mod-bout'>\n";
								echo "</ul> </fieldset> </form>\n";
								if (isset($_POST['sub-mod-bout'])) {
									modBoutique($idcom, $mod_bout['Id'], $_POST['mod-id-bout'], $_POST['mod-type-bout'], $_POST['mod-ca-bout'], $_POST['mod-zone-bout']);
									unset($_SESSION['boutique']);
									//header("refresh:0");
								}
							}
						echo "</div>";
						}
						//Technicien 
						else if (!strcmp($row[1], "technicien")) {
							?>
							<div class='container'>
							<h3> Fenêtre du technicien </h3>
							<?php
							$res=@mysqli_query($idcom, "SELECT * FROM Travaille WHERE Numero_SS_P='".$row[0]."'");
							$tech=mysqli_fetch_array($res);
							if ((mysqli_num_rows($res)==1) && $tech[2]) {
								$atelier=getAtelier($idcom, $tech[1]);
								if (!empty($atelier)) {
									?>
									<form method='POST' action=''> 
									<p><span class='choice'>Modifier votre atelier :</span></p>
									<ul>
										<li>ID : <input type='text' name='mod-id-atelier' value='<?php echo $atelier['Id'];?>' required><span class='validity'></span></li>
										<li>Zone : <select name='mod-zone-atelier'>
											<?php
												for ($i=0; $i<count($zone); ++$i) {
													if (!strcmp($zone[$i]['id'], $atelier['Zone'])) echo "<option selected='selected' value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
													else echo "<option value='".$zone[$i]['id']."'>".$zone[$i]['nom']."</option>\n";
												}
											?>
											</select>
										</li>
										<input type='submit' name='sub-mod-atelier' value='Modifier'>
									</ul>
									</form>
									<?php
									if (isset($_POST['sub-mod-atelier'])) {
										modAtelier($idcom, $atelier['Id'], $_POST['mod-id-atelier'], $_POST['mod-zone-atelier']);
									}
								}
								else echo "<p>Aucune infos sur votre atelier.</p>\n";
							}
							else echo "<p>Vous n'êtes responsable d'aucun atelier.</p>\n";
							//Recupere les maintenances non finies
							echo "<p><span class='choice'>Maintenance que vous devez finir : </span></p>";
							$maint=@mysqli_query($idcom, "SELECT id_M, Numero_SS_P, id_piece, date_maintenance FROM Maintenance WHERE Numero_SS_P='".$row[0]."' AND date_fin_maintenance IS NULL");
							if (mysqli_num_rows($maint)>0) {
								echo "<form method='POST' action=''>\n";
								while($temp=mysqli_fetch_array($maint)) {
									echo "<p><input type='radio' name='choix-maint' value='".$temp[0]."' required><table><tr><td>".$temp[0]."</td><td>".$temp[1]."</td><td>".$temp[2]."</td><td>".$temp[3]."</td></tr></table></p>\n";
								}
								echo "<input type='date' name='date-maint' required><input type='submit' name='sub-maint' value='Finir' required>"; 
								echo "</form>";
								if (isset($_POST['sub-maint'])) {
									addMaintenance2($idcom, $_POST['choix-maint'], $row[0], $_POST['date-maint']);
								}
							}
							else echo "<p>Aucune maintenance en cours.</p>\n";
							?>
							</div>
							<?php
						}
					
				}
				else {
					echo "<p> Vous ne faites pas partie du personnel. </p>\n";
				}
				mysqli_close($idcom);
			}
		}
	?>
	<a href='connexion.php'>Déconnexion</a>
	
</body>
</html>
