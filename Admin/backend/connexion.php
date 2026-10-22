<?php
//définir vos paramètres serveur de connexion avec la base de donnéesz
$host="mysql-liantsoa.alwaysdata.net";
// nom utilisateur
$login="liantsoa";
// mot de passe
$pass="Ramanitrinihaja.16";
// nom de la base de données
$dbname="liantsoa_bd";


// établir la connexion avec la base de données
$bdd = mysqli_connect($host, $login, $pass, $dbname);
// vérification de la connexion avec la BD
if (!$bdd){
			echo "Connexion non-reussie à MySQL: " . mysqli_connect_error();
	} 
	else{
			echo "";
	}


 
// changer le jeu de caractères à utf8
mysqli_set_charset($bdd, "utf8mb4");
?>
