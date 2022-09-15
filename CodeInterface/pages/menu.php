<?php
require_once('identifier.php');
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
    <div class="navbar-header">
    	<div class="navbar-brand"><img src="../images/Logo.png" alt="logo" width="100" height="78"></div>
    </div>

    <ul class="nav navbar-nav">
		<li><a href="Home.php">Accueil</a></li>
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Import <span class="caret"></span></a>
			<ul class="dropdown-menu">
		        <li><a href="ImportManuel.php">Import manuel</a></li>
		        <li><a href="ImportAuto.php">Import auto</a></li>
			</ul>
		</li>
		<li><a href="Arret&Redem.php">Activation&désactivation</a></li>
		<li><a href="Historique.php">Historique</a></li>
		<?php if ($_SESSION['user'][3]=="ADMIN") {?>
		<li><a href="utilisateurs.php">Utilisateurs</a></li>
	<?php } ?>
	</ul>
	<ul class="nav navbar-nav navbar-right">
					
			<li>
				<a href="editerUtilisateur.php?idUser=<?php echo $_SESSION['user'][0] ?>"><i class="glyphicon glyphicon-user"></i><?php echo  ' '.$_SESSION['user'][1]?>
				</a> 
			</li>
			
			<li>
				<a href="seDeconnecter.php"><i class="glyphicon glyphicon-log-out"></i>&nbsp Se déconnecter</a>
			</li>
							
		</ul>
    </div>
</nav>