<!--
    auteur:LARA
    Template liste_produit:
	Vue des différents produits proposés par l'entreprise de l'utilisateur connecté
    Possibilité de les supprimer du magasin depuis cette template

-->


<?php


include_once "libs/modele.php"; 
include_once "libs/maLibForms.php"; 
include_once "libs/maLibUtils.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

// Cette interface ne doit pas etre offerte aux utilisateurs qui n'ont pas de compte entreprise

if (!valider("entreprise","SESSION")) {
	
	// On choisit de charger la vue de login 
	$_REQUEST["msg"] = "Il faut que vous soyez une entreprise !!"; 
	include("templates/magasin.php");
} else {

?>

<div class="page-header">
	<h1 class="titre">Liste de vos produits</h1>
</div>

<?php

$id_entreprise=valider("id_entreprise","SESSION");
$produits=ListerProduitEntreprise($id_entreprise);

if($produits == array())
	echo "Vous n'avez pas encore ajouté de produit au magasin";


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
		 <div class='description'><p> $description </p></div>";

	if (valider("connecte","SESSION"))
	{
		mkForm("controleur.php");
		mkInput("hidden","id_produit",$id_produit);
		mkInput("submit","action","Supprimer", array(), "class=\"retirer btn btn-default\"");
		endForm();
	}
	echo "</div>";
}

}
?>