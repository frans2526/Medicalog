<div class="page-header">
	<h1>Éditer une Page</h1>
</div>
<?php echo $this->Session->flash(); ?>
<form action="<?php echo Routeur::url('admin/pages/edit/'.$id.'?t='.$_SESSION['token']); ?>" method="post" class="well">
	<?php echo $this->Form->input('title','Titre&nbsp;',array('placeholder' => 'Titre de la page', 'maxlength' => '85')); ?>
	<?php echo $this->Form->input('id','hidden'); ?>
    <div class="clearfix">
        <div class="input">
            <a class="btn" href="javascript:;" onclick="tinyMCE.execCommand('mceAddControl', false, 'inputcontent');"><span>Activer TinyMCE</span></a>
            <a class="btn" href="javascript:;" onclick="tinyMCE.execCommand('mceRemoveControl', false, 'inputcontent');"><span>Désactiver TinyMCE</span></a>
        </div>
    </div>
	<?php echo $this->Form->input('content','Contenu&nbsp;',array('type'=>'textarea','class' => 'xlarge wysiwyg', 'rows' => 7)); ?>
	<?php echo $this->Form->input('online','En ligne&nbsp;',array('type' => 'checkbox','style' => 'margin-top:10px;')); ?>
	<div class="atcions">
		<input type="submit" class="btn btn-primary" value="Enregistrer">
	</div>
</form>