	<div class="content">
		<h1>Patients</h1>
		<div class="navigation">
			<p class="previous"><a href="<?php echo Routeur::url('app/patients/edit'); ?>">Ajouter un patient</a></p>
		</div>
		<!-- <div class="searchContact">
			<form action="#" method="post" onsubmit="return false;"><input type="text" id="searchContactInput" name="searchContact" placeholder="Rechercher un contact" class="searchBar" onkeyup="searchContacts(this,document.getElementById('contactsListe'));"><input type="submit" value="Rechercher" id="searchContact" class="btnBleu"></form>
		</div> -->
		<div class="contacts">
			<ul id="patientsListe">
				<?php
				$check = '';

				if(count($patients) == 0){
					echo '<p style="padding-top:40px;">Aucun résultat trouvé</p>';
				}else{
					foreach ($patients as $key => $value) {
						if(substr(strtolower($value->name), 0,1) != $check){
							$check = substr(strtolower($value->name), 0,1);
							echo '<h2>'.strtoupper($check).'</h2>';
						}
						echo '<li><a href="'.Routeur::url('app/patients/edit/'.$value->patientId.'').'">'.htmlentities($value->name, ENT_QUOTES, "UTF-8").' '.htmlentities($value->lastName, ENT_QUOTES, "UTF-8").'</a></li>';
					} 
				}
				
				?>
			</ul>
		</div>
	</div>