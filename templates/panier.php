<?php

//Template du panier : vue des différents produits dans le panier de l'utilisateur connecté

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

?>

<div class="page-header">
    <img src="ressources/panier.png" height="40" width="40" alt="imgpanier">
    <h1 class="titre">Panier</h1>
</div>

<div class="panier">

    <?php
        $id_User=valider("idUser","SESSION");
        $produits=ListerPanier($id_User);
        $total=0;
        foreach($produits as $produit)
        {
            $nom=$produit["nom"];
            $photo=$produit["url_photo"];
            $prix=$produit["prix"];
            $quantite=$produit["quantite"];
            $id_produit=$produit["id_produit"];

            echo "<div class='produit'>
                <img class=\"image\" src=\"$photo\" alt=\"imageproduit\" height=\"100\" weight=\"100\"/>
                <h3 style='display:inline-block'> $nom </h3>
                <h4 style='float:right'> $prix € </h4>";
            
            mkForm("controleur.php");
            mkInput("hidden","id_produit",$id_produit);
            mkInput("hidden","quantite",$quantite);
            echo "<p style='display:inline-block'> Quantité : $quantite &nbsp</p>";
            mkInput("submit","action","+","","class=\"btn btn-default\"");
            mkInput("submit","action","-","","class=\"btn btn-default\"");
            mkInput("submit","action","Retirer du panier", array(), "class=\"retirerpanier btn btn-default\"");
            endForm();

            echo "</div>";
            $total=$total+($prix*$quantite);
        }
    ?>

</div>


<?php
////panier
    if($produits!=array())
    {
        mkForm("controleur.php");
        mkInput("submit","action","Commander", array(), "class=\"commander btn btn-default\"");
        endForm();
        echo "<h4 class=\"prixtotal\"> Total : $total € </h4>";
    }
    else
        echo "Votre panier est vide !";

}
?>