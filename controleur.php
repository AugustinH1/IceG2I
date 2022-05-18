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
					$tabQs["view"]="magasin";
					mkUser($_GET["email"], $_GET["username"], $_GET["passe"], $connecte=0, $entreprise=0);
				}
				else
				{
					$tabQs["view"]="signin";
					$tabQs["msg"]="les mots de passe ne corespondent pas";
					
				}


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










