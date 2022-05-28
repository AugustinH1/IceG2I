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


function mkUser($email, $username, $passe, $connecte=0, $entreprise=0)
{
  // Augustin
  // Cette fonction crée un nouvel utilisateur et renvoie l'identifiant de l'utilisateur créé

  $sql = "INSERT INTO User(email, username, passe, connecte, entreprise)
	        VALUES ('$email', '$username', '$passe', '$connecte', '$entreprise');";
  
  SQLInsert($sql);

  return SQLGetChamp("SELECT MAX(id_user)
                      FROM User
                      WHERE username = '$username' AND passe = '$passe';");
}


function connecterUtilisateur($idUser)
{
  // Augustin
  //Cette fonction affecte le booléen "connecte" à 1 pour l'utilisateur passé en paramètres.

  $sql = "UPDATE User
          SET connecte = 1
          WHERE id_user = '$idUser'";
  SQLUpdate($sql);
}


function deconnecterUtilisateur($idUser)
{
  // Augustin
  //Cette fonction affecte le booléen "connecte" à 0 pour l'utilisateur passé en paramètres.

  $sql = "UPDATE User
          SET connecte = 0
          WHERE id_user  = '$idUser'";
  SQLUpdate($sql);
}


function changerPseudo($idUser, $username)
{
	// Augustin
	//Cette fonction permet de changer le pseudo d’un utilisateur.

	$sql = "UPDATE User
          SET username = '$username'
          WHERE id_user  = '$idUser'";
  SQLUpdate($sql);
}


function changerEmail($idUser, $email)
{
	// Augustin
	//Cette fonction permet de changer le mail d’un utilisateur.

	$sql = "UPDATE User
          SET email = '$email'
          WHERE id_user  = '$idUser'";
  SQLUpdate($sql);
}


function changerPasse($idUser, $passe)
{
	// Augustin
	//Cette fonction permet de changer le mot de passe d’un utilisateur.

	$sql = "UPDATE User
          SET passe = '$passe'
          WHERE id_user  = '$idUser'";
  SQLUpdate($sql);
}


function entreprise($idUser)
{
	// Augustin
	//Cette fonction renvoie si le compte est entreprise ou non.

	$sql="SELECT entreprise
			FROM User
			WHERE id_user='$idUser'";

	return SQLGetChamp($sql);
}


function email($idUser)
{
	// Augustin
	//Cette fonction renvoie le mail d’un utilisateur.

	$sql="SELECT email
			FROM User
			WHERE id_user='$idUser'";

	return SQLGetChamp($sql);
}


function setentreprise($nom ,$siege ,$tel ,$siret ,$idUser)
{
	// Augustin
	//Cette fonction permet de mettre un compte en entreprise, met les informations de l'entreprise et met à jour le statut de l'utilisateur en entreprise.
	
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
	// Augustin
	//Cette fonction permet d’ajouter un produit à la base de données.

	$sql = "INSERT INTO Produit(nom, description, url_photo, prix, niveau, type, pointure, marque, lames,poids,id_entreprise)
	        VALUES ('$nom', '$description', '$URL_photo', '$prix', '$niveau', '$type','$pointure', '$marque', '$lame','$poid','$identreprise');";
  
  	SQLInsert($sql);
}


function identreprise($id)
{
	// Augustin
	//Cette fonction renvoie l'id entreprise associé.
	$sql="SELECT id_entreprise
			FROM Entreprise
			WHERE id_user = $id ;";

	return SQLGetChamp($sql);
}


function DejaDansPanier($idUser,$id_produit)
{
	// Lara
	// Cette fonction renvoie le produit passé en paramètres s’il est dans la table “Produits” sinon elle renvoie NULL.
	
	$sql="SELECT id_produit
			FROM Panier
			WHERE id_user='$idUser' AND id_produit='$id_produit'";

	return SQLGetChamp($sql);
}


function IncrementeQuantite($idUser,$id_produit)
{
	// Lara
	// Cette fonction incrémente la quantité du produit passé en paramètre dans la table “Panier”.
	
	$sql = "UPDATE Panier
          SET quantite = quantite+1
          WHERE id_user  = '$idUser' AND id_produit='$id_produit'";
    SQLUpdate($sql);
}


function DecrementeQuantite($idUser,$id_produit)
{
	// Lara
	//Cette fonction décrémente la quantité du produit passé en paramètre dans la table “Panier”.

	$sql = "UPDATE Panier
          SET quantite = quantite-1
          WHERE id_user  = '$idUser' AND id_produit='$id_produit'";
    SQLUpdate($sql);
}


function AjouteAuPanier($idUser,$id_produit)
{
	// Lara
	// Cette fonction ajoute l’enregistrement correspondant au produit et à l’utilisateur indiqués en paramètres dans la table “Panier”.
	
	$sql = "INSERT INTO Panier
	        VALUES ('$idUser', '$id_produit', 1);";
  	SQLInsert($sql);
}


function RetireDuPanier($id_produit, $id_user)
{
	// Lara
	// Cette fonction supprime l’enregistrement correspondant au produit et à l’utilisateur indiqués en paramètres de la table “Panier”.
	
	$sql="DELETE FROM Panier WHERE id_user = '$id_user' AND id_produit='$id_produit'";
	SQLDelete($sql);
}


function ListerPanier($idUser)
{
	// Lara
	// Cette fonction récupère les produits du panier de l utilisateur passé en paramètres et les renvoie sous forme d’un tableau associatif.
	
	$sql = "SELECT Produit.id_produit, Produit.nom, Produit.url_photo, Produit.prix, Produit.description, Panier.quantite
	FROM Produit JOIN Panier ON Panier.id_produit=Produit.id_produit WHERE Panier.id_user='$idUser';";
	return parcoursRs(SQLSelect($sql));
}


function getProduit($id)
{
	// Augustin
	//On donne l'id du produit et la fonction nous renvoie les informations sous forme de tableau associatif.
	
	$sql="SELECT *
			FROM Produit
			WHERE id_produit = $id;";

	
	return parcoursRs(SQLSelect($sql));

}


function notemoy($id_produit)
{
	// Augustin
	//Cette fonction retourne la note moyenne d'un produit.

	$sql="SELECT AVG(note)
			FROM Avis
			WHERE id_produit = $id_produit;";

	return SQLGetChamp($sql);
}


function addnote($id_user,$id_produit,$note)
{
	// Augustin
	//Cette fonction permet d’ajouter une note à un produit.

	$sql="DELETE FROM Avis WHERE id_user = '$id_user' AND id_produit='$id_produit'";
	SQLDelete($sql);

	$sql = "INSERT INTO Avis(id_user, id_produit,avis, note)
	        VALUES ('$id_user', '$id_produit', NULL ,'$note');";
	SQLInsert($sql);

}


function addCommentaire($id_user,$id_produit,$commentaire)
{
	// Augustin
	//Cette fonction permet d’ajouter un commentaire à un produit.

	$sql = "INSERT INTO Avis(id_user, id_produit,avis, note)
	        VALUES ('$id_user', '$id_produit', '$commentaire' ,NULL);";
	SQLInsert($sql);
}


function listercommentaire($id_produit)
{
	// Augustin
	// Cette fonction renvoie la liste des commentaires d’un produit sous forme de tableau associatif.
	$sql="SELECT User.username, avis
			FROM Avis join User
				ON Avis.id_user=User.id_user
			Where id_produit = '$id_produit';";

	return parcoursRs(SQLSelect($sql));	
}


function ValiderCommande($nom,$prenom,$adresse,$ville,$code_postal,$tel,$cb,$exp,$cvv,$idUser)
{
	// Lara
	// Cette fonction enregistre une commande dans la table commande avec tous les attributs passés en paramètres et renvoie l’id de la commande alors créée.
	
	$date=date('Y-m-d');
	$sql = "INSERT INTO Commande(date,etat_livraison,nom,prenom,adresse,ville,code_postal,telephone,CB,date_expiration,CVV,id_user)
	        VALUES ('$date', 0,'$nom','$prenom','$adresse','$ville','$code_postal','$tel','$cb','$exp','$cvv','$idUser');";
	SQLInsert($sql);

	return SQLGetChamp("SELECT MAX(id_commande) FROM Commande WHERE id_user='$idUser'");
}


function AjouteDetailCommande($id_commande, $id_produit, $quantite, $id_user)
{
	// Lara
	//Cette fonction enregistre les détails d’une commande dans la table Detail_commande.

	$sql = "INSERT INTO Detail_commande VALUES ('$id_commande', '$id_produit', $quantite);";
  	SQLInsert($sql);
	$sql = "DELETE FROM Panier WHERE id_user = '$id_user' AND id_produit = '$id_produit'";
	SQLDelete($sql);
}


function ListeCommande($id_user)
{
	// Lara
	//Cette fonction récupère toutes les commandes de l’utilisateur passé en paramètre et les renvoie sous forme d’un tableau associatif.
	
	$sql = "SELECT id_commande, date, etat_livraison FROM Commande WHERE id_user='$id_user';";
	return parcoursRs(SQLSelect($sql));
}


function getCommande($id_commande)
{
	// Lara
	//Cette fonction récupère les produits relatifs à la commande passée en paramètre et les renvoie sous forme d’un tableau associatif.
	
	$sql = "SELECT Commande.date, Commande.etat_livraison, Detail_commande.quantite, Produit.url_photo, Produit.prix, Produit.nom
			FROM Detail_commande JOIN Produit ON Detail_commande.id_produit=Produit.id_produit 
			JOIN Commande ON Commande.id_commande=Detail_commande.id_commande
			WHERE Detail_commande.id_commande='$id_commande';";
	return parcoursRs(SQLSelect($sql));
}


function ListerProduitEntreprise($id_entreprise)
{
	// Lara
	//Cette fonction récupère tous les produits de entreprise passée en paramètre et les renvoie sous forme d’un tableau associatif.

	$sql = "SELECT id_produit, nom, description, url_photo, prix FROM Produit 
	WHERE id_entreprise='$id_entreprise' AND description!='produit supprimé';";
	return parcoursRs(SQLSelect($sql));
}

function SupprimeProduit($id_produit)
{
	// Lara
	// Cette fonction supprime le produit passé en paramètre de la BDD en mettant sa description à 'produit supprimé' 
	// la suppression pure et simple (DELETE) n'est pas directement possible car un utilisateur n'aurait plus acces au produit qu'il aurait précedemment commandé.

	$sql = "UPDATE Produit SET description = 'produit supprimé' WHERE id_produit='$id_produit'";
    SQLUpdate($sql);
}


function deltapointure($MINouMAX)
{
	// Augustin
	// Cette fonction renvoie la pointure minimale ou maximale (selon le paramètre) existante dans la table "Produits"
	
	if($MINouMAX=="MIN")
		return SQLGetChamp("SELECT MIN(pointure) FROM Produit;");
	if($MINouMAX=="MAX")
		return SQLGetChamp("SELECT MAX(pointure) FROM Produit;");
}

function getmarque()
{
	// Augustin
	// Cette fonction récupère toutes les marques distinctes existantes dans la table “Produits” et les renvoie sous forme d’un tableau associatif.
	
	$sql=" SELECT DISTINCT(marque)
			FROM Produit";
	return parcoursRs(SQLSelect($sql));
}


function ListerProduit($recherche = "")
{
	// Augustin et Lara
	//Cette fonction récupère tous les produits enregistrés et non supprimés dans la table “Produits” et les renvoie sous forme d’un tableau associatif.
	
	$sql = "SELECT *
			FROM Produit
			WHERE description!='produit supprimé' AND nom LIKE '%$recherche%';";

	return parcoursRs(SQLSelect($sql));
}

function Filter($pointure="",$marque="",$prixmin="0",$prixmax = "")
{
	// Augustin
	//Cette fonction permet de renvoyer un tableau associatif de produits suivant un ou plusieurs filtres.
	
	if($prixmax == "")
	 	$prixmax = SQLGetChamp("SELECT MAX(prix) FROM Produit");	

	$sql = "SELECT *
			FROM Produit
			WHERE description!='produit supprimé' 
					AND pointure = '$pointure'
					AND marque = '$marque'
					AND prix BETWEEN '$prixmin' AND '$prixmax'
			
			; ";

	return parcoursRs(SQLSelect($sql));
}

?>
