<div class="page-header">
	<h1><?php echo ($total <= 1)?$total.' Docteur':$total.' Docteurs'; ?></h1>
</div>
<?php echo $this->Session->flash(); ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Code inami</th>
			<th>Date Inscriptions</th>
			<th>Détails</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($doctors as $k => $v): ?>
			<tr>
				<td><?php echo $v->id; ?></td>
				<td><?php echo htmlentities($v->lastName, ENT_QUOTES, "UTF-8").' '.htmlentities($v->firstName, ENT_QUOTES, "UTF-8"); ?></td>
				<td><?php echo $v->inamiCode; ?></td>
				<td><?php echo $v->dt_inscri; ?></td>
				<td><a href="<?php echo Routeur::url('admin/doctors/show/'.$v->id); ?>">Plus d'infos</a></td>
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