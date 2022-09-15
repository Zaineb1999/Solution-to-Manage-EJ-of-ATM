<?php
   require_once('role.php');
    require_once("identifier.php");
    require_once("connexion.php");
    $login=isset($_GET['login'])?$_GET['login']:"";
    $requeteUser='select * from utilisateur where login="'.$login.'"';   
    $resultatUser=mysqli_query($con,$requeteUser);
    $requeteCount='select * from utilisateur';
    $resultatCount=mysqli_query($con,$requeteCount);
    $nbrUser=mysqli_num_rows($resultatCount);



?>
<! DOCTYPE HTML>
<HTML>
    <head>
        <meta charset="utf-8">
        <title>Gestion des utilisateurs</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../css/Style.css">
    </head>
    <body>
        <?php include("menu.php"); ?>
        
        <div class="container margin1">
                      
            <div class="panel panel-default">
                <div class="panel-heading">Liste des utilisateurs (<?php echo $nbrUser ?> utilisateurs)</div>
                <div class="panel-body">
                    </br>
                   <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="rechercher un utilisateur" title="id GAB">
                    </br>
                    </br>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>login</th> <th>Email</th> <th>Role</th> <th>Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody id="myTable">
                            <?php while($user=mysqli_fetch_row($resultatCount)){ ?>
                                <tr class="<?php echo $user[4]==1?'success':'danger'?>">
                                    <td><?php echo $user[1] ?> </td>
                                    <td><?php echo $user[2] ?> </td>
                                    <td><?php echo $user[3] ?> </td>  
                                   <td>
                                        <a href="editerUtilisateur.php?idUser=<?php echo $user[0] ?>">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        &nbsp;&nbsp;
                                        <a onclick="return confirm('Etes vous sur de vouloir supprimer cet utilisateur')"
                                            href="supprimerUtilisateur.php?idUser=<?php echo $user[0] ?>">
                                                <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                        &nbsp;&nbsp;
                <a href="activerUtilisateur.php?idUser=<?php echo $user[0]?>&etat=<?php echo $user[4]?>">  
                                                <?php  
                                                    if($user[4]==1)
                                                        echo '<span class="glyphicon glyphicon-remove"></span>';
                                                    else 
                                                        echo '<span class="glyphicon glyphicon-ok"></span>';
                                                ?>
                                            </a>
                                        </td>       
                                </tr>
                             <?php } ?>
                        </tbody>
                    </table>
                <div>
                </div>
                </div>
            </div>
        </div>
    </body>
<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</HTML>