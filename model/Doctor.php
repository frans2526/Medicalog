<?php
	class Doctor extends Model{

		static $validate = array(
			'login' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un login'
			),
			'password' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un password'
			),
			'password2' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez retapez votre mot de passe'
			),
			'lastName' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un nom'
			),
			'firstName' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un prénom'
			),
			'inamiCode' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un code Inami',
				'rule' =>'([0-9]{6})',
				'message' => 'Doit être un nombre de 6 lettres'
			),
			'mail' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un email',
				'rule'    => '([a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4})',
				'message' => 'L\'email n\'est pas valide'
			)
		);
	}
?>