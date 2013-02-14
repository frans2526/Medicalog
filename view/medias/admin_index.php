<table>
	<thead>
		<tr>
			<th>Image</th>
			<th>Titre</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($images as $k => $v): ?>
			<tr>
				<td>
					<a href="#" onclick="FileBrowserDialogue.sendURL('<?php echo Routeur::webroot('img/'.$v->file); ?>')">
						<img src="<?php echo Routeur::webroot('img/'.$v->file); ?>" alt="" height="90" widht="90">
					</a>
				</td>
				<td><?php echo $v->name; ?></td>
				<td>
					<a onclick="return confirm('Voulez vous vraiment supprimer cette image ?');" href="<?php echo Routeur::url('admin/medias/delete/'.$v->id.'/'.$v->file.'?t='.$_SESSION['token']) ?>">Supprimer</a>
				</td>
			</tr>
		<?php endforeach ?>		
	</tbody>
</table>
<hr />
<br />
<div class="page-header">
	<h1>Ajouter une image</h1>
</div>
<?php echo $this->Session->flash(); ?>
<form action="<?php echo Routeur::url('admin/medias/index/'.$post_id.'?t='.$_SESSION['token']); ?>" method="post" enctype="multipart/form-data">

	<?php echo $this->Form->input('file','Image',array('type' => 'file')); ?>	
	<?php echo $this->Form->input('name','Titre',array('placeholder' => 'Titre du média' ,'maxlength' => '100')); ?>	
	<div class="action">
		<input type="submit" name="" value="Envoyer" class="btn btn-primary">
	</div>
</form>