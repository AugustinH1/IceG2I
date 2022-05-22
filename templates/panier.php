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
	// header("Location:?view=login&msg=" . urlencode("Il faut vous connecter !!")); 
	// déclenche une erreur headers already sent 
	// car les entetes HTTP de réponse ont déjà envoyées
	// car la page header envoie un résultat HTML au client 
	// ET que le serveur ne bufferise pas 
	
	// On choisit de charger la vue de login 
	$_REQUEST["msg"] = "Il faut vous connecter !!"; 
	include("templates/magasin.php");
} else {

?>

<style>
	.retirerpanier{
        position: absolute;
        right: 10px;
        bottom: 10px;
    }
	
    .panier{
        border: solid black 1px;
        padding: 10px;
        margin: 10px;
    }

    .commander{
        float:right;
        margin-top: 5px;
        margin-right: 15px;
    }

    .prixtotal{
        float:right;
        border:solid black 1px;
        margin : 10px;
    }
</style>

<img src="ressources/panier.png" height="40" width="40" alt="imgpanier">
<h1 class="titre">Panier</h1>
<div class="panier">

    <?php
        $id_User=valider("connecte","SESSION");
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
            echo "<p style='display:inline-block'> Quantité : $quantite</p>";
            mkInput("submit","action","+");
            mkInput("submit","action","-");
            mkInput("submit","action","Retirer du panier", array(), "class=\"retirerpanier\"");
            endForm();

            echo "</div>";
            $total=$total+$prix;
        }
    ?>

</div>

<?php
    
    mkForm("controleur.php");
    mkInput("submit","action","Commander", array(), "class=\"commander\"");
    endForm();
    echo "<h4 class=\"prixtotal\"> Total : $total € </h4>";
}
?>