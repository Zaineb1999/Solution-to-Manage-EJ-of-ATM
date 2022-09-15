<?php

    require_once('identifier.php');

    require_once('connexion.php');

    $iduser=isset($_POST['iduser'])?$_POST['iduser']:0;

    $login=isset($_POST['login'])?$_POST['login']:"";

    $email=isset($_POST['email'])?($_POST['email']):"";

    $requete='update utilisateur set login="'.$login.'",email="'.$email.'" where iduser="'.$iduser.'"';

    $resultat=mysqli_query($con,$requete);
    
    header('location:login.php');
    
?>
