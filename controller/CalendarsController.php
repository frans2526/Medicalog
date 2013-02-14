<?php
	class CalendarsController extends Controller{
		
		function apps_index(){
			$this->loadModel('Calendar');
			$date = new Date();
			$year = date('Y');
			$dates = $date->getAll($year);
			$dates = current($dates); 

			$d['date'] = $date;
			$d['dates'] = $dates;
			$d['year'] = $year;

			if(!empty($_SESSION['cal_token'])){
				Zend_Loader::loadClass('Zend_Gdata');
				Zend_Loader::loadClass('Zend_Gdata_AuthSub');
				Zend_Loader::loadClass('Zend_Gdata_Calendar');

				$client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['cal_token']);
				// Création d'un objet Gdata utilisant le client HTTP authentifié :
				$service = new Zend_Gdata_Calendar($client);
				$query = $service->newEventQuery();
				$query->setStartMin(date('Y-m').'-01T00:00:00+02:00');
				$query->setUser('default');
				$query->setVisibility('private');
				$query->sortorder = 'ascending'; 
				$query->setOrderBy('starttime');
				$query->setProjection('full');
				try{
				  	$listEntry = $service->getCalendarListEntry(Zend_Gdata_Calendar::CALENDAR_EVENT_FEED_URI);
				 	$listFeed = $service->getCalendarListFeed();
				    	$eventEntry = $service->getCalendarEventEntry(Zend_Gdata_Calendar::CALENDAR_EVENT_FEED_URI);
				    	$feed = $service->getCalendarEventFeed($query);
				}catch(Zend_Gdata_App_Exception $e) {
				    	$this->Session->setFlash('Erreur lors de la récupération des rendez-vous Google','error');
  				}
  				$d['event_feed'] = $service->getCalendarEventFeed($query);
  			}else{
  				$d['calendars'] = $this->Calendar->find(array(
  					'fields' => 'id,start',
					'conditions' => array(
						'Doctor_id'=>$this->Session->doctor('id'),
						'status' => 1
					),
					'order' => 'start'
				));
				// 2012-06-15 10:20:00
				$sizeD = count($d['calendars']);
				for ($i=0; $i < $sizeD; ++$i) { 
					$d['calendars'][$i]->start = substr($d['calendars'][$i]->start, 0, 10);
				}
  			}

			$this->set($d);
		}

		function apps_edit($id = null){
			$this->loadModel('Calendar');
			if(empty($_SESSION['cal_token'])){
				if($id === null){
					$calendar = $this->Calendar->findFirst(array(
						'conditions' => array(
							'doctor_id' => $this->Session->doctor('id'),
							'status' => -1
						)
					));
					if(!empty($calendar)){
						$id = $calendar->id;
					}else{
						$this->Calendar->save(array(
							'doctor_id' => $this->Session->doctor('id'),
							'status' => -1
						));
						$id = $this->Calendar->id;
					}
				}
				$d['id'] = $id;
				if(is_numeric($id)){
					if($this->request->data){
						if($this->Calendar->validates($this->request->data)){
							if($this->request->data->start != $this->request->data->end && $this->request->data->start < $this->request->data->end){
								$this->request->data->id = $id;
								$this->request->data->Doctor_id = $this->Session->doctor('id');
								$this->request->data->title = htmlentities($this->request->data->title,ENT_QUOTES,'UTF-8');
								$this->request->data->content = htmlentities($this->request->data->content,ENT_QUOTES,'UTF-8');
								if(!strpos($this->request->data->start, '-')){
									$this->request->data->start = Date::parseDateToFormatMysql($this->request->data->start,'d/m/Y H:i:s');
								} 
								if(!strpos($this->request->data->end, '-')){
									$this->request->data->end = Date::parseDateToFormatMysql($this->request->data->end,'d/m/Y H:i:s');
								}
								$this->request->data->status = 1;
								
								$this->Calendar->save($this->request->data);
								$this->redirect('apps/calendars/index');
								$this->Session->setFlash('Le rendez-vous a bien été ajouté','success',true);
							}else{
								$this->Session->setFlash('Les deux dates doivent être différentes','error');
							}
						}else{
							$this->Session->setFlash('Merci de corriger vos informations','error');
						}
					}else{
						$this->request->data = $this->Calendar->findFirst(array(
							'conditions' => array('id' => $id,'status'=>1)
						));
					}
				}
				$this->set($d);
			}else{
				//enregistrer et modifier un rendez-vous dans le calendrier Google
				if($this->request->data){
					if($this->Calendar->validates($this->request->data)){
						if($this->request->data->start != $this->request->data->end && $this->request->data->start < $this->request->data->end){
							Zend_Loader::loadClass('Zend_Gdata');
							Zend_Loader::loadClass('Zend_Gdata_AuthSub');
							Zend_Loader::loadClass('Zend_Gdata_Calendar');
							Zend_Loader::loadClass('Zend_Http_Client');
							      
							$client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['cal_token']);
							   
							// Création d'un objet Gdata utilisant le client HTTP authentifié :
							$gcal = new Zend_Gdata_Calendar($client);

							$title = htmlentities($this->request->data->title, ENT_QUOTES, "UTF-8");
							$content = htmlentities($this->request->data->content, ENT_QUOTES, "UTF-8");
							$start = Date::parseDateToFormatMysql($this->request->data->start,'d/m/Y H:i','ATOM');
							$end = Date::parseDateToFormatMysql($this->request->data->end,'d/m/Y H:i','ATOM');

							
							if(!empty($this->request->data->id) && strpos($this->request->data->id,'http://www.google.com/calendar/feeds/default/private/full/') === 0){

								//on va modifier
								try{
									$event = $gcal->getCalendarEventEntry($this->request->data->id);
									$event->title = $gcal->newTitle($title);
									$event->content = $gcal->newContent($content);
									$when = $gcal->newWhen();
									$when->startTime = $start;
									$when->endTime = $end;
									$event->when = array($when);
			 						
									// Upload the changes to the server
								
									$event->save();
								}catch(Zend_Gdata_App_Exception $e) {
									if(Conf::$debug != 0){
										echo "Error: " . $e->getMessage();
									}
								}

								$this->redirect('apps/calendars/index');
								$this->Session->setFlash('Le rendez-vous a bien été modifié dans le calendrier Google','success',true);
							}else{
								// on fait une insertion
								// construct event object
								// save to server      
								try {
									$event = $gcal->newEventEntry();        
								        	$event->title = $gcal->newTitle($title);        
								        	$event->content = $gcal->newContent($content);   
								        	$when = $gcal->newWhen();
								        	$when->startTime = $start;
								        	$when->endTime = $end;
								        	$event->when = array($when);        
								        	$gcal->insertEvent($event);   
								}catch (Zend_Gdata_App_Exception $e) {
									if(Conf::$debug != 0){
										echo "Error: " . $e->getResponse();
									}
								}
								$this->redirect('apps/calendars/index');
								$this->Session->setFlash('Le rendez-vous a bien été ajouté dans le calendrier Google','success',true);
							}
						}else{
							$this->Session->setFlash('Les deux dates doivent être différentes','error');
						}
					}else{
						$this->Session->setFlash('Merci de corriger vos informations','error');
					}
				}else{
					// debug($_GET);
					if(isset($_GET['ggle']) && strpos($_GET['ggle'],'http://www.google.com/calendar/feeds/default/private/full/') === 0){
						$url_id = $_GET['ggle'];
						//on récupère celui qu on a choisi pour le modifier
						Zend_Loader::loadClass('Zend_Gdata');
						Zend_Loader::loadClass('Zend_Gdata_AuthSub');
						Zend_Loader::loadClass('Zend_Gdata_Calendar');
						Zend_Loader::loadClass('Zend_Http_Client');
						      
						$client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['cal_token']);
						   
						// Création d'un objet Gdata utilisant le client HTTP authentifié :
						$gcal = new Zend_Gdata_Calendar($client);

						try {
							$event = $gcal->getCalendarEventEntry($url_id);
						} catch (Zend_Gdata_App_Exception $e) {
							if(Conf::$debug != 0){
								echo "Error: " . $e->getMessage();
							}
						}
						$this->request->data->id = $url_id;
						$this->request->data->title = $event->title;
						$this->request->data->content = $event->content;
						$this->request->data->start = $event->when[0]->startTime;
						$this->request->data->end = $event->when[0]->endTime;

						// debug($event->title);
						// die();
					} 
				}
				$d['id'] = -1;
				$this->set($d);
			}
			
		}

		function apps_read(){
			$this->loadModel('Calendar');
			$this->layout = 'ajax';
			$doc = new DOMDocument('1.0', 'UTF-8');
			// Ajout la balise 'liste' a la racine
			$root = $doc->createElement('root');
			$doc->appendChild($root);

			if(!empty($_SESSION['cal_token'])){
				Zend_Loader::loadClass('Zend_Gdata');
				Zend_Loader::loadClass('Zend_Gdata_AuthSub');
				Zend_Loader::loadClass('Zend_Gdata_Calendar');

				$client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['cal_token']);
				// Création d'un objet Gdata utilisant le client HTTP authentifié :
				$service = new Zend_Gdata_Calendar($client);
				$query = $service->newEventQuery();
				$query->setStartMin(date('Y-m').'-01T00:00:00+02:00');
				$query->setUser('default');
				$query->setVisibility('private');
				$query->sortorder = 'ascending'; 
				$query->setOrderBy('starttime');
				$query->setProjection('full');
				try{
				  	$listEntry = $service->getCalendarListEntry(Zend_Gdata_Calendar::CALENDAR_EVENT_FEED_URI);
				 	$listFeed = $service->getCalendarListFeed();
				    	$eventEntry = $service->getCalendarEventEntry(Zend_Gdata_Calendar::CALENDAR_EVENT_FEED_URI);
				    	$feed = $service->getCalendarEventFeed($query);
				}catch(Zend_Gdata_App_Exception $e) {
				    	echo '<root><rdv>ERROR</rdv></root> ';
  				}
  				$event_feed = $service->getCalendarEventFeed($query);	
  				
  				foreach ($event_feed as $event) {
					$rdv = $doc->createElement('rdv');
					$id = $doc->createElement('id', $event->getEditLink()->href);
					$rdv->appendChild($id);
					$title = $doc->createElement('title', htmlspecialchars($event->title,ENT_QUOTES,'UTF-8'));
					$rdv->appendChild($title);
					$content = $doc->createElement('content', htmlspecialchars($event->content,ENT_QUOTES,'UTF-8'));
					foreach ($event->when as $when) {
				        		$format  = 'Y-m-d H:i:s';
				        		$rdv->appendChild($content);
						$start = $doc->createElement('start', date_create($when->startTime)->format($format));
						$rdv->appendChild($start);
						$end = $doc->createElement('end', date_create($when->endTime)->format($format));
				    	}
					$rdv->appendChild($end);
					$doctor_id = $doc->createElement('doctor_id', $this->Session->doctor('id'));
					$rdv->appendChild($doctor_id);
					$root->appendChild($rdv);
				}
				unset($event_feed);
			}else{
				$d['calendars'] = $this->Calendar->find(array(
					'conditions' => array(
						'Doctor_id'=>$this->Session->doctor('id'),
						'status' => 1
					),
					'order' => 'start'
				));
				$sizeD = count($d['calendars']);
				
				// Ajout de la balise 'mot' dans liste
				for ($i=0; $i < $sizeD; ++$i) { 
					$rdv = $doc->createElement('rdv');
					$id = $doc->createElement('id', $d['calendars'][$i]->id);
					$rdv->appendChild($id);
					$title = $doc->createElement('title', htmlspecialchars($d['calendars'][$i]->title,ENT_QUOTES,'UTF-8'));
					$rdv->appendChild($title);
					$content = $doc->createElement('content', htmlspecialchars($d['calendars'][$i]->content,ENT_QUOTES,'UTF-8'));
					$rdv->appendChild($content);
					$start = $doc->createElement('start', htmlspecialchars($d['calendars'][$i]->start,ENT_QUOTES,'UTF-8'));
					$rdv->appendChild($start);
					$end = $doc->createElement('end', htmlspecialchars($d['calendars'][$i]->end,ENT_QUOTES,'UTF-8'));
					$rdv->appendChild($end);
					$doctor_id = $doc->createElement('doctor_id', $d['calendars'][$i]->Doctor_id);
					$rdv->appendChild($doctor_id);
					$root->appendChild($rdv);
				}
				unset($d['calendars']);
			}

			$doc->formatOutput = true;
			$d['calendarsXml'] = $doc->saveXML();
			$this->set($d);
		}

		function apps_delete($id = null,$doctor_id = null){
			if(!empty($_SESSION['cal_token']) && isset($_GET['ggle']) && strpos($_GET['ggle'],'http://www.google.com/calendar/feeds/default/private/full/') === 0 && isset($_GET['t'])){
				$id = $_GET['ggle'];
				Zend_Loader::loadClass('Zend_Gdata');
				Zend_Loader::loadClass('Zend_Gdata_AuthSub');
				Zend_Loader::loadClass('Zend_Gdata_Calendar');

				$client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['cal_token']);
				$service = new Zend_Gdata_Calendar($client);

				$service->delete($id);

				$this->Session->setFlash('Le rendez-vous Google a bien été supprimé');
				$this->redirect('apps/calendars/index');
			}else{
				if(!empty($id) && !empty($doctor_id) && is_numeric($id) && is_numeric($doctor_id) && isset($_GET['t'])){
					if($doctor_id == $this->Session->doctor('id')){
						$this->loadModel('Calendar');
						$this->Calendar->delete($id);
						$this->Session->setFlash('Le rendez-vous a bien été supprimé');
						$this->redirect('apps/calendars/index');
					}else{
						$this->Session->setFlash('Erreur lors de la suppression du rendez-vous','error');
						$this->redirect('apps/calendars/index');
					}
				}else{
					$this->Session->setFlash('Erreur lors de la suppression du rendez-vous','error');
					$this->redirect('apps/calendars/index');
				}
			}
		}

		
	}

?>