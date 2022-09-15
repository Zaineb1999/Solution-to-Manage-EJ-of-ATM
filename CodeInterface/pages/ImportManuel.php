<?php
 
session_start();
if(isset($_SESSION['user']))
{
$userlogin=$_SESSION['user'][1];
require_once('connexion.php');

//Get yesterday's date

$lastDay=date('Y-m-d',strtotime("-1 days"));

//Get today's date 

$today=date('Y-m-d');

//Get hour of auto transfer 

$requete='select heure from control_auto';
$result=mysqli_query($con,$requete);
while($rows=mysqli_fetch_row($result)) 
{
  $dateTr=$rows[0];
}

$n=0;

/**********Button search*********/

if (isset($_GET['BRName']))
{
$idATM=isset($_GET['idATM'])?$_GET['idATM']:"";
$dateF=isset($_GET['dateF'])?$_GET['dateF']:"";
if($idATM && $dateF)
{
  $time1= strtotime($dateF);
  $time2= strtotime($today);
  $requete='select id_atm from list_atm_confirmed where id_atm="'.$idATM.'"';
  $result=mysqli_query($con,$requete);
  $num_rows=mysqli_num_rows($result);
  if($time1>$time2 || $num_rows==0)
  { 
    $n=8; //invalid data
  }
  else
  {
    $requete='select id_atm, file_date, datetime_add, file from import_manuel where id_atm="'.$idATM.'" and file_date="'.$dateF.'" ';
    $resultatM=mysqli_query($con,$requete);
    $num_rows=mysqli_num_rows($resultatM);
    if ($num_rows==0)
    {
      $n=6;
      $requete='insert into list_cmd values ("","'.$dateF.'",CURRENT_TIMESTAMP(),"'.$userlogin.'",5,'.$idATM.',"'.$dateTr.'")';
      mysqli_query($con,$requete);
    }
    else
    {
      $n=1;
      $requete='insert into list_cmd values ("","'.$dateF.'",CURRENT_TIMESTAMP(),"'.$userlogin.'",8,'.$idATM.',"'.$dateTr.'")';
      mysqli_query($con,$requete);   
        }
      }
    }
    else 
    {
     $n=5; // empty
}
}

/*************Button import***********/


else if (isset($_GET['BIName']))
{
  $idATMI=isset($_GET['idATMI'])?$_GET['idATMI']:"";
  $dateFI=isset($_GET['dateFI'])?$_GET['dateFI']:"";
  if($idATMI && $dateFI)
  {
  $time1= strtotime($dateFI);
  $time2= strtotime($today);
  $requete='select id_atm from list_atm_confirmed where id_atm="'.$idATMI.'"';
  $result=mysqli_query($con,$requete);
  $num_rows=mysqli_num_rows($result);
  if($time1>$time2 || $num_rows==0)
  {
    $n=9; //invalid data
  }
  else
  {
    $requete='select id_atm from list_atm_confirmed where id_atm="'.$idATMI.'" and state=1';
    $result=mysqli_query($con,$requete);
    $num_rows=mysqli_num_rows($result);
    if ($num_rows!=0)
    { 
    $requete='select id from import_manuel where id_atm="'.$idATMI.'" and file_date="'.$dateFI.'" ';
    $result=mysqli_query($con,$requete);
    $num_rows1=mysqli_num_rows($result);
    if ($num_rows1==0)
    {
      $requete='insert into list_cmd values ("","'.$dateFI.'",CURRENT_TIMESTAMP(),"'.$userlogin.'",2,'.$idATMI.',"'.$dateTr.'")';
      mysqli_query($con,$requete);
      $n=2; //import request
    }
    else 
    {
      $requete='insert into list_cmd values ("","'.$dateFI.'",CURRENT_TIMESTAMP(),"'.$userlogin.'",3,'.$idATMI.',"'.$dateTr.'")';
      mysqli_query($con,$requete);
    $n=3; //already imported
    }
  }
  else 
  { 
    $n=7;// connexion of GAB deactivated 
  }
}
}
else
{
  $n=4; // empty
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
	<div class="container">
	<div class="panel panel-default margin1">
      <div class="panel-heading"><spam id="pannel"> Consultation d'un fichier journal spécifique </spam></div>
      <div class="panel-body">
        <form method="get" action="ImportManuel.php" class="form-inline">
          <div class="form-group">
          id ATM : 
          <input type="number" name="idATM" placeholder="Taper l'id du terminal" class="form-control">
          </div> 
          <div class="form-group margin2IM">
          Date du fichier :
          <input type="date" name="dateF" placeholder="Taper la date du fichier" class="form-control">
          </div>
          <div class="form-group margin2IM">
          <button type="submit" class="btn btn-primary" id="showR" name="BRName"><span class="glyphicon glyphicon-search"> </span> &nbsp Rechercher </button>
          </div>
        </form>
        <div class="alerteR">
         <?php if ($n==5) {?>
          <p style="color:red;"> <?php echo "Veuillez remplir les deux champs";?></p> 
          <?php }
          else if ($n==6){?>
          <p style="color:red;"> <?php echo "Fichier non trouvé ! Veuillez l'importer";?></p> 
          <?php } else if ($n==8){?>
          <p style="color:red;"> <?php echo "Données invalides";?></p> <?php }?>
      </div>
    </div>
  </div>
    <div class="panel panel-default">
      <div class="panel-heading"><spam id="pannel"> Importation d'un fichier journal spécifique </spam></div>
      <div class="panel-body">
        <form method="get" action="ImportManuel.php" class="form-inline">
          <div class="form-group">
          id ATM : 
          <input type="number" name="idATMI" placeholder="Taper l'id du terminal" class="form-control">
          </div> 
          <div class="form-group margin2IM">
          Date du fichier :
          <input type="date" name="dateFI" placeholder="Taper la date du fichier" class="form-control">
          </div>
          <div class="form-group margin2IM">
          <button type="submit" class="btn btn-success" id="showI" name="BIName"><span class="glyphicon glyphicon-plus"> </span> &nbsp Importer </button>
          </div>
        </form>
        <div class="alerteI">
         <?php if ($n==2) {?>
          <p style="color:blue;"> <?php echo "Demande d'importation"; ?> </p> <?php }          
          else if ($n==3) { ?>
           <p style="color:blue;"> <?php echo "Fichier déjà importé ! Veuillez le lister"; ?> </p> <?php }
           else if ($n==7) { ?>
           <p style="color:blue;"> <?php echo "Opération annulée ! GAB arrêté"; ?> </p> <?php }  
           else if ($n==4) { ?>
          <p style="color:red;"> <?php echo "Veuillez remplir les deux champs"; ?></p>
          <?php } 
          else if ($n==9){?>
          <p style="color:red;"> <?php echo "Données invalides";?></p> <?php }?>
         </div>
      </div>
    </div>    
      
        <?php if ($n==1){?>
          <div class="panel panel-default ">
          <div class="panel-heading"><spam id="pannel"> fichiers </spam></div>

       <div class="panel-body">
         <tbody>
          <table class="table table-striped table-bordered">
        <thead class="gray">
        <tr>
          <th>id ATM</th>
          <th>date du fichier</th>
          <th>nom du fichier</th>
          <th>Date et heure d'importation</th>
          <th>fichier</th>
        </tr>
      </thead> 
        <?php while($row=mysqli_fetch_row($resultatM)){ ?>
         <tr>
            <td><?php echo $row[0]; ?> </td>
            <td><?php echo $row[1] ;?> </td>
            <?php $filename = str_replace("-", "", $row[1]);?>
            <?php $filenameF =$filename.".jrn";?>
            <td><?php echo $filenameF ;?> </td>
            <td><?php echo $row[2]; ?> </td>
            <td><a href="telecharger.php?file=<?php echo $row[3]?>&filename=<?php echo $filenameF?>">Télécharger le fichier</a></td>
 
          </tr>
        <?php }}?>
      </tbody>
      </table>
    </div>
</div>

</div>
    
</body>
<script>
$(document).ready(function(){
  $("#showI").click(function(){
    $("alerteI").show();
  });
$(document).ready(function(){
  $("#showR").click(function(){
    $("alerteR").show();
  });
  });
</script>


</HTML>