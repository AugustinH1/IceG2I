<?php

include_once "maLibSQL.pdo.php";

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/



function listerUtilisateurs($classe = "both")
{
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,connecte,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés
  $sql = "SELECT *
          FROM users";
  if ($classe == "bl") {
    $sql = $sql . " WHERE blacklist";
  }
  if ($classe == "nbl") {
    $sql = $sql . " WHERE NOT blacklist";
  }
  return parcoursRs(SQLSelect($sql));
}





function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT id_user FROM User WHERE username='$login' AND passe='$passe'";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}






// Cette fonction crée un nouvel utilisateur et renvoie l'identifiant de l'utilisateur créé
function mkUser($email, $username, $passe, $connecte=0, $entreprise=0)
{

  $sql = "INSERT INTO User(email, username, passe, connecte, entreprise)
	        VALUES ('$email', '$username', '$passe', '$connecte', '$entreprise');";
  
  SQLInsert($sql);
  return SQLGetChamp("SELECT MAX(id_user)
                      FROM User
                      WHERE username = '$username' AND passe = '$passe';");

}


function connecterUtilisateur($idUser)
{
	// cette fonction affecte le booléen "connecte" à vrai pour l'utilisateur concerné 
  $sql = "UPDATE User
          SET connecte = 1
          WHERE id_user = '$idUser'";
  SQLUpdate($sql);
}

function deconnecterUtilisateur($idUser)
{
	// cette fonction affecte le booléen "connecte" à faux pour l'utilisateur concerné 
  $sql = "UPDATE User
          SET connecte = 0
          WHERE id_user  = '$idUser'";
  SQLUpdate($sql);
}





//renvoie si le compte est entreprise ou  non
function entreprise($idUser)
{
	$sql="SELECT entreprise
			FROM User
			WHERE id_user='$idUser'";

	return SQLGetChamp($sql);

}








function changerPasse($idUser,$passe)
{
	// cette fonction modifie le mot de passe d'un utilisateur
	$sql = "UPDATE users
	        SET passe = '$passe'
	        WHERE id = '$idUser';";
  SQLUpdate($sql);
}

function changerPseudo($idUser,$pseudo)
{
	// cette fonction modifie le pseudo d'un utilisateur
	$sql = "UPDATE users
	        SET pseudo = '$pseudo'
	        WHERE id = '$idUser';";
  SQLUpdate($sql);
}







?>
