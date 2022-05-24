<?php

//Template du magasin : vue des différents produits proposés

include_once "libs/modele.php"; 
include_once "libs/maLibForms.php"; 
include_once "libs/maLibUtils.php";


?>

<style>
	.ajoutpanier{
        position: absolute;
        right: 10px;
        bottom: 10px;
    }
</style>

<div class="page-header">
	<h1 class="titre">magasin</h1>
</div>


<?php

if(valider("rechercher","GET"))
	$produits=ListerProduit($_GET["rechercher"]);
else
$produits=ListerProduit();

if($produits == array())
	echo "Aucun produit trouvé";


foreach($produits as $produit)
{
	
	$nom=$produit["nom"];
	$description=$produit["description"];
	$photo=$produit["url_photo"];
	$prix=$produit["prix"];
	$id_produit=$produit["id_produit"];

	echo "<div class='produit'>
		 <a href=\"index.php?view=detail_produit&id_produit=$id_produit\"> <img class=\"image\" src=\"$photo\" alt=\"image non disponible\" height=\"100\" weight=\"100\"/> </a>
		 <a href=\"index.php?view=detail_produit&id_produit=$id_produit\" style='display:inline-block'> <h3> $nom </h3> </a>
		 <h4 style='float:right'> $prix € </h4>
		 <p> $description </p>";

	if (valider("connecte","SESSION"))
	{
		mkForm("controleur.php");
		mkInput("hidden","id_produit",$id_produit);
		mkInput("submit","action","Ajouter au panier", array(), "class=\"ajoutpanier btn btn-default\"");
		endForm();
	}
	echo "</div>";
}

?>



