<!--
    auteur:LARA
    Template tunnel:
	Permet de renseigner de valider une commande en rentrant les informations de livraison et de paiement via un formulaire
    (La commande n'est passée que si les informations envoyées au contrôleur sont valides)

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

// Cette interface ne doit pas etre offerte aux utilisateurs non connectés
if (!valider("connecte","SESSION")) {
	
	// On choisit de charger la vue de login 
	$_REQUEST["msg"] = "Il faut vous connecter !!"; 
	include("templates/magasin.php");
} else {
?>

<img src="ressources/panier.png" height="30" width="30" alt="imgpanier">
<h2 class="titre">Panier</h2>
<div class="page-header">
    <h2 class="titre">Tunnel</h2>
</div>

<form role="form" action="controleur.php">

    <h3>livraison</h3></br>
    <div class="form-group">
        <label for="nom">Nom : </label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="nom">
    </div>
    <div class="form-group">
        <label for="prenom">Prenom : </label>
        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="prenom">
    </div>
    <div class="form-group">
        <label for="adresse">Adresse de livraison : </label>
        <input type="text" class="form-control" id="adresse" name="adresse" placeholder="adresse">
        <input type="text" class="form-control" name="codepostal" placeholder="code postal">
        <input type="text" class="form-control" name="ville" placeholder="ville">
    </div>
    <div class="form-group">
        <label for="tel">Téléphone (sans espace) : </label>
        <input type="text" class="form-control" id="tel" name="tel" placeholder="telephone">
    </div>

    <h3>paiement</h3></br>
    <div class="form-group">
        <label for="cb">Numéro CB (sans espace) : </label>
        <input type="text" class="form-control" id="cb" name="cb" placeholder="numero">
    </div>
    <div class="form-group">
        <label for="exp">Date expiration : </label>
        <input type="date" class="form-control" id="exp" name="exp" placeholder="nom">
    </div>
    <div class="form-group">
        <label for="cvv">CVV : </label>
        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="numero">
    </div>

    <button type="submit" name="action" value="valider" class="form-control btn btn-default">Valider la commande</button>
    <br/><br/>
</form>

<?php
}
?>