<?php

include_once "maLibSQL.pdo.php";

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/







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


function changerPseudo($idUser, $username)
{
	$sql = "UPDATE User
          SET username = '$username'
          WHERE id_user  = '$idUser'";
  SQLUpdate($sql);
}

function changerEmail($idUser, $email)
{
	$sql = "UPDATE User
          SET email = '$email'
          WHERE id_user  = '$idUser'";
  SQLUpdate($sql);
}

function changerPasse($idUser, $passe)
{
	$sql = "UPDATE User
          SET passe = '$passe'
          WHERE id_user  = '$idUser'";
  SQLUpdate($sql);
}

function deletecompte($idUser)
{
	$sql="DELETE FROM User
	WHERE id_user = '$idUser'";
	SQLDelete($sql);
}





//renvoie si le compte est entreprise ou  non
function entreprise($idUser)
{
	$sql="SELECT entreprise
			FROM User
			WHERE id_user='$idUser'";

	return SQLGetChamp($sql);

}
//renvoie si le mail
function email($idUser)
{
	$sql="SELECT email
			FROM User
			WHERE id_user='$idUser'";

	return SQLGetChamp($sql);

}



//mettre un compte en entreprise, met les info de l'entreprise et met a jour le statu de l'utilisateur en entreprise
function setentreprise($nom ,$siege ,$tel ,$siret ,$idUser)
{
	//met a jour le status utilisateur
	$sql="UPDATE User
			SET Entreprise = 1
			where id_user = '$idUser'";
	SQLUpdate($sql);

	//ajoute les information de l'entreprise
	$sql = "INSERT INTO Entreprise(nom_entreprise, siege_social, tel_entreprise, siret, id_user)
	        VALUES ('$nom', '$siege', '$tel', '$siret', '$idUser');";
  
  	SQLInsert($sql);
	


}




function AjouterProduit($nom,$description,$URL_photo,$prix,$niveau,$type,$pointure,$marque,$lame,$poid,$identreprise)
{
	$sql = "INSERT INTO Produit(nom, description, url_photo, prix, niveau, type, pointure, marque, lames,poids,id_entreprise)
	        VALUES ('$nom', '$description', '$URL_photo', '$prix', '$niveau', '$type','$pointure', '$marque', '$lame','$poid','$identreprise');";
  
  	SQLInsert($sql);


}

//on donne l'id du compte, la fonction nous ressort l'id entreprise associé
function identreprise($id)
{
	$sql="SELECT id_entreprise
			FROM Entreprise
			WHERE id_user = $id ;";

	return SQLGetChamp($sql);

}




// Cette fonction liste l'ensemble des informations d'un produit qui seront affichées dans le template magasin
function ListerProduit()
{
	$sql = "SELECT id_produit, nom, description, url_photo, prix FROM Produit;";
	return parcoursRs(SQLSelect($sql));
}

///fonctions relatives au panier d'un utilisateur
function DejaDansPanier($idUser,$id_produit)
{
	$sql="SELECT id_produit
			FROM Panier
			WHERE id_user='$idUser' AND id_produit='$id_produit'";

	return SQLGetChamp($sql);
}

function IncrementeQuantite($idUser,$id_produit)
{
	$sql = "UPDATE Panier
          SET quantite = quantite+1
          WHERE id_user  = '$idUser' AND id_produit='$id_produit'";
    SQLUpdate($sql);
}

function AjouteAuPanier($idUser,$id_produit)
{
	$sql = "INSERT INTO Panier
	        VALUES ('$idUser', '$id_produit', 1);";
  	SQLInsert($sql);
}


?>
