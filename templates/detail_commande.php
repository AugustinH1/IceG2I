<!--
    auteur:LARA
    Template detail comande:
    cette page permet de voir le détail d'une commande passée comme les produits achetés 

-->


<?php

//Template du détail d'une commande : vue de ce qui a été commandé lors d'une commande en particulier

include_once "libs/modele.php"; 
include_once "libs/maLibForms.php"; 
include_once "libs/maLibUtils.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

// Cette interface ne doit pas etre offerte aux utilisateurs non connectés

if (!valider("connecte","SESSION")) {
	
	// On choisit de charger la vue de login 
	$_REQUEST["msg"] = "Il faut vous connecter !!"; 
	include("templates/magasin.php");
} else {


$id_commande=valider("id_commande","GET");
$produits=getCommande($id_commande);

?>

<div class="page-header">
    <h1 class="titre"> Commande N°<?=$id_commande?></h1>
</div>

<h4 class="para"> date : <?=$produits[0]["date"]?> </h4>

<?php

$etat=$produits[0]["etat_livraison"];
if($etat==0)
    echo "<h4 class=\"para colorblue\"> état de livraison : pas encore expédié </h4>";
if($etat==1)
    echo "<h4 class=\"para\" style='color:orange'> état de livraison : en cours de livraison </h4>";
if($etat==2)
    echo "<h4 class=\"para\" style='color:green'> état de livraison : livré  </h4>";
?>


<div class="panier">

    <?php

    foreach($produits as $produit)
    {
        $nom=$produit["nom"];
        $photo=$produit["url_photo"];
        $prix=$produit["prix"];
        $quantite=$produit["quantite"];

        echo "<div class='produit'>
            <img class=\"image\" src=\"$photo\" alt=\"image non disponible\" height=\"100\" weight=\"100\"/>
            <h3 style='display:inline-block'> $nom </h3>
            <h4 style='float:right'> $prix € </h4>
            <p> Quantité : $quantite &nbsp</p>
            </div>";
    }
    ?>

</div>

<?php
}
?>