	<div class="content">
		<h1>Contacts</h1>
		<div class="navigation">
			<p class="previous"><a href="<?php echo Routeur::url('app/contacts/index'); ?>">Retour</a></p>
		</div>
		<div class="contacts">
			<h2>Ajouter un contact</h2>
			<form action="<?php echo Routeur::url('apps/contacts/add/'.$id.'?t='.$_SESSION['token']); ?>" method="post">
				<fieldset>
					<?php
					echo $this->Form->input('fName','Nom&nbsp;',array('placeholder' => 'Nom du contact','maxlength' => '85')); 
					echo $this->Form->input('lName','Prénom&nbsp;',array('placeholder' => 'Prénom du contact','maxlength' => '85'));
					echo $this->Form->input('mail','Mail&nbsp;',array('placeholder' => 'Mail du contact','maxlength' => '85')); 
					echo $this->Form->input('tel','Téléphone&nbsp;',array('placeholder' => 'Téléphone du contact','maxlength' => '85','type'=>'tel')); 
					echo $this->Form->input('mobile','Portable&nbsp;',array('placeholder' => 'Portable du contact','maxlength' => '85','type'=>'tel')); 
					echo $this->Form->input('other','Commentaire&nbsp;',array('type'=>'textarea','rows'=>'6'));
					?>
					<p><input type="submit" class="btnBleu"></p>
				</fieldset>
			</form>
		</div>
	</div>