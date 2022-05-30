<!--
    auteur:LARA/AUGUSTIN
    Template magasin (vue par défaut) :
	Vue des différents produits proposés sur le site + possibilité d'accéder à leurs détails et de les ajouter au panier
    
	+ Filtre permettant d'affiner la liste des produits affichés

-->

<?php

//Template du magasin : vue des différents produits proposés

include_once "libs/modele.php"; 
include_once "libs/maLibForms.php"; 
include_once "libs/maLibUtils.php";


?>


<div class="page-header">
	<h1 class="titre">Magasin</h1>
</div>



<!-- debut du filtre -->
  
<div class="filtre">
<?php
mkForm("","","formbtn");

if(valider("pointure","GET"))
	$pointure = $_GET["pointure"];
else
	$pointure = deltapointure("MIN");

if(valider("marque","GET"))
	$marquevalue = $_GET["marque"];
else
	$marquevalue = "";

if(valider("prixmin","GET"))
	$prixmin = $_GET["prixmin"];
else
	$prixmin = "";

if(valider("prixmax","GET"))
	$prixmax = $_GET["prixmax"];
else
	$prixmax = "";


?>

<h3 class="inline">Filtre</h3>
pointure :
<input class="slider" type="range"
	name="pointure"
	min="<?=deltapointure("MIN");?>" 
	max="<?=deltapointure("MAX");?>" 
	value="<?=$pointure?>"
	oninput="this.nextElementSibling.value = this.value"
	size="2"
>
<output><?=$pointure?></output>





<?php
echo "&nbsp&nbsp&nbsp&nbsp";
echo "Prix de : ";
mkinput("text","prixmin","$prixmin","","size= \"3\"");
echo "à ";
mkinput("text","prixmax","$prixmax","","size= \"3\"");
echo "€&nbsp&nbsp&nbsp&nbsp";

$marque = getmarque();
mkSelect("marque", $marque, "marque","marque");
echo "&nbsp&nbsp&nbsp&nbsp";


mkinput("hidden","filtreactiver","1");
mkinput("submit","action","Filtrer","","class=\" btn btn-default\"");

endform();

mkForm("","get","formbtn");
mkinput("submit","action","Reset","","class=\" btn btn-default\"");
endform();

echo "</div>";

?>

<!-- fin du filtre -->


<?php

if(!valider("rechercher","GET"))
	$produits=ListerProduit();
else
	$produits=ListerProduit($_GET["rechercher"]);


if(valider("filtreactiver","GET"))
	$produits = Filter($_GET["pointure"],$_GET["marque"],$_GET["prixmin"],$_GET["prixmax"]);


if($produits == array())
	echo "Aucun produit trouvé";


foreach($produits as $produit)
{
	
	$nom=$produit["nom"];
	$description=$produit["description"];
	$photo=$produit["url_photo"];
	$prix=$produit["prix"];
	$id_produit=$produit["id_produit"];
	$pointure=$produit["pointure"];

	echo "<div class='produit'>
		 <a href=\"index.php?view=detail_produit&id_produit=$id_produit\"> <img class=\"image\" src=\"$photo\" alt=\"image non disponible\" height=\"100\" weight=\"100\"/> </a>
		 <a href=\"index.php?view=detail_produit&id_produit=$id_produit\" style='margin-left: 40px; display: inline-block'> <h3> $nom </h3> </a>
		 <h4 style='display:inline-block'> - $pointure </h4>
		 <h4 style='float:right'> $prix € </h4>
		 <div class='description'><p> $description </p></div>";

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


