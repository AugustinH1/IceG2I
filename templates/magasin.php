<?php

//Template du magasin : vue des différents produits proposés

include_once "libs/modele.php"; 
include_once "libs/maLibForms.php"; 
include_once "libs/maLibUtils.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

?>

<style>
	.ajoutpanier{
        position: absolute;
        right: 10px;
        bottom: 10px;
    }
</style>

<h1 class="titre">magasin</h1>


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
		 <a href=\"index.php?view=detail_produit&id_produit=$id_produit\" style='display:inline-block'> <h3> $nom </h3> </a>
		 <h4 style='float:right'> $prix € </h4>
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


