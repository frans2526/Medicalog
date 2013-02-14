<?php
	class Contact extends Model{
		static $validate = array(
			'fName' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un nom'
			),
			'lName' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un nom'
			)
		);
	}
?>