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
					$passe=SecuriseChamp($_GET["passe"], 30);
					$username=SecuriseChamp($_GET["username"], 30);
					$email=SecuriseChamp($_GET["email"], 50);

					if($passe && $username && $email)
						mkUser($email, $username, $passe, $connecte=0, $entreprise=0);
					else
						$tabQs["msg"]="Une des informations est trop longue";
					$tabQs["view"]="login";
				}
				else
				{
					$tabQs["view"]="signin";
					$tabQs["msg"]="les mots de passe ne corespondent pas";
				}
			break;

			case 'compteentreprise' :
				$nom=SecuriseChamp($_GET["nom"], 50);
				$siege=SecuriseChamp($_GET["siege"], 50);
				$tel=SecuriseChamp($_GET["tel"], 10, true); 	//le numero de telephone doit être composé d'exactement 10 chiffres
				$siret=SecuriseChamp($_GET["Siret"], 14, true); //le siret doit être composé d'exactement 14 chiffres

				if($nom && $siege && $tel && $siret)
				{
					setentreprise($nom ,$siege ,$tel ,$siret ,$_SESSION["idUser"]);
					$_SESSION["entreprise"] = 1;
					$_SESSION["id_entreprise"] = identreprise($_SESSION["idUser"]);
				}
				else
					$tabQs["msg"]="Une des informations est invalide";
				$tabQs["view"]="magasin";
			break;

			case 'Changer pseudo':
				$pseudo=SecuriseChamp($_GET["pseudo"], 30);
				if($pseudo)
				{
					changerPseudo($_SESSION["idUser"], $_GET["pseudo"]);
					$_SESSION["pseudo"] = $_GET["pseudo"];
				}
				else
					$tabQs["msg"]="Le nouveau pseudo n'est pas valide";
			break;

			case 'Changer email':
				$email=SecuriseChamp($_GET["email"], 50);
				if($email)
				{
					changerEmail($_SESSION["idUser"], $email);
					$_SESSION["email"] = $_GET["email"];
				}
				else
					$tabQs["msg"]="Le nouvel email n'est pas valide";
			break;

			case 'Changer mot de passe':
				$passe=SecuriseChamp($_GET["passe"], 30);
				if($passe)
					changerPasse($_SESSION["idUser"], $passe);
				else
					$tabQs["msg"]="Le nouveau mot de passe n'est pas valide";
			break;
			
			case 'Ajouter Produit':
				$nom=SecuriseChamp($_GET["nom"], 30);
				$description=SecuriseChamp($_GET["description"], 1000);
				//ici SecurisationChamp permet surtout d'éviter les injections SQL et JS via la description du produit (l'entreprise pourra utiliser les apostrophes sans avoir d'erreur)
				$photo=SecuriseChamp($_GET["photo"], 500);
				$prix=SecuriseChamp($_GET["prix"], 3); 		   //Le prix ne doit pas dépasser 999€ (limite 3 caractères) sinon le patin est trop cher, il s'agit d'une arnaque
				$niveau=SecuriseChamp($_GET["niveau"], 30);
				$type=SecuriseChamp($_GET["type"], 30);
				$pointure=SecuriseChamp($_GET["pointure"], 2); //La pointure ne doit pas dépasser 99 (limite 2 caractères) sinon il s'agit d'une arnaque
				$marque=SecuriseChamp($_GET["marque"], 30);
				$lame=SecuriseChamp($_GET["lame"], 50);
				$poids=SecuriseChamp($_GET["poids"], 1); 	   //Le poids ne doit pas dépasser 9kg (limite 1 caractère) sinon le patin est trop lourd, il s'agit d'une arnaque

				if($nom && $description && $photo && $prix && $niveau && $type && $pointure && $marque && $lame && $poids)
					AjouterProduit($nom,$description,$photo,$prix,$niveau,$type,$pointure,$marque,$lame,$poids,$_SESSION["id_entreprise"]);
				else
				$tabQs["msg"]="Une des informations est trop longue";
			break;

			case 'Ajouter au panier':
				$idUser=$_SESSION["idUser"];
				if($id_produit=valider("id_produit","GET"))
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
				$commentaire=SecuriseChamp($_GET["commentaire"], 1000); 
				//ici SecurisationChamp permet surtout d'éviter les injections SQL et JS via le commentaire (l'utilisateur pourra utiliser les apostrophes sans avoir d'erreur)
				
				if(!($_GET["commentaire"]=="") && $commentaire)
					addCommentaire($_SESSION["idUser"],$_GET["id_produit"],$commentaire);
				$tabQs["view"]= "detail_produit";
				$tabQs["id_produit"]= $_GET["id_produit"];
			break;

			case 'valider':
				$nom=SecuriseChamp($_GET["nom"], 30);
				$prenom=SecuriseChamp($_GET["prenom"], 30);
				$adresse=SecuriseChamp($_GET["adresse"], 50);
				$ville=SecuriseChamp($_GET["ville"], 30);
				$codepostal=SecuriseChamp($_GET["codepostal"], 5, true); //Le code postal doit être composé d'exactement 5 chiffres
				$tel=SecuriseChamp($_GET["tel"], 10, true); 			 //le numero de telephone doit être composé d'exactement 10 chiffres
				$cb=SecuriseChamp($_GET["cb"], 16, true); 				 //le numero de cb doit être composé d'exactement 16 chiffres
				$cvv=SecuriseChamp($_GET["cvv"], 3, true); 				 //le numero cvv doit être composé d'exactement 3 chiffres

				// En plus du fait que tous les champs doivent respecter la limite du nombre de caractères autorisée,
				// il faut que la date d'expiration de la carte bancaire soit postérieure à la date actuelle sinon la commande est impossible
				if($_GET["exp"]>date('Y-m-d') && $nom && $prenom && $adresse && $ville && $codepostal && $tel && $cb && $cvv)
				{
					$idUser=valider("idUser","SESSION");
					$existe=1;
					$produits=ListerPanier($idUser);

					foreach($produits as $produit)
					{
						if($produit["description"]=='produit supprimé') //un produit a peut être été supprimé du magasin alors qu'un utilisateur s'apprétait à le commander
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
				}
				else
					$tabQs["msg"]="Une des informations est invalide, veuillez recommencer";
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










