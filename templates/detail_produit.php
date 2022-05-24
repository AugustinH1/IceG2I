<?php

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

?>


<div class="page-header">
	<h1 class="titre"></h1>
</div>


<?php
    $id_produit = $_GET["id_produit"];
    $produit=getProduit($id_produit);


    $url = $produit[0]["url_photo"];
    $nom=$produit[0]["nom"];
	$description=$produit[0]["description"];


    echo "<div class = \"detailproduit\">";
    
        echo "<img class=\"image\" src=\"$url\" alt=\"image non disponible\" height=\"200\" weight=\"00\"/>";

        echo "<div class = \"produitprix\">";
            echo "<h4>Prix :".$produit[0]["prix"]." €</h4>";

            if (valider("connecte","SESSION"))//afficher le panier ou non
            {
                mkForm();
                    mkInput("hidden","id_produit",$id_produit);
                    mkInput("submit","action","Ajouter au panier", array(), "class=\" btn btn-default\"");
                endForm();
            }
        echo "</div>";






        echo "<div class = \"innerproduit\">";
            echo "<h3>$nom</h3>";

            echo "<p class = \"descriptionproduit\"> $description </p>";

            echo "<h4>Pointure : ".$produit[0]["pointure"]."</h4>";
        echo "</div>";

        

 
    echo "</div>";



    echo "<br><br><h4>Detail</h4>";

    echo "<table class=\"table table-striped\">";

?>
    
  <tbody>
  <tr>
    <td>Marque</td>
    <td><?=$produit[0]["marque"]?></td>
  </tr>
  <tr>
    <td>Pointure</td>
    <td><?=$produit[0]["pointure"]?></td>
  </tr>
  <tr>
    <td>Type</td>
    <td><?=$produit[0]["type"]?></td>
  </tr>
  <tr>
    <td>Type de lame</td>
    <td><?=$produit[0]["type"]?></td>
  </tr>
  <tr>
    <td>Taille de lame</td>
    <td><?=$produit[0]["lames"]?></td>
  </tr>
  <tr>
    <td>Niveau</td>
    <td><?=$produit[0]["niveau"]?></td>
  </tr>
  <tr>
    <td>Poids</td>
    <td><?=$produit[0]["poids"]?></td>
  </tr>


</tbody>

   







<?php
echo "</table>";


echo  "<div class = \" place\">";

  echo "<div class=\"placeavis\" >";
  echo "<br><h4>Avis</h4>";

  $commentaire = listercommentaire($id_produit);
  

    foreach($commentaire as $C)
    {
      echo "<div class=\"contentavis\">";
        echo "<p class = \"colorpurplue\">";

          echo "Nom : ".$C["username"];
      
        echo "</p>";

        echo "<p class = \"colorblue\">";
          echo $C["avis"];
        echo "</p>";



      echo "</div>";
    }

  echo "</div>";



  echo  "<div class = \" placenote\">";
  echo "<br><br><h4>Note du produit</h4>";

  if(notemoy($id_produit)!=0)
    echo "<h1>".(int)notemoy($id_produit)."</h1>";
  else
    echo "<h2>Pas encore noté</h2>";

  mkForm();
  if (valider("connecte", "SESSION"))
  {
      mkInput("hidden","id_produit",$id_produit);
        mkinput("number","note","5","","min=\"1\" max=\"5\" class=\"\"");
        mkinput("submit","action","Noter","","class=\"btn btn-default\"");
        endForm();
  }
echo  "</div>";


echo  "</div>";

echo  "<br>";


    




    

  


if (valider("connecte", "SESSION"))
{
  echo "<div class = \"test\">";

      echo "<br><br><label for =\"textarea\" ><h4>Poster un commentaire</h4><label>";

      

      mkForm();
          mkInput("hidden","id_produit",$id_produit);
          echo "<textarea class = \"resize: vertical;\" id=\"textarea\"  name=\"commentaire\" rows=\"5\" cols=\"100\"></textarea><br>";
          mkinput("submit","action","Envoyer","","class=\"btn btn-default\"");
      endForm();

  echo "</div>";
}





    


    


?>