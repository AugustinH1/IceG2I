<!--
    auteur:AUGUSTIN
    Template settings:
	Possibilité de changer ses informations de compte et de visualiser celles actuelles (email, pseudo...)

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
	<h1 class="titre">Paramètres</h1>
</div>


<div class="settingcontent">
    <div class="settingcontent">
        <h2>Informations du compte</h2>

        <?php 
        echo "Pseudo : ";
        echo $_SESSION["pseudo"];
        echo "<br><br>"; 

        echo "Email : ";
        echo $_SESSION["email"]; 
        ?>

    </div>

    <div class="HRV settingcontent"></div>


    <div class="settingcontent">
        <h2>Changer informations</h2>

        <?php

        mkform();
            mkinput("text","pseudo","","","placeholder=\"nouveau pseudo\"");
            mkinput("submit","action","Changer pseudo");
        endform();

        echo "<br>";

        mkform();
            mkinput("text","email","","","placeholder=\"nouvel email\"");
            mkinput("submit","action","Changer email");
        endform();

        echo "<br>";

        mkform();
            mkinput("password","passe","","","placeholder=\"nouveau mot de passe\"");
            mkinput("submit","action","Changer mot de passe");
        endform();

        ?>

    </div>
</div>
