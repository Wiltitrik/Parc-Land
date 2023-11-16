<?php
	session_start();
	session_unset();
	session_destroy();
?>
<html>
<head> <link rel='stylesheet' href='login.css'> </head>
<body>
	<h1> Connexion Parcland </h1>
	<div class='container' id='connex'>
	<form method="POST" action="login.php">
		<p> Login : <input type="text" name="login" required><span class='validty'></<span> </p>
		<p> Mot de passe : <input type="password" name="mdp" required><span class='validty'></<span> </p>
		<p> <input type="submit" name="envoie" value="Confirmer"> <p>
	</form>
</div>
</body>
</html>
