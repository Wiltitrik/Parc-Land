<?php
    session_start();
    include('connex.inc.php');
?>
<html>
    <head> <meta charset='utf-8'>
	<link rel='stylesheet' href='login.css'>
    </head>
    <body>
        <?php
        $info=$_GET['info'];
        $idcom=connex('myparam');

        if (preg_match('/^M.*$/', $info)) {
            $r1="SELECT * FROM Manege WHERE id_m='$info'";
            $r2="SELECT date_cli_M, nb_cli_M_matin, nb_cli_M_soir FROM Clients_Manege WHERE id_M='$info'";
            $r3="SELECT Nom_P, Prenom_P, P.Numero_SS_P, date_deb_gere, date_fin_gere FROM Personnel P, Gere_Manege G WHERE P.Numero_SS_P=G.Numero_SS_P AND id_M='$info'";
            $r4="SELECT Nom_P, Prenom_P, P.Numero_SS_P, date_deb_remp, date_fin_remp FROM Personnel P, Remplacant_Manege R WHERE  P.Numero_SS_P=R.Numero_SS_P AND id_M='$info'";
            $r5="SELECT Nom_P, Prenom_P, M.id_piece, nom_piece, date_maintenance, date_fin_maintenance FROM Personnel P, Pieces Pi, Maintenance M WHERE P.Numero_SS_P=M.Numero_SS_P AND Pi.id_piece=M.id_piece AND id_M='$info'";
            $info_man=@mysqli_query($idcom, $r1);
            $nb_cli=@mysqli_query($idcom, $r2);
            $gere=@mysqli_query($idcom, $r3);
            $remplace=@mysqli_query($idcom, $r4);
            $maintenance=@mysqli_query($idcom, $r5);

            $row=mysqli_fetch_array($info_man);
            ?>
            <div class='container'>
                <h3> Informations générales :</h3>
                <p>ID : <?php echo $row[0];?></p>
                <p>Nom : <?php echo $row[1];?></p>
                <p>Description : <?php echo $row[2];?></p>
                <p>Taille : <?php echo $row[3];?></p>
                <p>Zone : <?php echo $row[4];?></p>
                <p>Famille : <?php echo $row[5];?></p>
                <h3> Nombre de clients : </h3>
                <table>
                    <tr><th>Date</th><th>Nombre de clients (matin)</th><th>Nombre de clients (soir)</th></tr>
                    <?php
                        while ($row2=mysqli_fetch_array($nb_cli)) {
                            echo "<tr><td>".$row2[0]."</td><td>".$row2[1]."</td><td>".$row2[2]."</td></tr>";
                        }
                    ?>
                </table>
                <h3>Gérant : </h3>
                <table>
                    <tr><th>Nom</th><th>Prénom</th><th>Numéro de sécu.</th><th>Date de début</th><th>Date de fin</th></tr>
                    <?php
                        while ($row2=mysqli_fetch_array($gere)) {
                            echo "<tr><td>".$row2[0]."</td><td>".$row2[1]."</td><td>".$row2[2]."</td><td>".$row2[3]."</td><td>".$row2[4]."</td></tr>";
                        }
                    ?>
                </table>
                <h3>Remplaçant : </h3>
                <table>
                    <tr><th>Nom</th><th>Prénom</th><th>Numéro de sécu.</th><th>Date de début</th><th>Date de fin</th></tr>
                    <?php
                        while ($row2=mysqli_fetch_array($remplace)) {
                            echo "<tr><td>".$row2[0]."</td><td>".$row2[1]."</td><td>".$row2[2]."</td><td>".$row2[3]."</td><td>".$row2[4]."</td></tr>";
                        }
                    ?>
                </table>
                <h3>Maintenance : </h3>
                <table>
                    <tr><th>Nom</th><th>Prénom</th><th>ID Pièce</th><th>Nom Pièce</th><th>Date</th><th>Date fin maintenance</th></tr>
                    <?php
                        while ($row2=mysqli_fetch_array($maintenance)) {
                            echo "<tr><td>".$row2[0]."</td><td>".$row2[1]."</td><td>".$row2[2]."</td><td>".$row2[3]."</td><td>".$row2[4]."</td><td>".$row2[5]."</td></tr>";
                        }
                    ?>
                </table>
            </div>
        <?php
        }
        else {
            $r1="SELECT * FROM Boutique WHERE id_bout='$info'";
            $r2="SELECT date_cli_bout, nb_cli_bout FROM Clients_Boutique WHERE id_bout='$info'";
            $r3="SELECT Nom_P, Prenom_P, P.Numero_SS_P, estResponsable FROM Gere g, Personnel p WHERE p.Numero_SS_P=g.Numero_SS_P AND id_bout='$info'";
            $r4="SELECT o.id_objet, type_objet FROM Objets o, Possede p WHERE o.id_objet=p.id_objet AND id_bout='$info'";
            $r5="SELECT o.id_objet, type_objet, prix_objet, date_vente, qte_vente FROM Objets o, Vends v WHERE o.id_objet=v.id_objet AND id_bout='$info'";

            $info_bout=@mysqli_query($idcom, $r1);
            $nb_cli=@mysqli_query($idcom, $r2);
            $vendeurs=@mysqli_query($idcom, $r3);
            $possede=@mysqli_query($idcom, $r4);
            $ventes=@mysqli_query($idcom, $r5);

            $row=mysqli_fetch_array($info_bout);

            ?>
            <div class='container'>
                <h3> Informations générales :</h3>
                <p>ID : <?php echo $row[0];?></p>
                <p>Type : <?php echo $row[1];?></p>
                <p>Chiffre d'affaires : <?php echo $row[2];?></p>
                <p>Zone : <?php echo $row[3];?></p>

                <h3> Nombre de clients : </h3>
                <table>
                    <tr><th>Date</th><th>Nombre de clients (matin)</th></tr>
                    <?php
                        while ($row2=mysqli_fetch_array($nb_cli)) {
                            echo "<tr><td>".$row2[0]."</td><td>".$row2[1]."</td></tr>";
                        }
                    ?>
                </table>

                <h3> Vendeurs : </h3>
                <table>
                    <tr><th>Nom</th><th>Prenom</th><th>Numéro de sécu.</th><th>Est responsable</th></tr>
                    <?php
                        while ($row2=mysqli_fetch_array($vendeurs)) {
                            echo "<tr><td>".$row2[0]."</td><td>".$row2[1]."</td><td>".$row2[2]."</td><td>".(($row2[3]) ? "Oui" : "Non")."</td></tr>";
                        }
                    ?>
                </table>

                <h3> Possede : </h3>
                <table>
                    <tr><th>ID de l'objet</th><th>Nom de l'objet</th></tr>
                    <?php
                        while ($row2=mysqli_fetch_array($possede)) {
                            echo "<tr><td>".$row2[0]."</td><td>".$row2[1]."</td></tr>";
                        }
                    ?>
                </table>

                <h3> Ventes : </h3>
                <table>
                    <tr><th>ID de l'objet</th><th>Nom de l'objet</th><th>Prix de l'objet</th><th>Date vente</th><th>Quantité vendue</th></tr>
                    <?php
                        while ($row2=mysqli_fetch_array($ventes)) {
                            echo "<tr><td>".$row2[0]."</td><td>".$row2[1]."</td><td>".$row2[2]."</td><td>".$row2[3]."</td><td>".$row2[4]."</td></tr>";
                        }
                    ?>
                </table>
            </div>
            <?php
        }
        mysqli_close($idcom);
        ?>
        <p> <a href='login.php'> Retour à la page précédente </a> </p>
    </body>
</html>
