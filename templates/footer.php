<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>

<style>
	.contentfooter{
	
		margin-right: 50px;
		padding: 10px;
	}
	.deconnecter{
		float: right;
	
	}


</style>



</div>
<!-- fin du content --> 

<!-- fin du wrap -->
</div>

<div id="footer">
  <div class="container">
   	 <p class="text-muted credit">

		<a  class="contentfooter" href="index.php?view=contact">contact</a>

		<?php

		//si l'utilisateur et connecté et qu'il n'est pas une entreprise afficher le bouton demande d'entreprise
		if(valider("connecte","SESSION"))
			if(!$_SESSION["entreprise"])
				echo "<a class=\"contentfooter\" href=\"index.php?view=compteentreprise\"\">demande de compte entreprise</a>";
			
		
		// Si l'utilisateur est connecte, on affiche un lien de deconnexion 
		if (valider("connecte","SESSION"))
		{
			echo "<a class=\"deconnecter \" href=\"controleur.php?view=magasin&action=Logout\">Se Déconnecter</a>";
		}
		//tprint($_SESSION);
		?>
		
	</p>
  </div>
</div>

</body>
</html>
