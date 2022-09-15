<?php
require_once('connexion.php');

require_once('../les_fonctions/fonctions.php');
$erreur = "";
if (isset($_POST['email'])){
    $email = $_POST['email'];
    $user = rechercher_user_par_email($email);

if ($user != null) {
    $id = $user[0];
    $requete = 'update utilisateur set pwd=MD5("0000") where iduser="'.$id .'"';

    $resultat=mysqli_query($con,$requete);

    $to = $user[2];

    $objet = "Initialisation de  votre mot de passe";

    $content = "Votre nouveau mot de passe est 0000, veuillez le modifier à la prochaine ouverture de session";

    $entetes = "From: GesFichiersJournaux" . "\r\n" . "CC:zineb.msl147@gmail.com";

    mail($to, $objet, $content, $entetes);

    $erreur = "non";

    $msg = "Un message contenant votre nouveau mot de passe a été envoyé sur votre adresse Email.";

} else {
    $erreur = "oui";

    $msg = "<strong>Erreur!</strong> L'Email est incorrecte!!!";

}
}
else{
    $email = "";
}




?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Initiliser votre mot de passe</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/Style.css">
</head>
<body>
<div class="container col-md-6 col-md-offset-3 margin1">
    <br>
    <div class="panel panel-primary ">
        <div class="panel-heading">Initiliser votre mot de passe</div>
        <div class="panel-body">
            <form method="post" class="form">

                <div class="form-group">
                    <label class="control-label">
                        Veuillez saisir votre email de récuperation
                    </label>

                    <input type="email" name="email" class="form-control"/>
                </div>

                <button type="submit" class="btn btn-success">Initialiser le mot de passe</button>

            </form>
        </div>
    </div>


    <div class="text-center">

        <?php

        if ($erreur == "oui") {

            echo '<div class="alert alert-danger">' . $msg . '</div>';

            header("refresh:10;url=initialiserPwd.php");

  
        } else if ($erreur == "non") {

            echo '<div class="alert alert-success">' . $msg . '</div>';

            header("refresh:10;url=login.php");


        }

        ?>

    </div>


</div>
</body>
</html>



