<header class="titleBlog">
	<h2>Le Blog <small>suivez l'actualité de Medicalog</small></h2>
</header>
<?php $i=count($posts); foreach ($posts as $k => $v): ?>
		<article <?php echo $i==1?'>': 'class="blog">'; ?>
			<header><h2><a href="<?php echo Routeur::url("posts/view/id:{$v->id}/slug:{$v->slug}"); ?>"><?php echo htmlentities($v->title, ENT_QUOTES, "UTF-8"); ?></a></h2></header>
			<?php echo htmlentities($v->content, ENT_QUOTES, "UTF-8"); ?>
			<footer>
				<p><a href="<?php echo Routeur::url("posts/view/id:{$v->id}/slug:{$v->slug}"); ?>">Lire la suite &rarr;</a></p>
				<p>Publier le <?php echo $v->created; ?></p>
			</footer>
		</article>
<?php $i--; endforeach ?>
		<div class="pagination">
			<ul>
			<?php for($i=1; $i<=$page; $i++): ?>
				    <li<?php if($i == $this->request->page) echo ' class="active"'; ?>><a href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
				  <?php endfor; ?>
			</ul>
		</div>
