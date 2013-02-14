<?php
	class Request{
		
		public $url; //URL appller par l'utilisateur
		public $page = 1;
		public $prefix = false;
		public $data = false;

		function __construct(){
			// if(isset($_SERVER['PATH_INFO'])){
			// 	// $this->url = $_SERVER['PATH_INFO'];
			// 	$this->url = $this->pathInfo();
			// }
			/**
			 *Définition du PATH_INFO
			 **/
			if(isset($_SERVER['PATH_INFO']) && strlen($_SERVER['PATH_INFO'])){
			    $_SERVER['PATH_INFO'] = $_SERVER['PATH_INFO'];
			}
			// a tricky way to set path info correctly at some sites
			elseif(isset($_SERVER['ORIG_PATH_INFO']) && $_SERVER['ORIG_PATH_INFO']) {
			 
			    // sometimes this is corrupted by CGI interface (e.g., 1and1) and ORIG_PATH_INFO takes the value of ORIG_SCRIPT_NAME
			    if(isset($_SERVER['ORIG_SCRIPT_NAME']) && !strcmp($_SERVER['ORIG_PATH_INFO'], $_SERVER['ORIG_SCRIPT_NAME'])){
			     
			    }elseif(isset($_SERVER['SCRIPT_NAME']) && !strcmp($_SERVER['ORIG_PATH_INFO'], $_SERVER['SCRIPT_NAME'])){
			     
			    }else{
			        $_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
			    }
			}
			 
			$this->url = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';
			
			if(isset($_GET['page'])){
				if(is_numeric($_GET['page'])){
					if($_GET['page'] > 0){
						$this->page = round($_GET['page']);
					}
				}
			}
			if(!empty($_POST)){
				$this->data = new stdClass();
				foreach ($_POST as $k => $v) {
					$this->data->$k = $v;
				}
			}
		}

		public function pathInfo() {
		        if (!empty($_SERVER['PATH_INFO'])) {
		            return $_SERVER['PATH_INFO'];
		        } elseif (isset($_SERVER['REQUEST_URI'])) {
		            $uri = $_SERVER['REQUEST_URI'];
		        } elseif (isset($_SERVER['PHP_SELF']) && isset($_SERVER['SCRIPT_NAME'])) {
		            $uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PHP_SELF']);
		        } elseif (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
		            $uri = $_SERVER['HTTP_X_REWRITE_URL'];
		        } elseif ($var = env('argv')) {
		            $uri = $var[0];
		        }
		  
		        if (strpos($uri, '?') !== false) {
		            $uri = parse_url($uri, PHP_URL_PATH);
		        }
		  
		        if (empty($uri) || $uri == '/' || $uri == '//') {
		            return '/';
		        }
		        return $uri;
		}

	}
?>