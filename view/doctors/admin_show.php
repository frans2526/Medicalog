<div class="page-header">
	<h1>Visualiser un Docteur</h1>
</div>
<p style="text-align:right;"><a href="<?php echo Routeur::url('admin/doctors/index'); ?>" class="primary btn">Retour</a></p>
<?php echo $this->Session->flash(); ?>
<form action="#" method="get">
	<?php echo $this->Form->input('id','Id :&nbsp;',array('value' => $doctor->id,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('login','Login :&nbsp;',array('value' => $doctor->login,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('inamiCode','Code inami :&nbsp;',array('value' => $doctor->inamiCode,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('mail','Mail :&nbsp;',array('value' => $doctor->mail,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('phone','Téléphone :&nbsp;',array('value' => $doctor->phone,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('firstName','Prénom :&nbsp;',array('value' => $doctor->firstName,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('lastName','Nom :&nbsp;',array('value' => $doctor->lastName,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('dt_inscri','Inscription :&nbsp;',array('value' => $doctor->dt_inscri,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('dt_AbonNow','Abonnement début :&nbsp;',array('value' => $doctor->dt_AbonNow,'readonly' => 'readonly')); ?>
	<?php echo $this->Form->input('dt_AbonEnd','Abonnement fin :&nbsp;',array('value' => $doctor->dt_AbonEnd,'readonly' => 'readonly')); ?>
</form>