	<div class="content">
		<h1>Contacts</h1>
		<div class="navigation">
			<p class="previous"><a href="<?php echo Routeur::url('app/contacts/add'); ?>">Ajouter un contact</a></p>
		</div>
		<!-- <div class="searchContact">
			<form action="#" method="post" onsubmit="return false;"><input type="text" id="searchContactInput" name="searchContact" placeholder="Rechercher un contact" class="searchBar" onkeyup="searchContacts(this,document.getElementById('contactsListe'));"><input type="submit" value="Rechercher" id="searchContact" class="btnBleu"></form>
		</div> -->
		<div class="contacts">
			<ul id="contactsListe">
				<?php
				$check = '';
				if(count($contacts) == 0){
					echo '<p style="padding-top:40px;">Aucun contact enregistré</p>';
				}else{
					foreach ($contacts as $key => $value) {
						if(substr(strtolower($value->fName), 0,1) != $check){
							$check = substr(strtolower($value->fName), 0,1);
							echo '<h2>'.strtoupper($check).'</h2>';
						}
						echo '<li><a href="'.Routeur::url('app/contacts/show/'.$value->id.'').'">'.htmlentities($value->fName, ENT_QUOTES, "UTF-8").' '.htmlentities($value->lName, ENT_QUOTES, "UTF-8").'</a></li>';
					} 
				}
				?>
			</ul>
		</div>
	</div>