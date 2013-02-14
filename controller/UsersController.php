<?php
	class UsersController extends Controller{
		
		public $user = '';


		/**
		* Login
		**/
		function login(){
			if($this->request->data){
				$data = $this->request->data;
				$data->password = cryptage($data->password);
				$this->loadModel('User');
				$user = $this->User->findFirst(array(
					'conditions' => array('login' => $data->login, 'password' => $data->password)
				));

				
				if(!empty($user) && $user->id != -1){
					$this->Session->write('User',$user);
				}else{
					$this->loadModel('Doctor');
					$doctor = $this->Doctor->findFirst(array(
						'conditions' => array('login' => $data->login, 'password' => $data->password)
					));
					if(!empty($doctor) && $doctor->id != -1){
						unset($data->password);
						$this->Session->write('Doctor',$doctor);
					}else{
						$this->Session->setFlash('Login ou mot de passe incorrect','error');
					}
				}
				$this->request->data->password = '';
			}
			if($this->Session->isLogged()){
				$this->redirect('cockpit');
			}elseif($this->Session->isLoggedDoctor()){
				$this->redirect('app/dashboard');
			}
		}
		
		/**
		* Logout
		**/
		function logout(){
			unset($_SESSION['User']);
			unset($_SESSION['token']);
			$this->Session->setFlash('Vous êtes maintenant déconnecté');
			$this->redirect('');
		}

		function get($key){
			return $this->user->$key;
		}

	}
?>