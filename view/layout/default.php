<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Medicalog.be</title>
  <meta charset="utf-8" />
  <meta name="description" content="Application pour les médecins généralistes belges souhaintant utiliser le cloud pour conserver leur patient et se faciliter la vie">
  <meta name="author" content="Versmissen François">
  <meta name="keywords" content="Medical,XXXXXXXX">
  <meta name="robots" content="all">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=yes">
  <!-- target-densitydpi=device-dpi -->
  <meta name="viewport" content="width=device-width">

  <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="<?php echo Routeur::webroot('css/style.css'); ?>" />
  <link rel="stylesheet" href="<?php echo Routeur::webroot('css/zoombox.css'); ?>" />
      <!--[if lte IE 7]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Routeur::webroot('css/styles-ie.css'); ?>" />
     <div class="alert-ie">
            <p><strong>Attention ! </strong> Votre navigateur (Internet Explorer 6, 7) présente de sérieuses lacunes en terme de sécurité et de performances, dues à son obsolescence.<br>En conséquence, ce site sera consultable mais de manière moins optimale qu'avec un navigateur récent (<a href="http://www.browserforthebetter.com/download.html">Internet Explorer 9+</a>, <a href="http://www.mozilla-europe.org/fr/firefox/">Firefox</a>, <a href="http://www.google.com/chrome?hl=fr">Chrome</a>, <a href="http://www.apple.com/fr/safari/download/">Safari</a>,...)</p>
    </div>
  <![endif]-->
  <link rel="shortcut icon" href="<?php echo Routeur::webroot('css/images/favicon.ico'); ?>" />
      <link rel="apple-touch-icon" href="<?php echo Routeur::webroot('css/images/touch-icon-iphone.png'); ?>" />
          <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Routeur::webroot('css/images/touch-icon-ipad.png'); ?>" />
      <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Routeur::webroot('css/images/touch-icon-iphone4.png'); ?>" />
  <script src="<?php echo Routeur::webroot('js/jquery-1.7.1.min.js'); ?>"></script>
  <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
  <script src="<?php echo Routeur::webroot('js/jquery.nivo.slider.pack.js'); ?>" defer="defer"></script>
  <script src="<?php echo Routeur::webroot('js/zoombox/zoombox.js'); ?>" defer="defer"></script>
  <script src="<?php echo Routeur::webroot('js/main.js'); ?>" defer="defer"></script>
</head>
<body>
  <h1 class="top"><a href="<?php echo Routeur::url('pages/accueil-2'); ?>" title="Accueil"><img src="<?php echo Routeur::webroot('css/images/Logo_MedicaLogB.png'); ?>" alt="logo" />MedicaLog</a></h1>
<div class="search"><form action="<?php echo Routeur::url('pages/search'); ?>" method="post"><input type="text" class="searchBar" name="search"  placeholder="Rechercher" />&nbsp;<button type="reset" class="reset" name="reset" title="Effacer">X</button>&nbsp;<button type="submit" class="reset" name="send" title="Rechercher">=></button></form></div>

<div class="body">
  <div id="slider" class="slider">
    <img src="<?php echo Routeur::webroot('img/slide/slideMedicaLogB.png'); ?>" alt="slide" />
    <img src="<?php echo Routeur::webroot('img/slide/jpeg.jpeg'); ?>" alt="photo1" />
    <img src="<?php echo Routeur::webroot('img/slide/jpeg-1.jpeg'); ?>" alt="photo2" />
  </div>
  <!-- W3C recommande d'attendre avant l'implémentation  de la balise menu ... -->
  <nav>
    <ul id="menu">
      <?php $pageMenu = $this->request('Pages','getMenu'); 
             foreach ($pageMenu as $p): ?>
              <li><a href="<?php echo Routeur::url('pages/'.$p->slug.'-'.$p->id); ?>" title="<?php echo $p->title; ?>"><?php echo $p->title; ?></a></li>
      <?php endforeach ?>
      <li><a href="<?php echo Routeur::url('users/login'); echo ($this->Session->isLogged() || $this->Session->isLoggedDoctor())?'':'#formConnexion'; ?>" 
              title="<?php if($this->Session->isLoggedDoctor()){
                echo 'Application';
              }elseif($this->Session->isLogged()){
                echo 'Administration';
              }else{
                echo 'Connexion';
              } ?>"><?php
              if($this->Session->isLoggedDoctor()){
                echo 'Application';
              }elseif($this->Session->isLogged()){
                echo 'Administration';
              }else{
                echo 'Connexion';
              }
              ?></a></li>
      <li><a href="<?php echo Routeur::url('posts/index'); ?>" title="Blog">Blog</a></li>
    </ul>
  </nav>
  <section>
     <?php
        // debug($_SESSION);

            echo $this->Session->flash();
            echo $content_for_layout; ?>      
  </section>
</div>
<footer class="footer"><p>Medicalog.be&copy; créé par <a href="http://www.francoisversmissen.eu" title="Site de François Versmissen">François Versmissen</a> | <a href="<?php echo Routeur::url('sitemap/index'); ?>">Plan du site</a> | Projet de fin d'étude EPFC&copy; 2011 - 2012</p></footer>
</html>