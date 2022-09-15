 <?php

session_start();
if(isset($_SESSION['user']))
{
  $userlogin=$_SESSION['user'][1];
  //Connection to DB
  require_once("connexion.php");

  //Get yesterday's date

  $lastDay=date('Y-m-d',strtotime("-1 days"));

  //Get today's date

  $today=date('Y-m-d');

  //Get hour of auto transfer

  $requete='select heure from control_auto';
  $result=mysqli_query($con,$requete);
  $dateTr="";
  while($rows=mysqli_fetch_row($result)) 
  {
    $dateTr=$rows[0];
  }

  //Default view

  $requete='select * from import_auto where file_date="'.$lastDay.'"';
  $resultatA=mysqli_query($con,$requete);


  //state of auto transfer 

  $n=0;  //activated
  $var="";
  $requete='select heure from control_auto where activation=1';
  $result=mysqli_query($con,$requete);
  $num_rows=mysqli_num_rows($result);
  while($rows=mysqli_fetch_row($result)) 
  {
    $var=$rows[0];
  }
  if ($num_rows==0)
  {
    $n=1;  //deactivated
  }

  $r=0; 
  $d=0;
  $a=0;
  $p=0; 
  $t=0;


/**********Activation button*********/

if(isset($_GET['Activation']))
    {
    $requete='select activation from control_auto where activation=1';
    $result=mysqli_query($con,$requete);
    $num_rows=mysqli_num_rows($result);
    if ($num_rows==0)
    { // if deactivated
    $r=0;
    $d=0;
    $p=0;

      $requete='insert into list_cmd values ("","'.$lastDay.'",CURRENT_TIMESTAMP(),"'.$userlogin.'",9,0,"'.$dateTr.'")';
    mysqli_query($con,$requete);
    $requete='update control_auto set activation=1';
    $result=mysqli_query($con,$requete);
    if($result)
    {
      $a=2; 
      if($n==1)
      {
        $n=0; 
        $requete1='select heure from control_auto where activation=1';
        $result1=mysqli_query($con,$requete1);
        $num_rows=mysqli_num_rows($result1);
        while($rows=mysqli_fetch_row($result1)) 
        {
          $var=$rows[0];
        }
      }
    }
    else 
    {
      $a=3;
    }
  }
  else
  {
  $a=4;
}
}

/***********Plannification button************/

else if(isset($_GET['plannification']))
{
$d=0;
$a=0;
$p=0;
  $hour=isset($_GET['hourP'])?$_GET['hourP']:"";
  if($hour)
  {
    if ($n==1)
    { //if deactivated
      $r=7; //user cannot change hour of auto transfer, transfer auto must be activated 
    }
    else
    {
      $t=2;
      $r=8; //activated
      $requete='insert into list_cmd values ("","'.$lastDay.'",CURRENT_TIMESTAMP(),"'.$userlogin.'",6,0,"'.$hour.'")';
      mysqli_query($con,$requete);
      $requete='update control_auto set heure="'.$hour.'"';
      mysqli_query($con,$requete);
      $requete1='select heure from control_auto where activation=1';
        $result1=mysqli_query($con,$requete1);
        $num_rows=mysqli_num_rows($result1);
        while($rows=mysqli_fetch_row($result1)) {
        $var=$rows[0];
    }
    }
  }
  else
  {
    $r=9; //empty
  }
}


/**********Deactivation button***********/


else if(isset($_GET['Desactivation']))
    {
    $requete='select activation from control_auto where activation=0';
    $result=mysqli_query($con,$requete);
    $num_rows=mysqli_num_rows($result);
    if ($num_rows==0){ // if activated
      $r=0;
     $d=0;
     $a=0;

    $requete='insert into list_cmd values ("","'.$lastDay.'",CURRENT_TIMESTAMP(),"'.$userlogin.'",10,0,"'.$dateTr.'")';
       mysqli_query($con,$requete);
    $requete='update control_auto set activation=0';
    $result=mysqli_query($con,$requete);
    if($result)
    {
      $p=4;
      if($n==0)
      {
        $n=1;
      }
    }
    else 
    {
      $p=5;
    }
  }
  else
  {
    $p=6;
  }
  }


/********listing Button*************/

else if(isset($_GET['lister']))
{
$r=0;
$a=0;
$p=0;
$nameFA=isset($_GET['nameFA'])?$_GET['nameFA']:"";
  if($nameFA)
  {
  $time1= strtotime($nameFA);
  $time2= strtotime($today);
  if($time1<$time2){
  $requete='select * from import_auto where file_date="'.$nameFA.'"';
  $resultatA=mysqli_query($con,$requete);
  $requete='insert into list_cmd values ("","'.$nameFA.'",CURRENT_TIMESTAMP(),"'.$userlogin.'",7,0,"'.$dateTr.'")';
   mysqli_query($con,$requete);
 }
 else
 {
   $d=7; //date invalid
 }
}
 else
 {
  $d=6; //empty
}
}
}
else
 {
           header('location:login.php');
        }

?>


<! DOCTYPE HTML>
<HTML>
<head>
	<meta charset="utf-8">
	<title>Consultation des fichiers journals</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/Style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
