<?php

//Template des commandes : vue des différentes commandes passées par l'utilisateur

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

$idUser=valider("idUser","SESSION");
$commandes=ListeCommande($idUser);

?>

<div class="page-header">
    <h1 class="titre">Commandes</h1>
</div>

<?php

foreach($commandes as $commande)
{
    $id_commande=$commande["id_commande"];
    $date=$commande["date"];
    $etat_livraison=$commande["etat_livraison"];

    echo "<div class='produit'>
         <p class=\"para\"> commande N°$id_commande </p>
         <p class=\"para\"> date : $date </p>";
    if($etat_livraison==0)
        echo "<p class=\"para\" style='color:blue'> état de livraison : pas encore expédié </p>";
    if($etat_livraison==1)
        echo "<p class=\"para\" style='color:orange'> état de livraison : en cours de livraison </p>";
    if($etat_livraison==2)
        echo "<p class=\"para\" style='color:green'> état de livraison : livré  </p>";
    mkForm("controleur.php");
    mkInput("hidden","id_commande",$id_commande);
    mkInput("submit","action","Voir plus", array(), "class=\"boutonplus btn btn-default\"");
    endForm();

    echo "</div>";
}

}
?>