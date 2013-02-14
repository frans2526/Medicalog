<form action="<?php echo Routeur::url('users/login'); ?>" id="formConnexion" method="post">
	<fieldset>
		<?php echo $this->Form->input('login','Identifiant',array('autofocus' => 'autofocus', 'required' => 'required', 'placeholder' => 'Votre identifiant')); ?>
		<?php echo $this->Form->input('password','Mot de passe',array('type' => 'password', 'required' => 'required', 'placeholder' => 'Votre mot de passe')); ?>
		<p><a href="<?php echo Routeur::url('doctors/register'); ?>" title="Pas encore inscrit ?">Pas encore inscrit ?</a></p>
		<p><button type="submit">Se&nbsp;connecter</button>&nbsp;<button type="reset">Effacer</button></p>
	</fieldset>
</form>