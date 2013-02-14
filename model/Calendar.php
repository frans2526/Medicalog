<?php
	class Calendar extends Model{
		static $validate = array(
			'title' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser un titre'
			),
			'start' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser une date de début'
			),
			'end' => array(
				'rule'    => 'notEmpty',
				'message' => 'Vous devez préciser une date de fin'
			)
		);
	}
?>