<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	//$qs = "";
	$tabQs = array();
	
	if ($view = valider("view")) {
	  //$qs = "view=$view";
	  $tabQs["view"] = $view;
	}

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			
			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, 
					// et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					if (verifUser($login,$passe)) {
					  connecterUtilisateur(valider("idUser", "SESSION"));
						// tout s'est bien passé, doit-on se souvenir de la personne ? 
						if (valider("remember")) {
							setcookie("login",$login , time()+60*60*24*30);
							setcookie("passe",$password, time()+60*60*24*30);
							setcookie("remember",true, time()+60*60*24*30);
						} else {
							setcookie("login","", time()-3600);
							setcookie("passe","", time()-3600);
							setcookie("remember",false, time()-3600);
						}
					}
					$tabQs["view"]="magasin";
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Logout' :
				// traitement métier
			  	deconnecterUtilisateur(valider("idUser", "SESSION"));
				session_destroy();
				$_SESSION = array();
				setcookie("login", "", time()-3600);
				setcookie("passe", "", time()-3600);
				setcookie("remember", false, time()-3600);
			break;

			case 'signin' :
				
			
				if($_GET["passe"]==$_GET["confirmpwd"])
				{
					$tabQs["view"]="login";
					mkUser($_GET["email"], $_GET["username"], $_GET["passe"], $connecte=0, $entreprise=0);
				}
				else
				{
					$tabQs["view"]="signin";
					$tabQs["msg"]="les mots de passe ne corespondent pas";
					
				}


			break;

			case 'compteentreprise' :

				setentreprise($_GET["nom"] ,$_GET["siege"] ,$_GET["tel"] ,$_GET["siret"] ,$_SESSION["idUser"]);
				$_SESSION["entreprise"] = 1;
				$_SESSION["id_entreprise"] = identreprise($_SESSION["idUser"]);
				$tabQs["view"]="magasin";

			break;

			case 'Changer pseudo':

				changerPseudo($_SESSION["idUser"], $_GET["pseudo"]);
				$_SESSION["pseudo"] = $_GET["pseudo"];

			break;

			case 'Changer email':

				changerEmail($_SESSION["idUser"], $_GET["email"]);
				$_SESSION["email"] = $_GET["email"];

			break;

			case 'Changer mot de passe':

				changerPasse($_SESSION["idUser"], $_GET["passe"]);

			break;
			
			case 'Ajouter Produit':

				AjouterProduit($_GET["nom"],$_GET["description"],$_GET["photo"],$_GET["prix"],$_GET["niveau"],$_GET["type"],$_GET["pointure"],$_GET["marque"],$_GET["lame"],$_GET["poids"],$_SESSION["id_entreprise"]);

			break;

			case 'Ajouter au panier':
				$idUser=$_SESSION["idUser"];
				if($id_produit=valider("id_produit","GET"))
				{
					$produit=getProduit($id_produit);
					if($produit["nom"]!="produit supprimé")
					{
						if(DejaDansPanier($idUser,$id_produit))
						{
							IncrementeQuantite($idUser,$id_produit);
						}
						else
						{
							AjouteAuPanier($idUser,$id_produit);
						}
						$tabQs["view"]="panier";
					}
					else
						echo "ajout impossible : produit supprimé";
				}
				else
				{
					$tabQs["view"]="magasin";
					$tabQs["msg"]="aucun produit sélectionné";
					
				}
			break;
			case 'Retirer du panier':
				if($id_produit=valider("id_produit","GET"))
				{
					$id_user=valider("idUser","SESSION");
					RetireDuPanier($id_produit, $id_user);
					$tabQs["view"]="panier";
				}
				else
				{
					$tabQs["view"]="magasin";
					$tabQs["msg"]="aucun produit sélectionné";
				}
			break;

			case '+':
				if($id_produit=valider("id_produit","GET"))
				{
					$id_user=valider("idUser","SESSION");
					IncrementeQuantite($id_user,$id_produit);
					$tabQs["view"]="panier";
				}
			 	
			break;

			case '-':
				if($_GET["quantite"]>1)
				{
					$id_produit=valider("id_produit","GET");
					$id_user=valider("idUser","SESSION");
					DecrementeQuantite($id_user,$id_produit);
					$tabQs["view"]="panier";
				}
			break;

		
			case 'Noter':
				
				if($_GET["note"]>=1 && $_GET["note"]<=5)
					addnote($_SESSION["idUser"],$_GET["id_produit"],$_GET["note"]);

				$tabQs["view"]= "detail_produit";
				$tabQs["id_produit"]= $_GET["id_produit"];


			break;

			case 'Envoyer':
				if(!$_GET["commentaire"]=="")
					addCommentaire($_SESSION["idUser"],$_GET["id_produit"],$_GET["commentaire"]);
				$tabQs["view"]= "detail_produit";
				$tabQs["id_produit"]= $_GET["id_produit"];
			break;

			case 'valider':
				$idUser=valider("idUser","SESSION");
				$existe=1;
				$produits=ListerPanier($idUser);
        		foreach($produits as $produit)
				{
					if($produit["nom"]=="produit supprimé") //un produit a peut être été supprimé du magasin alors qu'un utilisateur s'apprétait à le commander
						$existe=0;
				}
				if($existe==1)
				{
					$id_commande=ValiderCommande($_GET["nom"],$_GET["prenom"],$_GET["adresse"],$_GET["ville"],$_GET["codepostal"],$_GET["tel"],$_GET["cb"],$_GET["exp"], $_GET["cvv"],$idUser);
					foreach($produits as $produit)
					{
						$id_produit=$produit["id_produit"];
						$quantite=$produit["quantite"];
						AjouteDetailCommande($id_commande, $id_produit, $quantite, $idUser);
					}
				}
				else
					$tabQs["msg"]="Une erreur est survenue : un des produits sélectionné a été supprimé. La commande a été annulée.";
				$tabQs["view"]="magasin";
			break;

			case 'rechercher':
				$tabQs["view"]="magasin";

			break;

			case 'Supprimer':
				if($id_produit=valider("id_produit","GET"))
					SupprimeProduit($id_produit);
				break;

			
		}

	}


	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat


	if ($url=valider("HTTP_REFERER", "SERVER")) //Via la page qui l'a invoquée
	{
		$qs="";
		$urlBase=strtok($url, "&");

		if (is_array($tabQs)) {
			foreach($tabQs as $nom => $val) {
				// Il faut respecter l'encodage des caractères dans les chaînes de requêtes
				$qs .= "$nom=" . urlencode($val) . "&";
			}
		}
		header("Location:$urlBase&" . rtrim($qs, "&") );
	}
	else{ //Solution initiale
		$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
		rediriger($urlBase, $tabQs, false);
	}
	// On redirige vers la page index avec les bons arguments
  

	//header("Location:" . $urlBase . $tabQs["view"]);

	// On écrit seulement après cette entête
	ob_end_flush();
	

?>










