<!--
    auteur:AUGUSTIN
    Template newitem:
	Permet à une entreprise de rajouter un produit dans le magasin via un formulaire

-->


<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

?>

<head>	
	<link href="css/style.css" rel="stylesheet" />
</head>




<div class="page-header">
	<h1 class="titre">Ajouter un produit</h1>
</div>




<?php

mkform();


    echo "<div class=\"addproduitcontent\" >";
        echo "<div class=\"addproduitcontent\" >";

            echo "Nom du produit : ";
            mkinput("text","nom","");



            echo "<br><br>Description du produit (caractères max: 1000) : <br>";
            echo "<textarea name=\"description\" rows=\"12\" cols=\"35\"></textarea> <br><br>";
            

            echo "Photo : ";
            mkinput("text","photo","","","placeholder=\"URL photo\"");
        
        echo "</div>";


        echo "<div class=\"addproduitcontent\" id=\"information\">";

            echo "<br><br>Prix (en €) : ";
            mkinput("text","prix","");

            echo "<br><br>Niveau : ";
            mkinput("text","niveau","");

            echo "<br><br>Type : ";
            mkinput("text","type","","","placeholder=\"artistique, hokey...\"");

            echo "<br><br>Pointure (EU) : ";
            mkinput("text","pointure","");

            echo "<br><br>Marque : ";
            mkinput("text","marque","");

            echo "<br><br>Type de lame : ";
            mkinput("text","lame","","","placeholder=\"vitesse,saut...\"");

            echo "<br><br>Poids (en g) : ";
            mkinput("text","poids","");

        echo "</div>";
    echo "</div>";


    echo "<div class=\"addproduit\">";
        mkinput("submit","action","Ajouter Produit");
    echo "</div>";





endform();

?>