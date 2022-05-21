<?php

include_once "libs/modele.php"; 
include_once "libs/maLibForms.php"; 
include_once "libs/maLibUtils.php";
include_once "libs/maLibSecurisation.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>TinyMVC ...</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

	<!-- Liaisons aux fichiers css de Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" />
	<link href="css/sticky-footer.css" rel="stylesheet" />
	<link href="css/style.css" rel="stylesheet" />
	<!--[if lt IE 9]>
	  <script src="js/html5shiv.js"></script>
	  <script src="js/respond.min.js"></script>
	<![endif]-->

	<script src="js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	

</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

<!-- style inspiré de http://www.bootstrapzero.com/bootstrap-template/sticky-footer --> 

<!-- Wrap all page content here -->
<div id="wrap">
  
  <!-- Fixed navbar -->
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php?view=accueil">
				<img src="ressources/patins.png" alt="LogoPatin" height="30" />
			</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
         	<!--<li class="active"><a href="index.php?view=accueil">Accueil</a></li> -->
		<?=mkHeadLink("Magasin","magasin",$view)?>
		
		<!-- Afichage des paramètre si connecté -->
		<?php

		if (valider("connecte", "SESSION")){
			if (valider("entreprise", "SESSION")) {
				echo mkHeadLink("Liste","liste_produit",$view);
				echo mkHeadLink("Ajout","ajout_produit",$view);
			}
			echo mkHeadLink("Commandes","commande",$view);
			echo mkHeadLink("Paramètres","settings",$view);
		}
		
		?>

		<!-- affichage de la barre de recherche -->
		<li>
			<form class="rechercher">
				<input class="rechercher form-control" type="text" name="rechercher" placeholder="rechercher">
				<!-- <input type="image" src="ressources/loupe.png" height="20" name="action" value="rechercher" > -->
				<input class="rechercher form-control" type="submit" name="action" value="rechercher">
			</form>
		</li>
		


		<?php
		// mkForm();
		// 	mkInput("text","rechercher","rechercher");
		// 	mkInput("submit","action","rechercher");
		// endform();

		// Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
		if (!valider("connecte","SESSION"))
			echo mkHeadLink("Se connecter","login",$view); 
		
		//l'utilisateur n'as pas accés a son panier s'il n'est pas connecté
		if (valider("connecte","SESSION"))
			echo mkHeadLink("<img src=\"ressources/panier.png\" height=\"20\" alt=\"imgpanier\">","panier",$view);
		
		?>

		

		

        </ul>

		
      </div><!--/.nav-collapse -->
    </div>
  </div>
  


  <!-- Begin page content -->
  	<div class="container">  

	<?php

	if ($msg = valider("msg", "GET")) {
	echo "<div id=\"warning\">$msg</div>\n";
	}

	?>










