<html>
<head> <meta charset='utf-8' ></head>
<body>
    <p>
    <?php
        session_start();
        include('connex.inc.php');
		include('fonctions.php');
        if (isset($_POST['changeprenom']) || isset($_POST['changenom'])) {
            $idcom=connex('myparam');
            if ($idcom) {
                if(isset($_POST['changeprenom'])) {
                   if (remplacePrenom($_SESSION['numSS'], $_POST['prenom'], $idcom)) echo "Le prénom a été changé.";
                   else echo "Erreur : réessayez.";
                }
                else {
                   if (remplaceNom($_SESSION['numSS'], $_POST['nom'], $idcom)) echo "Le nom à été changé.";
                   else echo "Erreur : réessayez.";
                }
                mysqli_close($idcom);
            }
        }
        else echo "Vous n'avez pas entré de prénom ou nom.";
    ?>
    </p>
    <a href='login.php'>Retour à la page précédente</a>
</body>
</html>