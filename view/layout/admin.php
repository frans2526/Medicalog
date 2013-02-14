<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title><?php echo isset($title_for_layout)?$title_for_layout:'Administration'; ?></title>
    <meta name="description" content="Panneau d'administration de Medicalog.be">
    <meta name="author" content="Versmissen François">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=yes">
    <!-- target-densitydpi=device-dpi -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="<?php echo Routeur::webroot('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo Routeur::webroot('css/bootstrap-responsive.min.css'); ?>" rel="stylesheet">
    <style>
        .container > .row{
            margin-top: 4%;
        }
        footer{
            text-align:center;
            border-top:1px solid #DDD;
            padding-top: 16px;
        }
    </style>
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo Routeur::webroot('css/images/favicon.ico'); ?>">
    <link rel="apple-touch-icon" href="<?php echo Routeur::webroot('css/images/touch-icon-iphone.png'); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Routeur::webroot('css/images/touch-icon-ipad.png'); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Routeur::webroot('css/images/touch-icon-iphone4.png'); ?>">
    <script type="text/javascript" src="<?php echo Routeur::webroot('js/jquery-1.7.1.min.js'); ?>"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
    <script src="<?php echo Routeur::webroot('js/bootstrap.min.js'); ?>" defer="defer"></script>
    <?php if($this->request->action != 'index'){ ?>
        <script src="<?php echo Routeur::webroot('js/tinymce/tiny_mce.js'); ?>" defer="defer"></script>
        <script src="<?php echo Routeur::webroot('js/mainAdmin.js'); ?>" defer="defer"></script>
        <script async="async">
        
        //<![CDATA[
           function fileBrowser(field_name, url, type, win){
                 if(type == 'file'){
                    var explorer ='<?php echo Routeur::url('admin/pages/tinymce'); ?>';
                }else{
                    var explorer ='<?php echo Routeur::url('admin/medias/index/'.$id); ?>';
                }
            tinyMCE.activeEditor.windowManager.open({
              file : explorer,
              title : 'Gallerie',
              width : 540,
              height : 420,
              resizable : "yes",
              inline : "yes",
              close_previous : "no"
            },{
              window : win,
              input : field_name
            });
            return false;
        }
        //]]>
        </script>
   <?php }?>
  </head>
  <body>
   <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo Routeur::url('admin/pages/index'); ?>">Administration</a>
          <div class="nav-collapse">
             <ul class="nav">
                  <li><a href="<?php echo Routeur::url('admin/posts/index'); ?>" title="">Articles</a></li>
                  <li><a href="<?php echo Routeur::url('admin/pages/index'); ?>" title="">Pages</a></li>
                  <li><a href="<?php echo Routeur::url('admin/doctors/index'); ?>" title="">Docteurs</a></li>
                  <li><a href="<?php echo Routeur::url(''); ?>" title="">Vers le site</a></li>
             </ul>
         </div>
          <div class="btn-group pull-right">
             <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php echo $_SESSION['User']->login; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- <li><a href="#">Profile</a></li> -->
              <!-- <li class="divider"></li> -->
              <li><a href="<?php echo Routeur::url('users/logout'); ?>" title="Se déconnecter">Se déconnecter</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="span12">
      <!-- <div class="content"> -->
            <?php //debug($this->request->controller); die(); ?>
            <?php echo $content_for_layout; ?>
      <!-- </div> -->
            </div>
        </div>
      <footer>
        <p>&copy; Versmissen François 2011 - <?php echo date('Y'); ?><br />Design by <a href="http://twitter.github.com/bootstrap/">Twitter Bootstrap</a></p>
      </footer>
    </div> <!-- /container -->
  </body>
</html>
