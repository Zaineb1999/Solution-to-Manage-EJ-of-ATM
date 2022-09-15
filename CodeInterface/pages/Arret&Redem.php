<?php 
session_start();
if(isset($_SESSION['user']))

{

$userlogin=$_SESSION['user'][1];
require_once("connexion.php");

$n=0;
$var="";
$r=0;
$d=0;
$a=0;
$p=0;
$s=0;


//Get hour of transfer auto

$requete='select heure from control_auto';
$result=mysqli_query($con,$requete);
$dateTr="";
while($rows=mysqli_fetch_row($result)) {
  $dateTr=$rows[0];
} 

//check state ATMs

$requete='select * from list_atm_confirmed where state=1';
$result=mysqli_query($con,$requete);
$num_rows=mysqli_num_rows($result);
if ($num_rows==0)
{
   $n=1; // connexion deactivated 
}


/*******Button show state of ATM********/

if(isset($_GET['etat']))
{
$n=0;
$a=0;
$d=0;
$p=0;
$s=0;
//check state ATMs
$requete='select * from list_atm_confirmed where state=1';
$result=mysqli_query($con,$requete);
$num_rows=mysqli_num_rows($result);
if ($num_rows==0)
{
  $n=1;
}
$idEG=isset($_GET['idEG'])?$_GET['idEG']:"";
if($idEG)
{ 
  $var=$idEG;
  $requete='select state from list_atm_confirmed where id_atm="'.$idEG.'"';
  $result=mysqli_query($con,$requete);
  if($result)
  {
    $num_rows=mysqli_num_rows($result);
    if($num_rows==0)
    {
      $r=5; // invalid id
    }
    else
    {
      while($rows=mysqli_fetch_row($result)) 
      {
        $stateATM=$rows[0];
      }
      $requete='insert into list_cmd values ("","",CURRENT_TIMESTAMP(),"'.$userlogin.'",13,"'.$idEG.'","'.$dateTr.'")';
      mysqli_query($con,$requete);
      if($stateATM==0)
      { // if activated
        $r=1; // ATM deactived
      }
      else
      {
        $r=2; //ATM activated
      }
    }
  }
  else
  {
    $r=3; //connexion error
  }
}
else 
{
  $r=4; //empty
}
}



/*******Button global deactivation of transfer ********/


else if(isset($_GET['Arret']))
{
  $a=0;
  $d=0;
  $r=0;
  $s=0;
  $requete='select state from list_atm_confirmed where state=1';
  $result=mysqli_query($con,$requete);
  $num_rows=mysqli_num_rows($result);

  if ($num_rows!=0)
  { // if activated
  $requete='insert into list_cmd values ("","",CURRENT_TIMESTAMP(),"'.$userlogin.'",11,0,"'.$dateTr.'")';
  mysqli_query($con,$requete);
  $requete='update list_atm_confirmed set state=0';
  $result=mysqli_query($con,$requete);
  if($result)
  {
    $p=1;
    if($n==0)
    {
      $n=1;
    }
  }
  else 
  {
    $p=2;
  }
}
  else
  {
    $p=3;
  }
}


/**********Button global activation of transfer **********/


else if(isset($_GET['Demarrage']))
{
  $a=0;
  $d=0;
  $p=0;
  $r=0;
  $requete='select state from list_atm_confirmed where state=0';
  $result=mysqli_query($con,$requete);
  $num_rows=mysqli_num_rows($result);
  if ($num_rows!=0)
  { // if active
  $requete='insert into list_cmd values ("","",CURRENT_TIMESTAMP(),"'.$userlogin.'",12,0,"'.$dateTr.'")';
  mysqli_query($con,$requete);
  $requete='update list_atm_confirmed set state=1';
  $result=mysqli_query($con,$requete);
  if($result)
  {
    $s=1;
    if($n==1)
    {
      $n=0;
    }
  }
  else 
  {
    $s=2;
  }
}
else
{
  $s=3;
}
}


/**********Button deactivation of an ATM***********/


else if(isset($_GET['desactivation']))
{
  $a=0;
  $r=0;
  $p=0;
  $s=0;
  $idAR=isset($_GET['idAR'])?$_GET['idAR']:"";
  if($idAR)
  {
    $var=$idAR;
    $requete='select state from list_atm_confirmed where id_atm="'.$idAR.'"';
    $result=mysqli_query($con,$requete);
    $num_rows=mysqli_num_rows($result);
    if($num_rows==0)
    {
      $d=13; // id invalid
    }
    else
    { // id valid
      while($rows=mysqli_fetch_row($result)){
        $stateATM=$rows[0];
      }
      if($stateATM==1)
      { // if activated   
        $requete='insert into list_cmd values ("","",CURRENT_TIMESTAMP(),"'.$userlogin.'",11,0,"'.$dateTr.'")';
        mysqli_query($con,$requete);
        $requete='update list_atm_confirmed set state=0 where id_atm="'.$idAR.'"';
        $result=mysqli_query($con,$requete);
        if($result)
        {
          $d=6;
        //check state ATMs
          $n=0;
          $requete='select * from list_atm_confirmed where state=1';
          $result=mysqli_query($con,$requete);
          $num_rows=mysqli_num_rows($result);
          if ($num_rows==0)
          {
   $n=1; //successfully completed
 }
}
else
{
      $d=7; //connexion error
    }
  }
  else
  {
      $d=12; //ATM already deactivated
    }
  }
}
else 
{
      $d=11; //empty
    }
  }


/********Button activation of an ATM**********/


else if(isset($_POST['activation']))
{
    $r=0;
    $d=0;
    $p=0;
    $s=0;
    $idDE=isset($_POST['idDE'])?$_POST['idDE']:"";
    if($idDE)
    {
      $var=$idDE;
      $requete='select state from list_atm_confirmed where id_atm="'.$idDE.'"';
      $result=mysqli_query($con,$requete);
      $num_rows=mysqli_num_rows($result);
      if($num_rows==0)
      {
      $a=12; // id invalid
    }
    else
    {
      while($rows=mysqli_fetch_row($result)) 
      {
        $stateATM=$rows[0];
      } 
    if($stateATM==0)
    { // if deactivated
      $requete='insert into list_cmd values ("","",CURRENT_TIMESTAMP(),"'.$userlogin.'",11,0,"'.$dateTr.'")';
      mysqli_query($con,$requete);
      $requete='update list_atm_confirmed set state=1 where id_atm="'.$idDE.'"';
      $result=mysqli_query($con,$requete);
      if($result)
      {
       $a=8; //successfully completed
      //check state ATMs
      $n=0;
      $requete='select * from list_atm_confirmed where state=1';
      $result=mysqli_query($con,$requete);
      $num_rows=mysqli_num_rows($result);
      if ($num_rows==0)
      {
        $n=1;
     }
    }
    else 
    {
      $a=9; //connexion error
    }
  }
  else
  {
    $a=11; //ATM already activated
  }
  }
}
else 
{
      $a=10; //empty
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
      <?php if ($n==0) {?> 
        <p style="background-color:017329;color:white;height:50px;font-size:30px;text-align: center"> <?php echo "Connection activée"; ?> </p>
      <?php } else if ($n==1) {?>
        <p style="background-color:A91205;color:white;height:50px;font-size:30px;text-align: center"> <?php echo "Connexion désactivée"; }?> </p>
      </div>
    </br>
    <div class="panel panel-default">
      <div class="panel-heading"><spam id="pannel"> Etat GAB </spam></div>
      <div class="panel-body">
        <div class="stop">
          <form method="get" action="Arret&Redem.php" class="form-inline">
            <div class="form-group">
              id ATM : 
              <input type="number" name="idEG" placeholder="Taper l'id du terminal" class="form-control">
            </div> 
            <div class="form-group margin2IM">
              <button type="submit" class="btn btn-success" id="hideEG" name="etat"><span class="glyphicon glyphicon-ok"> </span> &nbspafficher l'état </button>
            </div>
          </form>
        </div>
        <div class="alerteEG">
         <?php if ($r==1) {
          echo 'transfert désactivé pour ATM '.$var.'';
        }
        else if ($r==2) {
          echo 'transfert activé pour ATM '.$var.'';
        } 
        else if ($r==3) {
          echo "erreur de connexion! veuillez réessayer plus tard";
        } 
        else if ($r==4) {
          echo "champs vide ! veuillez remplir le champs";
        }
        else if ($r==5) {
          echo 'id GAB '.$var.' invalide ! Veuillez entrer un id valide';
        }?>
      </div>
    </div>
  </div> 
  <div class="panel panel-danger">
    <div class="panel-heading"><spam id="pannel"> Désactivation</spam></div>
    <div class="panel-body">
      <div class="stop">
       <form method="get" action="Arret&Redem.php" class="form-inline">
        <div class="form-group">
          id ATM : 
          <input type="number" name="idAR" placeholder="Taper l'id du terminal" class="form-control">
        </div> 
        <div class="form-group margin2IM">
          <button type="submit" class="btn btn-danger" id="hide" name="desactivation">
            <span class="glyphicon glyphicon-remove"></span> &nbspDésactiver la connexion </button>
          </div>
        </form>
      </div>
      <div class="alerteS">
       <?php if ($d==6) {
        echo 'Désactivation réussite pour ATM '.$var.'';
      }
      else if ($d==7) {
        echo "erreur de connexion! veuillez réessayer plus tard";
      } 
      else if ($d==11) {
        echo "champs vide ! veuillez remplir le champs";
      }
      else if ($d==12) {
        echo 'Le GAB '.$var.' est déjà désactivé';
      }
      else if ($d==13) {
        echo 'id GAB '.$var.' invalide ! Veuillez entrer un id valide';
      }?>
    </div>
  </div>
</div>          

<div class="panel panel-danger">
  <div class="panel-heading"><spam id="pannel"> Désactivation totale </spam></div>
  <div class="panel-body">
    <div class="stopT">
      <form method="get" action="Arret&Redem.php" class="form-inline">
        <div class="form-group">
          <input type="hidden" name="Arret" value="arret" />
          <button type="submit" class="btn btn-danger" id="hideT" onclick="return confirm('Etes-vous sûr ?')"><span class="glyphicon glyphicon-remove"> </span> &nbspDésactiver </button>
        </div>
      </form>
    </div>

    <div class="alerteST">
     <?php if ($p==1) {
      echo "Désactivation totale réussite";
    }
    else if ($p==2) {
      echo "erreur de connexion! veuillez réessayer plus tard";
    }
    else if ($p==3) {
      echo "La connexion est déjà désactivée";
    } ?>
  </div>
</div>
</div>


<div class="panel panel-success ">
  <div class="panel-heading"><spam id="pannel"> Activation</spam></div>
  <div class="panel-body">
    <div class="start">
      <form method="post" action="Arret&Redem.php" class="form-inline">
        <div class="form-group">
          id ATM : 
          <input type="number" name="idDE" placeholder="Taper l'id du terminal" class="form-control">
        </div> 
        <div class="form-group ">
          <button type="submit" class="btn btn-success" id="hideA" name="activation" >
          </span> &nbspActiver la connection </button>
        </div>
      </form>
    </div>
    <div class="alerteA">
     <?php if ($a==8) {
      echo 'Activation réussite pour ATM '.$var.'';
    }
    else if ($a==9) {
      echo "erreur de connexion! veuillez réessayer plus tard";
    } 
    else if ($a==10) {
      echo "Champs vide ! veuillez remplir le champs";
    }
    else if ($a==11) {
      echo 'Le GAB '.$var.' est déjà activé';
    }
    else if ($a==12) {
      echo 'id GAB '.$var.' invalide ! Veuillez entrer un id valide';
    }?>
  </div>
</div>
</div>

<div class="panel panel-success">
  <div class="panel-heading"><spam id="pannel"> Activation totale </spam></div>
  <div class="panel-body">
    <div classs="startT">
     <form method="get" action="Arret&Redem.php" class="form-inline">
      <div class="form-group ">
        <input type="hidden" name="Demarrage" value="Demarrage" />
        <button type="submit" class="btn btn-success" id="hideAT" onclick="return confirm('Etes-vous sûr ?')"><span class="glyphicon glyphicon-ok"> </span> &nbspActiver </button>
      </div>
    </form></div>
    <div class="alerteAT">
     <?php if ($s==1) {
      echo "Activation totale réussite";
    }
    else if ($s==2) {
      echo "erreur de connexion! veuillez réessayer plus tard";
    }
    else if ($s==3) {
      echo "La connexion est déjà activée";
    } ?>
  </div>
</div>
</div>
<script>
  $(document).ready(function(){
    $("#hideEG").click(function(){
      $("state").show();
      $("alerteEG").show();
      $("#hide").click(function(){
        $("state").show();
        $("alerteS").show();
      });
      $("#hideA").click(function(){
        $("state").show();
        $("alerteA").show();
      });
      $("#hideT").click(function(){
        $("state").show();
        $("alerteST").show();
      });
      $("#hideAT").click(function(){
        $("state").hide();
        $("alerteAT").show();

      });
    });
  </script>


</body>

</HTML>