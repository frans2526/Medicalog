<?php
	//mettre la function parseDate ici
	class Date {

		public $days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
		public $months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

		/*
		* @param Int $year
		* @return Array des mois des semaine et des jours de l'année passé en param
		*/
		function getAll($year){
			$r = array();
			$date = new DateTime($year.'-01-01');
			while ($date->format('Y') <= $year) {
				$y = $date->format('Y');
				$m = $date->format('n');
				$d = $date->format('j');
				$w = $date->format('N');
				$r[$y][$m][$d] = $w;
				$date->add(new DateInterval('P1D'));
			}
			return $r;
		}

		/**
		* @param : String $date
		* @param : String $format de $date 
		* @param : String retour en ATOM
		* @return : String
		**/
		static function parseDateToFormatMysql($date, $format,$atom = null){
			$date = date_parse_from_format($format, $date);
			if($date['day'] < 10){
				$date['day'] = '0'.$date['day'];
			}
			if($date['month'] < 10){
				$date['month'] = '0'.$date['month'];
			}
			if($date['hour'] < 10){
				$date['hour'] = '0'.$date['hour'];
			}
			if($date['minute'] < 10){
				$date['minute'] = '0'.$date['minute'];
			}
			if($date['second'] < 10){
				$date['second'] = '0'.$date['second'];
			}

			if ($atom = 'ATOM') {
				return date(DATE_ATOM, mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']));
			}
			return $date['year'].'-'.$date['month'].'-'.$date['day'].' '.$date['hour'].':'.$date['minute'].':'.$date['second'];
		}

		/**
		* @param : String $date (Y-m-d H:i:s)
		* @return : String d/m/Y H"h"i
		**/
		static function formaterDate($date){
			$date = date_parse_from_format('Y-m-d H:i:s', $date);
			if($date['day'] < 10){
				$date['day'] = '0'.$date['day'];
			}
			if($date['month'] < 10){
				$date['month'] = '0'.$date['month'];
			}
			if($date['hour'] < 10){
				$date['hour'] = '0'.$date['hour'];
			}
			if($date['minute'] < 10){
				$date['minute'] = '0'.$date['minute'];
			}
			return $date['day'].'/'.$date['month'].'/'.$date['year'].' à '.$date['hour'].'h'.$date['minute'];
		}
	}
?>