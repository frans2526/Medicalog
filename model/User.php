<?php
	class User extends Model{


		static $validate = array(
			'login' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un login'
			),
			'password' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un password'
			)

		);
	}
?>