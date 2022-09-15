<?php
     session_start();
    if(isset($_SESSION['user'])){
            require_once('connexion.php');
            
            $idUser=isset($_GET['idUser'])?$_GET['idUser']:0;

            $requete='delete from utilisateur where idUser="'.$idUser.'"';
                        
            $resultat=mysqli_query($con,$requete);
            
            header('location:utilisateurs.php');   
            
    }else {
                header('location:login.php');
        }
    
?>