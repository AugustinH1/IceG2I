<?php

include_once "libs/modele.php"; 
include_once "libs/maLibForms.php"; 
include_once "libs/maLibUtils.php";

//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

?>

<body>

<h1>magasin</h1>


<?php

$produits=ListerProduit();
foreach($produits as $produit)
{
	
	$nom=$produit["nom"];
	$description=$produit["description"];
	$photo=$produit["url_photo"];
	$prix=$produit["prix"];
	$id_produit=$produit["id_produit"];

	echo "<div class='produit'>
		 <a href=\"index.php?view=detail_produit&id_produit=$id_produit\"> <img class=\"image\" src=\"$photo\" alt=\"imageproduit\" height=\"100\" weight=\"100\"/> </a>
		 <a class=\"nom\" href=\"index.php?view=detail_produit&id_produit=$id_produit\"> <h3> $nom </h3> </a>
		 <h4> $prix € </h4>
		 <p> $description </p>";

	if (valider("connecte","SESSION"))
	{
		mkForm("controleur.php");
		mkInput("hidden","id_produit",$id_produit);
		mkInput("submit","action","Ajouter au panier", array(), "class=\"ajoutpanier\"");
		endForm();
	}
	echo "</div>";
}

?>

</body>


