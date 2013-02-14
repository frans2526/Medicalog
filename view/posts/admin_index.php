<div class="page-header">
	<h1><?php echo ($total <= 1)?$total.' Article':$total.' Articles'; ?></h1>
</div>
<?php echo $this->Session->flash(); ?>
<p style="text-align:right;"><a href="<?php echo Routeur::url('admin/posts/edit'); ?>" class="btn btn-primary">Ajouter un article</a></p>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>En ligne ?</th>
			<th>Titre</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($posts as $k => $v): ?>
			<tr>
				<td><?php echo $v->id; ?></td>
				<td><span class="label label-<?php echo ($v->online == 1)? 'success':'important'; ?>"><?php echo ($v->online == 1)? 'En ligne':'Hors ligne' ?></span></td>
				<td><?php echo htmlentities($v->title, ENT_QUOTES, "UTF-8"); ?></td>
				<td>
					<a href="<?php echo Routeur::url('admin/posts/edit/'.$v->id) ?>" class="icon-pencil"></a>&nbsp;
					<a onclick="return confirm('Voulez vous vraiment supprimer ce contenu ?');" href="<?php echo Routeur::url('admin/posts/delete/'.$v->id.'?t='.$_SESSION['token']) ?>" class="icon-trash"></a>
				</td>
			</tr>
		<?php endforeach ?>		
	</tbody>
</table>
<div class="pagination">
	<ul>
	<?php for($i=1; $i<=$page; $i++): ?>
		<li<?php if($i == $this->request->page) echo ' class="active"'; ?>><a href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
    <?php endfor; ?>
    </ul>
</div>