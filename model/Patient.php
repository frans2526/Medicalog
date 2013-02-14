<?php
	class Patient extends Model{
		static $validate = array(
			'name' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un nom'
			),
			'lastName' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un prénom'
			),
			'mutuelle' => array(
				'rule'    => '([0-9]{11})',
				'message' => 'Vous devez préciser un numéro mutuelle valide'
			)
		);
	}
?>