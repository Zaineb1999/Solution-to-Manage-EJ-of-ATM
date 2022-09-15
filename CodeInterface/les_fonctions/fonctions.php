<?php

function rechercher_par_login($login){
    global $con;
    $requete='select * from utilisateur where login ="'.$login.'"';
    $resultat=mysqli_query($con,$requete);
    $nbrrow=mysqli_num_rows($resultat);
    return $nbrrow;
}

function rechercher_par_email($email){
    global $con;
    $requete='select * from utilisateur where email ="'.$email.'"';
    $resultat=mysqli_query($con,$requete);
    $nbrrow=mysqli_num_rows($resultat);
    return $nbrrow;
}

function rechercher_user_par_email($email){
    global $con;

    $requete='select * from utilisateur where email ="'.$email.'"';

    $resultat=mysqli_query($con,$requete);

    $user=mysqli_fetch_row($resultat);

    if($user)
        return $user;
    else
        return null;
}
