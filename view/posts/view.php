<?php $title_for_layout = $post->title; ?>
<p class="btn"><a href="<?php echo Routeur::url('blog'); ?>" title="Retour">Retour</a></p>
<article>
	<header><h2><?php echo htmlentities($post->title, ENT_QUOTES, "UTF-8"); ?></h2></header>
<?php
	echo $post->content; 
?>
<footer>
	<p>Publier le <?php echo $post->created; ?></p>
</footer>
</article>