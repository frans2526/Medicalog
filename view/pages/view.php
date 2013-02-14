<?php $title_for_layout = $page->title; ?>
<article>
	<header><h2><?php echo htmlentities($page->title, ENT_QUOTES, "UTF-8"); ?></h2></header>
		<?php echo $page->content; ?>
    <!-- <footer></footer> -->
</article>