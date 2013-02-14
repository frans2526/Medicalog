<?php
	if($this->request->prefix == 'admin'){
		$this->layout = 'admin';
		if(!$this->Session->isLogged()){
			$this->redirect('users/login');
		}
	}elseif($this->request->prefix == 'apps'){
		$this->layout = 'apps';
		if(!$this->Session->isLoggedDoctor()){
			$this->redirect('users/login');
		}
	}
?>