</head>
<body>
    <?php include("menu.php"); ?>
	<div class="container margin1">
	<div class="state">
    <?php if ($t==2 || $n==0) {?> 
    <p style="color:white;background-color:017329;height:50px;font-size:30px;text-align: center"> <?php echo 'Transfert automatique activé à '.$var.'' ; ?> </p>
    <?php } else if ($t==1 || $n==1) {?>
    <p style="color:white;background-color:A91205;height:50px;font-size:30px;text-align:center"> <?php echo "Transfert automatique désactivé"; ?> </p> <?php } ?>
  </div>
 </br>
	<div class="panel panel-default">
      <div class="panel-heading"><spam id="pannel"> Activation de l'heure de transfert automatique </spam></div>
      <div class="panel-body">
        <form method="get" action="ImportAuto.php" class="form-inline"> 
        <div class="form-group ">
          <input type="hidden" name="Activation" value="Activation" />
          <button type="submit" class="btn btn-success" id="showA" onclick="return confirm('Etes-vous sûr de vouloir activer le transfert automatique ?')"><span class="glyphicon glyphicon-ok"> </span> &nbsp Activer </button>
          </div>
        </form>
        <div class="alerteA">
         <?php if ($a==2) {
          echo "Activation réussite";
          }
          else if ($a==3) {
          echo "erreur de connexion! veuillez réessayer plus tard";
           }
           else if ($a==4) {
          echo "Connexion déjà activée";
           } ?>
         </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading"><spam id="pannel"> Désactivation du transfert automatique </spam></div>
      <div class="panel-body">
        <form method="get" action="ImportAuto.php" class="form-inline"> 
           <div class="form-group ">
          <input type="hidden" name="Desactivation" value="Desactivation" />
          <button type="submit" class="btn btn-danger" id="showD" onclick="return confirm('Etes-vous sûr de vouloir désactiver le transfert automatique ?')"><span class="glyphicon glyphicon-remove"> </span> &nbsp Désactiver </button>
          </div>
        </form>
        <div class="alerteD">
         <?php if ($p==4) {
          echo "Désactivation réussite";
          }
          else if ($p==5) {
          echo "erreur de connexion! veuillez réessayer plus tard";
           }
           else if ($p==6) {
          echo "Connexion déjà désactivée ";
           }
           ?>
         </div>
      </div>
    </div>
	<div class="panel panel-default">
      <div class="panel-heading"><spam id="pannel"> Plannification de l'heure de transfert automatique </spam></div>
      <div class="panel-body">
        <form method="get" action="ImportAuto.php" class="form-inline"> 
           <div class="form-group ">
          <input type="time" name="hourP" class="form-control">
          <button type="submit" class="btn btn-success" id="showP" name="plannification"><span class="glyphicon glyphicon-ok"> </span> &nbsp enregistrer </button>
          </div>
        </form>
        <div class="alerteP">
          <?php if ($r==7) {?>
          <p style="color:red;"> <?php echo "opération annulée !! veuillez activer le transfert automatique pour l'effectuer"; ?> </p> <?php }          
          else if ($r==8) { ?>
           <p style="color:blue;"> <?php echo "opération effectuée avec succès"; ?> </p> <?php }  
           else if ($r==9) { ?>
          <p style="color:red;"> <?php echo "Veuillez remplir le champs"; ?></p>
          <?php } ?>
         
         </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading"><spam id="pannel"> Lister les fichiers par date </spam></div>
      <div class="panel-body">
         <form method="get" action="ImportAuto.php" class="form-inline"> 
           <div class="form-group ">
          Date des fichier :
          <input type="date" name="nameFA" placeholder="année/mois/jour" class="form-control">
          </div>
          <div class="form-group margin2IM">
          <button type="submit" id="showL" name="lister" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"> </span> &nbsp Lister </button>
          </div>
        </form>
        <div class="alerteL">
          <?php if ($d==6) {?>
          <p style="color:red;"> <?php echo "Veuillez remplir le champs"; ?> </p> <?php } 
          else if ($d==7) {
          echo 'Date invalide ! Veuillez entrer une date valide inférieure à '.$today.'';
           }?>
         </div>
      </div>
    </div>
    <div class="panel panel-default ">
      <div class="panel-heading"><spam id="pannel"> Liste des fichier journaux importés </spam></div>
      <div class="panel-body">
      </br>
      <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Taper l'id que vous chercher.." title="id GAB">
     </br>
      <table class="table table-striped table-bordered">
      	<thead class="gray">
      	<tr>
      		<th>id ATM</th>
      		<th>Date</th>
          <th>Nom du fichier</th>
          <th>Date et heure d'importation</th>
      		<th>Fichier</th>
      	</tr>
      </thead>
      <tbody id="myTable">
      <?php
       while($row=mysqli_fetch_row($resultatA)) { ?>
         <tr>
            <td><?php echo $row[1] ?> </td>
            <td><?php echo $row[2] ?> </td>
            <?php $lastDay = $row[2];
             $lastDay = str_replace("-", "", $lastDay);?>
            <td><?php echo $lastDay.".jrn" ;?> </td>
            <td><?php echo $row[3] ?> </td>
            <td><a href="<?php echo ".$row[4]."?>" >Télécharger le fichier</a></td>
          </tr>
      <?php }?>
      </tbody>
      </table>

    </div> 
  </div>
</div>

<script>
$(document).ready(function(){
  $("#showA").click(function(){
    $("state").show();
    $("alerteA").show();
  });
  $("#showD").click(function(){
    $("state").show();
    $("alerteD").show();
  });
  $("#showP").click(function(){
    $("state").show();
    $("alerteP").show();
  });
  $("#showL").click(function(){
    $("state").show();
    $("alerteL").show();
  });
  });
</script>
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
</body>
</HTML>