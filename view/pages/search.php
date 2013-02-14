<?php  $title_for_layout = 'Recherche'; ?>
<article>
	<header>
		<h2><?php echo $title; ?></h2>
	</header>
		<ul>
			<?php 
			if(!empty($page)){
				foreach ($page as $key => $value) {
					echo '<li><a href="'.Routeur::url('pages/view/'.$value->id).'">'.$value->title.'</a></li>';
				}
			}else{
				echo '<p>Aucun résultat trouvé, mais vous pouvez utiliser <a href="'.Routeur::url('sitemap/index').'">le plan du site</a> pour vous aider dans vos recherches</p>';
			}
			
			?>
			

		</ul>
    <!-- <footer></footer> -->
</article>