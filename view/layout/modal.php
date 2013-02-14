<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title><?php echo isset($title_for_layout)?$title_for_layout:'Administration'; ?></title>
    <meta name="description" content="Pop-up pour insérer des médias">
    <meta name="author" content="Versmissen François">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="<?php echo Routeur::webroot('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
      }
      .container > footer p {
        text-align: center; /* center align it with the container */
      }
      .container {
        width: 480px; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
      }

      /* The white background content wrapper */
      .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

      /* Page header tweaks */
      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }

      /* Styles you shouldn't keep as they are for displaying this base example only */
      .content .span10,
      .content .span4 {
        min-height: 460px;
      }
      /* Give a quick and non-cross-browser friendly divider */
      .content .span4 {
        margin-left: 0;
        padding-left: 17px;
        border-left: 1px solid #eee;
      }

      .topbar .btn {
        border: 0;
      }

    </style>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo Routeur::webroot('css/images/favicon.ico'); ?>">
    <link rel="apple-touch-icon" href="<?php echo Routeur::webroot('css/images/touch-icon-iphone.png'); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Routeur::webroot('css/images/touch-icon-ipad.png'); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Routeur::webroot('css/images/touch-icon-iphone4.png'); ?>">
    <!-- <script type="text/javascript" src="<?php //echo Routeur::webroot('js/jquery-1.7.1.min.js'); ?>"></script> -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo Routeur::webroot('js/tinymce/tiny_mce_popup.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo Routeur::webroot('js/modal.js'); ?>"></script>
  </head>

  <body>
  <div class="container">
    <div class="content">
      <?php echo $content_for_layout; ?>
    </div>
  </div> <!-- /container -->
  </body>
</html>
