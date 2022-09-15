<?php
require_once('identifier.php');
$idUser=isset($_GET['idUser'])?$_GET['idUser']:0;
$login=isset($_GET['login'])?$_GET['login']:0;

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Changement de mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/Style.css">
    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/monjs.js"></script>
   
</head>
<body>


<div class="container col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 margin1 editpwd">
    <h1 class="text-center">Changement de mot de passe</h1>

    <h2 class="text-center"> Compte :<?php echo $login ?>    </h2>

    <form class="form-horizontal" method="post" action="updatePwd.php?idUser=<?php echo $idUser?>&login=<?php echo $login?>">


        <!-- ***************** Début Ancien mot de passe  ***************** -->
        <div class="input-container">
            <input class="form-control oldpwd"
                   type="password"
                   name="oldpwd"
                   autocomplete="new-password"
                   placeholder="Taper votre Ancien Mot de passe"
                   required >
                   <i id="eyes" class="glyphicon glyphicon-eye-open show-old-pwd clickable"></i>
        </div>


        <!-- ***************** Fin Ancien mot de passe ***************** -->

        <!--  *****************Début Nouveau  mot de passe  ***************** -->

        <div class="input-container">
            <input minlength=4
                    class="form-control newpwd"
                    type="password"
                    name="newpwd"
                    autocomplete="new-password"
                    placeholder="Taper votre Nouveau Mot de passe"
                    required>
            <i id="eyes" class="glyphicon glyphicon-eye-open show-new-pwd clickable"></i>

        </div>
        <!--  *****************  Fin Nouveau  mot de passe   ***************** -->

        <!--  ***************** start submit field  ***************** -->

        <input
                type="submit"
                value="Enregistrer"
                class="btn btn-primary btn-block"/>

        <!--   ***************** end submit field  ***************** -->

    </form>
</div>

</body>
</html>



