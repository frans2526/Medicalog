<div class="page-header">
	<h1>Éditer un Utilisateur</h1>
</div>
<?php echo $this->Session->flash(); ?>
<form action="<?php echo Routeur::url('admin/users/edit/'.$id.''); ?>" method="post">
	<?php echo $this->Form->input('login','Login'); ?>
	<?php echo $this->Form->input('password','Password',array('type' => 'password')); ?>
    	<?php echo $this->Form->input('id','hidden'); ?>
	<div class="atcions">
		<input type="submit" class="btn primary" value="Enregistrer">
	</div>
</form>