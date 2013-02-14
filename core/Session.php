<?php

class Session{
	

	public function __construct(){
		if(!isset($_SESSION)){
			session_start();
			session_cache_limiter('private_no_expire');
		// Vérification du token
		}elseif (isset($_GET['t']) && $_GET['t'] != $_SESSION['token']) {
			// session_destroy et redirection avec un flash session expiré
			unset($_SESSION);
			die('Jeton de s&eacute;cuit&eacute; p&eacute;rim&eacute;');
		}
	}

	// Pas encore utiliser
	public function clear(){
		return session_destroy();
	}

	public function setFlash($message,$type = 'success',$force = false){
		$_SESSION['flash'] = array(
			'message' => $message,
			'type'    => $type,
			'force'   => $force
		);
	}

	public function flash(){
		if(isset($_SESSION['flash']['message'])){
			$html = '<div class="alert alert-'.$_SESSION['flash']['type'].'"><p>'.$_SESSION['flash']['message'].'</p></div>';
			
			if($_SESSION['flash']['force']){
				$_SESSION['flash']['force'] = false;
				return $html;
			}else{
				$_SESSION['flash'] = array();
				return $html;
			}
		}
	}

	public function write($key,$value){
		$_SESSION[$key] = $value;
		$_SESSION['token'] = token();
	}

	public function read($key = null){
		if($key){
			if(isset($_SESSION[$key])){
				return $_SESSION[$key];
			}else{
				return false;
			}
		}else{
			return $_SESSION;
		}
	}

	public function isLogged(){
		return isset($_SESSION['User']->login);
	}

	public function isLoggedDoctor(){
		return isset($_SESSION['Doctor']->login);
	}

	public function user($key){
		if($this->read('User')){
			if(isset($this->read('User')->$key)){
				return $this->read('User')->$key;
			}else{
				return false;
			}
		}
		return false;
	}

	public function doctor($key){
		if($this->read('Doctor')){
			if(isset($this->read('Doctor')->$key)){
				return $this->read('Doctor')->$key;
			}else{
				return false;
			}
		}
		return false;
	}
}
?>