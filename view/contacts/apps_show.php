	<div class="content">
		<h1>Contacts</h1>
		<div class="navigation">
			<p class="previous"><a href="<?php echo Routeur::url('app/contacts/index'); ?>" title="Retour vers Contacts">Retour</a></p>
		</div>
		<div class="contacts">
			<h2><?php echo $contact->fName.' '.$contact->lName; ?></h2>
			<form action="<?php echo Routeur::url('app/contacts/add/'.$contact->id.'?t='.$_SESSION['token']); ?>" method="post">
				<fieldset>
					<?php
					echo $this->Form->input('fName','Nom&nbsp;',array('value' => $contact->fName,'maxlength' => '85')); 
					echo $this->Form->input('lName','Prénom&nbsp;',array('value' => $contact->lName,'maxlength' => '85'));
					echo $this->Form->input('mail','Mail&nbsp;',array('value' => $contact->mail,'maxlength' => '85')); 
					echo $this->Form->input('tel','Téléphone&nbsp;',array('value' =>$contact->tel,'maxlength' => '85','type'=>'tel')); 
					echo $this->Form->input('mobile','Portable&nbsp;',array('value' => $contact->mobile,'maxlength' => '85','type'=>'tel'));
					?>
					<p><label>Commentaire :</label></p>
					<p><textarea id="inputother" name="other" rows="6"><?php echo $contact->other; ?></textarea></p>
					<p><input type="submit" class="btnBleu" value="Enregistrer"> &nbsp;<a onclick="return confirm('Voulez vous vraiment supprimer ce contact ?');" href="<?php echo Routeur::url('app/contacts/delete/'.$contact->id.'?t='.$_SESSION['token']) ?>" title="Supprimer le contact" class="btnBleuBis">Supprimer</a></p>
				</fieldset>
			</form>
		</div>
	</div>