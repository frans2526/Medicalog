<?php
	class Conf {
	
		static $debug = 1;

		static $databases = array(

			'default' => array(
			
				'host'      => 'localhost',
				'database'  => 'medicalog',
				'login'     => 'root',
				'password'  => ''

				)

			);

	}
	

	Routeur::prefix('cockpit','admin');
	Routeur::prefix('app','apps');

	Routeur::connect('','pages/view/2'); //cas ou la page 2 est la page principal

	Routeur::connect('app','app/dashboard/index');	
	Routeur::connect('cockpit','cockpit/pages/index');
	
	Routeur::connect('blog/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
	Routeur::connect('pages/:slug-:id','pages/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
	Routeur::connect('blog/*','posts/*');

?>