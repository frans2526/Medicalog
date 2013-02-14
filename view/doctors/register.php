<header><h2>Enregistrement au service Medicalog.be</h2></header>
<form action="<?php echo Routeur::url('doctors/register'); ?>" id="formRegister" method="post">
	<fieldset>
		<?php echo $this->Form->input('lastName','Nom *',array('autofocus' => 'autofocus', 'required' => 'required', 'placeholder' => 'Votre nom', 'maxlength' => '85')); ?>
		<?php echo $this->Form->input('firstName','Prénom *',array('required' => 'required', 'placeholder' => 'Votre prénom', 'maxlength' => '85')); ?>
		<?php echo $this->Form->input('inamiCode','Code Inami *',array('required' => 'required', 'placeholder' => 'Votre numéro Inami', 'pattern' => '^[0-9]{6}$')); ?>
		<?php echo $this->Form->input('mail','Email *',array('type' => 'email','required' => 'required', 'placeholder' => 'Votre email', 'maxlength' => '100', 'pattern' => '^([a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4})$')); ?>
		<?php echo $this->Form->input('phone','Téléphone',array('type'=>'tel','placeholder' => 'Votre téléphone', 'maxlength' => '50')); ?>
	</fieldset>
	<fieldset style="margin-top:30px;">
		<?php echo $this->Form->input('login','Identifiant *',array('required' => 'required', 'placeholder' => 'Votre identifiant', 'maxlength' => '85')); ?>
		<?php echo $this->Form->input('password','Mot de passe *',array('type' => 'password', 'required' => 'required', 'placeholder' => 'Votre mot de passe','size' => '30')); ?>
		<?php echo $this->Form->input('password2','Retapez votre mot de passe *',array('type' => 'password', 'required' => 'required', 'placeholder' => 'Retapez votre mot de passe','size' => '30')); ?>
		<p><button type="submit">S'enregistrer</button>&nbsp;<button type="reset">Effacer</button></p>
	</fieldset>
</form>