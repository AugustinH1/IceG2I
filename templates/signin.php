<!--
    auteur:AUGUSTIN
    Template signin:
	  Template qui permet de créer un compte via un formulaire

-->


<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}

// Chargement eventuel des données en cookies
$login = valider("login", "COOKIE");
$passe = valider("passe", "COOKIE"); 
if ($checked = valider("remember", "COOKIE")) $checked = "checked"; 

?>

<div class="page-header">
	<h1>Crée un compte</h1>
</div>




<p class="lead">

 <form role="form" action="controleur.php">
 
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email">
  </div>


  <div class="form-group">
    <label for="email">Nom d'utilisateur</label>
    <input type="text" class="form-control" id="username" name="username" value="<?php echo $login;?>" >
  </div>

  <br>
  <br>

  <div class="form-group">
    <label for="pwd">Mot de passe</label>
    <input type="password" class="form-control" id="pwd" name="passe">
  </div>

  <div class="form-group">
    <label for="pwd">Confirmer mot de passe</label>
    <input type="password" class="form-control" id="confirmpwd" name="confirmpwd">
  </div>

  <button type="submit" name="action" value="signin" class="form-control btn btn-default">Crée le compte</button>

</form>
</p>

<?php


if($message = valider("msg"))
    echo mkError($_GET["msg"]); 


?>



