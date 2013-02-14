<?php

// $debut = microtime(true);

date_default_timezone_set('Europe/Brussels');

define('WEBROOT',dirname(__FILE__));
define('ROOT',dirname(WEBROOT));
define('DS',DIRECTORY_SEPARATOR);
define('CORE',ROOT.DS.'core');
//define('BASE_URL',dirname(dirname($_SERVER['SCRIPT_NAME'])));
define('BASE_URL',str_replace('\\','',dirname(dirname($_SERVER['SCRIPT_NAME']))));

require CORE.DS.'includes.php';
new Dispatcher();

// echo '<div style="position:fixed;bottom:0; background:#900; color:#FFF; line-height:30px; height:30px; left:0; right:0; padding-left:10px; text-align:right;">';

// echo 'Page généré en '.round(microtime(true) - $debut, 6).' secondes</div>';
?>