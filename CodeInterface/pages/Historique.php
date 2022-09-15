<?php

session_start();
if(isset($_SESSION['user']))
{
  require_once('connexion.php');
  if($_SESSION['user'][3]=="ADMIN")
  {
    $requete='select id_cmd, login, id_atm, file_date, datetime_add, time_import_auto, description from list_cmd inner join state_description on list_cmd.state = state_description.state';
    $resultatH=mysqli_query($con,$requete);
  }
  else if($_SESSION['user'][3]=="SUPERVISEUR")
  { 

    $userlogin=$_SESSION['user'][1];
    $requete='select id_cmd, login, id_atm, file_date, datetime_add, time_import_auto, description from list_cmd inner join state_description on list_cmd.state = state_description.state where login="'.$userlogin.'"';
    $resultatH=mysqli_query($con,$requete);
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
      <div class="panel-heading"><spam id="pannel"> Historique </spam></div>
      <div class="panel-body">
      <table class="table table-striped table-bordered">
      	<thead class="gray">
      	<tr>
      		<th>user</th>
      		<th>id ATM</th>
      		<th>date fichier</th>
          <th>Date et heure d'opération</th>
          <th>heure du transfert automatique</th>
          <th>Type d'opération</th>

      	</tr>
      </thead>
      <tbody>

        <?php while($row=mysqli_fetch_row($resultatH)){ ?>
         <tr>
            <td><?php echo $row[1] ;?> </td>
            <td><?php if ($row[2]==0){ echo "Tous les GABs";} else {echo $row[2];}?> </td>
            <td><?php echo $row[3] ;?> </td>
            <td><?php if ($row[4]=="0000-00-00"){ echo "-------";} else {echo $row[4];}?> </td> 
            <td><?php echo $row[5] ;?> </td>  
            <td><?php echo $row[6] ;?> </td>  


 
          </tr>
        <?php }?>
      </tbody>
      </table>
    </div>
</div>
</body>
</HTML>