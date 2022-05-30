<!--
    auteur:Augustin
    Template compte entreprise:
    cette page permet de demandé les informations nécessaire a la création d'un compte entreprise

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

<div class="page-header">
	<h1>Demander un compte entreprise   </h1>
</div>






<p class="lead">

 <form role="form" action="controleur.php">
 
  <div class="form-group">
    <label for="nom">Nom de l'entreprise</label>
    <input type="text" class="form-control" id="nom" name="nom">
  </div>

  <div class="form-group">
    <label for="siege">Siège social</label>
    <input type="text" class="form-control" id="siege" name="siege">
  </div>


  <div class="form-group">
    <label for="tel">Téléphone entreprise (sans espace)</label>
    <input type="text" class="form-control" id="tel" name="tel" >
  </div>

  

  <div class="form-group">
    <label for="pwd">Siret (sans espace)</label>
    <input type="text" class="form-control" id="Siret" name="Siret">
  </div>


  <button type="submit" name="action" value="compteentreprise" class="form-control btn btn-default">Valider compte entreprise</button>

</form>
</p>
