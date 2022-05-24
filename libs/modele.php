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
//renvoie le mail d'un user
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


// Cette fonction liste tous les produits du magasin
function ListerProduit($recherche = "")
{

	$sql = "SELECT id_produit, nom, description, url_photo, prix 
			FROM Produit
			WHERE nom LIKE '%$recherche%'; ";

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

//Incrémente la quantité d'un produit dans le panier
function IncrementeQuantite($idUser,$id_produit)
{
	$sql = "UPDATE Panier
          SET quantite = quantite+1
          WHERE id_user  = '$idUser' AND id_produit='$id_produit'";
    SQLUpdate($sql);
}

function DecrementeQuantite($idUser,$id_produit)
{
	$sql = "UPDATE Panier
          SET quantite = quantite-1
          WHERE id_user  = '$idUser' AND id_produit='$id_produit'";
    SQLUpdate($sql);
}

//Ajoute un produit dans le panier de l'utilisateur
function AjouteAuPanier($idUser,$id_produit)
{
	$sql = "INSERT INTO Panier
	        VALUES ('$idUser', '$id_produit', 1);";
  	SQLInsert($sql);
}

function RetireDuPanier($id_produit, $id_user)
{
	$sql="DELETE FROM Panier WHERE id_user = '$id_user' AND id_produit='$id_produit'";
	SQLDelete($sql);
}

//Liste les produits du panier de l'utilisateur
function ListerPanier($idUser)
{
	$sql = "SELECT Produit.id_produit, Produit.nom, Produit.url_photo, Produit.prix, Panier.quantite 
	FROM Produit JOIN Panier ON Panier.id_produit=Produit.id_produit WHERE Panier.id_user='$idUser';";
	return parcoursRs(SQLSelect($sql));
}


//on donne l'id du produit et la fonction nous renvoie les informations sous forme de tableau
function getProduit($id)
{
	$sql="SELECT *
			FROM Produit
			WHERE id_produit = $id;";

	
	return parcoursRs(SQLSelect($sql));

}


//retourne la mote moyenne d'un produit
function notemoy($id_produit)
{
	$sql="SELECT AVG(note)
			FROM Avis
			WHERE id_produit = $id_produit;";

	return SQLGetChamp($sql);
}

function addnote($id_user,$id_produit,$note)
{

	$sql="DELETE FROM Avis WHERE id_user = '$id_user' AND id_produit='$id_produit'";
	SQLDelete($sql);

	$sql = "INSERT INTO Avis(id_user, id_produit,avis, note)
	        VALUES ('$id_user', '$id_produit', NULL ,'$note');";
	SQLInsert($sql);

}

function addCommentaire($id_user,$id_produit,$commentaire)
{

	$sql = "INSERT INTO Avis(id_user, id_produit,avis, note)
	        VALUES ('$id_user', '$id_produit', '$commentaire' ,NULL);";
	SQLInsert($sql);
}


function listercommentaire($id_produit)
{
	$sql="SELECT User.username, avis
			FROM Avis join User
				ON Avis.id_user=User.id_user
			Where id_produit = '$id_produit';";

	return parcoursRs(SQLSelect($sql));
	
}



function ValiderCommande($nom,$prenom,$adresse,$ville,$code_postal,$tel,$cb,$exp,$cvv,$idUser)
{
	$date=date('Y-m-d');
	$sql = "INSERT INTO Commande(date,etat_livraison,nom,prenom,adresse,ville,code_postal,telephone,CB,date_expiration,CVV,id_user)
	        VALUES ('$date', 0,'$nom','$prenom','$adresse','$ville','$code_postal','$tel','$cb','$exp','$cvv','$idUser');";
	SQLInsert($sql);

	return SQLGetChamp("SELECT MAX(id_commande) FROM Commande WHERE id_user='$idUser'");
}

function AjouteDetailCommande($id_commande, $id_produit, $quantite, $id_user)
{
	$sql = "INSERT INTO Detail_commande VALUES ('$id_commande', '$id_produit', $quantite);";
  	SQLInsert($sql);
	$sql = "DELETE FROM Panier WHERE id_user = '$id_user' AND id_produit = '$id_produit'";
	SQLDelete($sql);
}

function ListeCommande($id_user)
{
	$sql = "SELECT id_commande, date, etat_livraison FROM Commande WHERE id_user='$id_user';";
	return parcoursRs(SQLSelect($sql));
}

function getCommande($id_commande)
{
	$sql = "SELECT Commande.date, Commande.etat_livraison, Detail_commande.quantite, Produit.url_photo, Produit.prix, Produit.nom
			FROM Detail_commande JOIN Produit ON Detail_commande.id_produit=Produit.id_produit 
			JOIN Commande ON Commande.id_commande=Detail_commande.id_commande
			WHERE Detail_commande.id_commande='$id_commande';";
	return parcoursRs(SQLSelect($sql));
}


?>
