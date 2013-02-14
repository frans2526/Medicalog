<?php
	class SettingsController extends Controller{
		
		function apps_index(){
			// $this->set($d);
		}

		function apps_calendars(){
			$this->loadModel('Setting');
			$d['setting'] = $this->Setting->findFirst(array(
				'fields'     => 'googleCalendar',
				'conditions' =>array('Doctors_id' => $this->Session->doctor('id'))
			));
			$this->set($d);
		}

		function apps_google($status){
			$this->loadModel('Setting');
			if($status == 'enable'){
				if (!isset($_SESSION['cal_token'])) {
					Zend_Loader::loadClass('Zend_Gdata');
					Zend_Loader::loadClass('Zend_Gdata_AuthSub');

					$my_calendar = 'http://www.google.com/calendar/feeds/default/private/full';

					$setting = $this->Setting->findFirst(array(
						'conditions' => array('Doctors_id' => $this->Session->doctor('id'))
					));
					if(!empty($setting)){
						$this->request->data->id = $setting->id;
					}
					$this->request->data->Doctors_id = $this->Session->doctor('id');
					$this->request->data->googleCalendar = $status;
					$this->Setting->save($this->request->data);
				
				 	if (isset($_GET['token'])) {
				        		$session_token = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
				        		$_SESSION['cal_token'] = $session_token;
				        		$this->redirect('app/settings/google/enable');
				    	}else{
				        		$googleUri = Zend_Gdata_AuthSub::getAuthSubTokenUri(
				            'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
				            $my_calendar, 0, 1);
				        		header('Location:'.$googleUri);
				        		exit();
				    	}
				}elseif(!empty($_SESSION['cal_token'])){
					$this->redirect('app/settings/index');
					$this->Session->setFlash('Le calendrier Google est maintenant activé','success');
				}
			}elseif ($status == 'disable') {
				if(!empty($_SESSION['cal_token'])){
					Zend_Loader::loadClass('Zend_Gdata');
					Zend_Loader::loadClass('Zend_Gdata_AuthSub');
				
					Zend_Gdata_AuthSub::AuthSubRevokeToken($_SESSION['cal_token']);
					unset($_SESSION['cal_token']);

					$setting = $this->Setting->findFirst(array(
						'conditions' => array('Doctors_id' => $this->Session->doctor('id'))
					));
					if(!empty($setting)){
						$this->request->data->id = $setting->id;
					}
					$this->request->data->Doctors_id = $this->Session->doctor('id');
					$this->request->data->googleCalendar = $status;
					$this->Setting->save($this->request->data);
				}
				$this->redirect('app/settings/index');
				$this->Session->setFlash('Le calendrier Google est maintenant désactivé','success');
			}else{
				$this->Session->setFlash('Une erreur est survenue','error');
				$this->redirect('app/dashboard');
			}
		}

		
	}

?>