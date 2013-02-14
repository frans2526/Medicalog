<div class="page-header">
	<h1><?php echo $total; ?> Utilisateurs</h1>
</div>

<?php echo $this->Session->flash(); ?>
<p style="text-align:right;"><a href="<?php echo Routeur::url('admin/users/edit'); ?>" class="primary btn">Ajouter un utilisateur</a></p>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Login</th>
			<th>Rôle</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($posts as $k => $v): ?>
			<tr>
				<td><?php echo $v->id; ?></td>
				<td><?php echo htmlspecialchars($v->login, ENT_QUOTES, "UTF-8"); ?></td>
				<td><span class="label label-<?php echo ($v->role == 'admin')? 'important':'success'; ?>"><?php echo htmlentities($v->role, ENT_QUOTES, "UTF-8"); ?></span></td>
				<td>
					<?php if($v->role == 'admin'){echo 'Impossible'; }else{ ?>
					<a onclick="return confirm('Voulez vous vraiment supprimer cet utilisateur ?');" href="<?php echo Routeur::url('admin/users/delete/'.$v->id) ?>">Supprimer</a>
					<?php } ?>
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