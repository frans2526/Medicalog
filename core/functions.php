<?php
	function debug($var,$dump = false){
		if(Conf::$debug > 0){
			$debug = debug_backtrace();
			echo '<p>&nbsp;</p><p><a href="#" onclick="$(this).parent().next(\'ol\').slideToggle(); return false;"><strong>'.$debug[0]['file'].'</strong> ligne :'.$debug[0]['line'].'</a></p>';
			echo '<ol style="display:none;">';
			foreach ($debug as $k => $v) {
				echo '<li><strong>'.$v['file'].'</strong> ligne :'.$v['line'].'</li>';
			}
			echo '</ol>';
			echo '<pre>';
			if($dump)
				var_dump($var);
			else
				print_r($var);
			echo '</pre>';
		}

	}

	function creerSlug($slug){
		$caractereInterdit = array('\\', ';', ',','?','(',')','=','+','-','!','^','%','@','#','"','&','§','<','>','$','*','€','.','/','\'');
		$caractereAChanger =  array('é' => 'e', 'à' => 'a', 'ç' => 'c', 'è' => 'e','ù' => 'u','â' => 'a', 'ê' =>'e', 'ä' => 'a', 'ö' => 'o', 'ë' => 'e', 'ô' => 'o','î'=>'i', 'ï'=>'i','û' => 'u', 'ü'=>'u');
		$progress = array();

		for ($i=0; $i < count($caractereInterdit); $i++) { 
			if($i == 0){
				$progress[$i] = str_replace($caractereInterdit[$i], '', $slug);
			}else{
				$progress[$i] = str_replace($caractereInterdit[$i], '', $progress[$i-1]);	
			}						
		}
		$i = count($progress);
		foreach ($caractereAChanger as $key => $value) {
			$progress[$i] = str_replace($key, $value, $progress[$i-1]);
			$i++;
		}
		$slug = str_replace('\'', '-', $progress[count($progress)-1]);

		unset($progress);
		unset($i);
		$slug = str_replace(' ', '-', $slug);
		if($slug[strlen($slug)-1] == '-'){
			$slug = substr($slug, 0, -1);
		}
		
		return strtolower($slug);
		
	}

	/**
	* @param: $data à crypter
	* @return: String de 54 caractères
	**/
	function cryptage($data){
		$key = sha1('%tGU+54Fvb7TGFFrftij,.pd*kzoj6$nxwar?FLASH=POURRImp08hnJG3');
		$key2 = md5('jd4332?euhz7duOzih9Zdzq^$zq$d)oq;x,qXnPq*./');
		return str_replace('B','K',substr(base64_encode(sha1($key.$data.$key2.$data,true).sha1($data.$key2.$data,true)),0,-2));
	}
	/**
	* @return : Renvoie un token de 32 caractères
	**/
	function token(){
		return md5('*Mldoz79?;'.microtime().'IJDZ79ZDjdziç!./..d^$z)dz?;');
	}

?>