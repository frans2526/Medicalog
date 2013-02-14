<h2>Plan du site</h2>
<?php if(count($pages)==0){ echo '<p>Aucune page n\'est présente sur le site</p>';}else{ ?>
<h3>Page<?php echo (count($pages)==1)?'':'s'; ?> du site :</h3>
<ul>
	<?php foreach ($pages as $k => $v): ?>
		<li><a href="<?php echo Routeur::url('pages/'.$v->slug.'-'.$v->id); ?>"  title="<?php echo $v->title; ?>"><?php echo $v->title; ?></a></li>
	<?php endforeach; ?> 
</ul>
<?php } if(count($posts)==0){ echo '<p>Aucun article n\'est présent sur le site</p>';}else{  ?>
<h3>Article<?php echo (count($posts)==1)?'':'s'; ?> du <a href="<?php echo Routeur::url('blog/index'); ?>" title="Blog">Blog</a> :</h3>
<ul>
	<?php foreach ($posts as $k => $v): ?>
		<li><a href="<?php echo Routeur::url("posts/view/id:{$v->id}/slug:{$v->slug}"); ?>" title="<?php echo $v->title; ?>"><?php echo htmlentities($v->title, ENT_QUOTES, "UTF-8"); ?></a></li>
	<?php endforeach; ?> 
</ul>
<?php } ?>
<h3><a href="<?php echo Routeur::url('doctors/register'); ?>" title="S'enregistrer dans l'application">S'enregistrer dans l'application</a></h3>
<h3><a href="<?php echo Routeur::url('users/login'); ?>#formConnexion" title="Connexion à l'application">Connexion à l'application</a></h3>