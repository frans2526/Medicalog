<ul>
<?php foreach ($posts as $k => $v): ?>

	<li>
		<a href="#" onclick="FileBrowserDialogue.sendURL('<?php echo addslashes(Routeur::url($v->type.'s/view/id:'.$v->id.'/slug:'.$v->slug)); ?>')"><?php echo ucfirst($v->type); ?> : <?php echo $v->title; ?>
		</a>
	</li>
	
<?php endforeach ?>
	<li>
		<a href="#" onclick="FileBrowserDialogue.sendURL('<?php echo addslashes(Routeur::url('doctors/register')); ?>')"><?php echo 'Doctor'; ?> : <?php echo 'Enregistrement'; ?>
		</a>
	</li>
</ul>