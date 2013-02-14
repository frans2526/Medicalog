<?php
	class DoctorsController extends Controller{


		public function logout(){
			$this->loadModel('Setting');

			if(!empty($_SESSION['cal_token'])){
				Zend_Loader::loadClass('Zend_Gdata');
				Zend_Loader::loadClass('Zend_Gdata_AuthSub');
				
				Zend_Gdata_AuthSub::AuthSubRevokeToken($_SESSION['cal_token']);
				unset($_SESSION['cal_token']);
			}
			$setting = $this->Setting->findFirst(array(
				'conditions' => array('Doctors_id' => $this->Session->doctor('id'))
			));
			if(!empty($setting)){
				$this->request->data->id = $setting->id;
			}
			$this->request->data->Doctors_id = $this->Session->doctor('id');
			$this->request->data->googleCalendar = 'disable';
			$this->Setting->save($this->request->data);

			unset($_SESSION['Doctor']);
			unset($_SESSION['token']);
			$this->Session->setFlash('Vous êtes maintenant déconnecté');
			$this->redirect('');
		}

		function admin_index(){
			$perPage = 10;
			$this->loadModel('Doctor');
			$d['doctors'] = $this->Doctor->find(array(
				'fields'     => 'id,lastName,dt_inscri,firstName,inamiCode',
				'conditions' => array('NOT'=>array('field'=>'id','value' => '-1')),
				'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
				'order'      => 'id ASC'

			));
			for ($i=0; $i < count($d['doctors']); $i++) { 
				$d['doctors'][$i]->dt_inscri = Date::formaterDate($d['doctors'][$i]->dt_inscri);
			}
			$d['total'] = count($d['doctors']);
			$d['page'] = ceil($d['total'] / $perPage);
			$this->set($d);
		}

		function admin_show($id){
			$this->loadModel('Doctor');

			$d['doctor'] = $this->Doctor->findFirst(array(
				'conditions' => array('id' => $id)
			));
			unset($d['doctor']->password);

			$d['doctor']->dt_inscri = Date::formaterDate($d['doctor']->dt_inscri);
			
			if($d['doctor']->dt_AbonNow != null){
				$d['doctor']->dt_AbonNow = Date::formaterDate($d['doctor']->dt_AbonNow);
			}else{
				$d['doctor']->dt_AbonNow='Pas encore abonné';
			}
			if($d['doctor']->dt_AbonEnd != null){
				$d['doctor']->dt_AbonEnd = Date::formaterDate($d['doctor']->dt_AbonEnd);
			}else{
				$d['doctor']->dt_AbonEnd='Pas encore abonné';
			}

			$this->set($d);
		}

		function register(){
			if($this->request->data){
				$this->loadModel('Doctor');
				$this->loadModel('User');
				$data = $this->request->data;
				unset($this->request->data);
				if($this->Doctor->validates($data)){
					if($data->password == $data->password2){
						if(!DoctorsController::existe('login',$data->login,$this->Doctor)){
							if(!DoctorsController::existe('inamiCode',$data->inamiCode,$this->Doctor) && is_numeric($data->inamiCode)){
								unset($data->password2);
								$data->password = cryptage($data->password);
								$data->dt_inscri = date('Y-m-d H:i:s');
								$data->firstName = htmlentities(ucfirst($data->firstName), ENT_QUOTES, "UTF-8");
								$data->lastName = htmlentities($data->lastName, ENT_QUOTES, "UTF-8");
								$data->login = htmlspecialchars($data->login, ENT_QUOTES, "UTF-8");
								if(isset($data->phone)){
									$tabPhone = str_split($data->phone);
									for ($i=0; $i < count($tabPhone); $i++) { 
										if(!is_numeric($tabPhone[$i])){
											$tabPhone[$i] = '';
										}
									}
									$data->phone = implode($tabPhone);
								}

								// ATTENTION NE PAS OUBLIER D'ENREGISTRER
								$this->Doctor->save($data);

								if(DoctorsController::mailToRegister($data->mail,$data->login)){
									$this->Session->setFlash('Vous êtes maintenant enregistré','success',true);
								}else{
									$this->Session->setFlash('Vous êtes maintenant enregistré MAIS il y a eu une erreur lors de l\'envoie du mail','success',true);
								}
								$this->redirect('users/login#formConnexion');
							}else{
								$this->Session->setFlash('Code Inami déjà utilisé ou erroné','error');
							}
						}else{
							$this->Session->setFlash('Login déjà utilisé','error');
						}
					}else{
						$this->Session->setFlash('Mot de passe incorrect','error');
					}
				}else{
					$this->Session->setFlash('Merci de corriger vos informations','error');
				}
			}
			// debug($this);
			// die('fin de la function register');
		}


		public static function existe($key = 'id',$data,$doctor){
			$user = $doctor->Form->controller->User;
			$re = $user->find(array(
				'conditions' => array('login' => $data)
			));
			$r = $doctor->find(array(
				'conditions' => array($key => $data)
			));
			if(count($r) == 0 && count($re) == 0){
				return false;
			}else{
				return true;
			}
		}


		static public function mailToRegister($mail,$login){
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			$subject = 'Enregistrement sur l\'application Medicalog.be';

			// message
			$message = '<html>
			      <head>
			       <title>Enregistrement sur l\'application Medicalog.be</title>
			       <style type="text/css">
			       	body{
			       		width:100%;
			       		background-color: #FAFAFA;
			       		font-family:"Trebuchet MS",Verdana,Helvetica,Arial,sans-serif;
					font-size:110%;
					color:#3F4042;
					margin:0px 0px 0px 0px;
					padding:0px 0px 0px 0px;
					margin-left:auto;
					margin-right:auto;
			       	}
			       	h1{
			       		color: #1078AC;
			       		font-size:140%;
			       		text-align:center;
			       		margin-top:25px;
			       		margin-bottom:30px;
			       	}
			       	p{
			       		width:98%;
			       		margin-left:auto;
			       		margin-right:auto;
			       	}
			       	table{
			       		width:45%;
			       		margin-left:auto;
			       		margin-right:auto;
			       		border:1px solid #000000;
			       		margin-bottom:25px;
			       	}
			       	td,th,tr{
			       		width:50%
			       		border:none;
			       		text-align:center;
			       	}
			       	.footer{
			       		margin-top:15px;
			       		padding-top:15px;
			       		border-top:1px solid #D8D8D8;
			       		text-align:center;
			       		font-size:80%;
			       	}
			       </style>
			      </head>
			      <body>
			       <h1>Enregistrement sur l\'application en ligne Medicalog</h1>
			       <table>
			        <tr>
			         <th>Identifiant</th><th>Mot de passe</th>
			        </tr>
			        <tr>
			         <td>'.$login.'</td><td>Vous seul le connaissez</td>
			        </tr>
			       </table>
			       <p>Maintenant que vous poss&eacute;der un compte vous pouvez vous abonner au <a href="http://localhost/projet/Medicalog.be/pages/prix-5">service en ligne</a></p>
			       <p>Nous vous remercions pour votre inscription &agrave; Medicalog<br />
			       L\'&eacute;quipe de Medicalog</p>
			       <p class="footer">Si vous avez re&ccedil;u ce mail par erreur merci de contacter: <a href="mailto:contact@medicalog.be">contact@medicalog.be</p>
			      </body>
			     </html>
			     ';

			// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Content-Transfer-Encoding: 8bit'. "\r\n";

			// En-têtes additionnels
			// $headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
			$headers .= 'From: Medicalog.be <contact@medicalog.be>' . "\r\n";
			// $headers .= 'Bcc: anniversaire_verif@example.com' . "\r\n";

			// Envoi
			return mail($mail, $subject, $message, $headers);
		}






	}

?>