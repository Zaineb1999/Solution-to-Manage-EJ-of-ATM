<?php
       session_start();
        if(isset($_SESSION['user'])){
            
            require_once('connexion.php');
            
            $idUser=isset($_GET['idUser'])?$_GET['idUser']:0;
            
            $etat=isset($_GET['etat'])?$_GET['etat']:"";
        
            if($etat==1){
                $newEtat=0;
            }
            
            else {
                $newEtat=1;
            }
            
            $requete='update utilisateur set etat='.$newEtat.' where iduser='.$idUser.'';    
            $resultat=mysqli_query($con,$requete);
            
            header('location:utilisateurs.php');
            
     }else {
           header('location:login.php');
        }
?>