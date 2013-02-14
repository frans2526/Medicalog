<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Medicalog.be Application Web</title>
	<meta charset="utf-8" />
	<link href="http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700" rel="stylesheet" type="text/css">
	<link href="<?php echo Routeur::webroot('css/Amethysta/Amethysta-Regular.ttf'); ?>" rel="application/x-font-ttf" type="text/css">
	<script type="text/javascript" src="<?php echo Routeur::webroot('js/jquery-1.7.1.min.js'); ?>"></script>
	<script src="<?php echo Routeur::webroot('js/jQueryUi.js'); ?>"></script>
	<script src="<?php echo Routeur::webroot('js/datePicker.js'); ?>"></script>
	<script src="<?php echo Routeur::webroot('js/mainApp.js'); ?>" defer="defer"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Routeur::webroot('css/styleApp.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo Routeur::webroot('css/datePicker.css'); ?>" />
	<meta name="viewport" content="initial-scale=0.8, maximum-scale=1, user-scalable=yes">
  	<meta name="viewport" content="width=device-width">
</head>
<body>
	<div class="top">
		<p>
			<img src="<?php echo Routeur::webroot('img/icons/32x32/DoctorMale.png'); ?>" alt="iconeDoctor">
			&nbsp;Bonjour&nbsp;<?php echo $_SESSION['Doctor']->firstName.' '.$_SESSION['Doctor']->lastName; ?>&nbsp;|&nbsp;
			<a href="<?php echo Routeur::url('doctors/logout'); ?>">Se&nbsp;déconnecter</a>
		</p>
		<p>
			&nbsp;|&nbsp;
			<?php echo ($this->request->controller == 'dashboard')? '' : '<a href="'.Routeur::url('app/dashboard').'">Dashboard</a> &nbsp;->&nbsp;'; 
			echo '<a href="">'.ucfirst($this->request->controller).'</a>';
			?>
		</p>
		<div class="search">
			<form action="<?php echo Routeur::url('app/patients/search'); ?>" method="post">
				<input type="text" class="searchBar" name="searchPatient"  placeholder="Rechercher un patient" />&nbsp;
				<button type="reset" class="reset" name="reset" title="Effacer">X</button>&nbsp;
				<button type="submit" class="reset" name="send" title="Rechercher">=></button>
			</form>
		</div>
	</div>
<div class="body">
	<!-- <div class="alert alert-success"><p>Le contact a bien été ajouter</p></div> -->
	<?php
		echo $this->Session->flash(); // a réglé
            		echo $content_for_layout; 
            ?>   
</div>
</html>