<?php
	class PatientsController extends Controller{
		
		function apps_index(){
			$this->loadModel('Patient');
			$d['patients'] = $this->Patient->query('SELECT DISTINCT Patients.name,Patients.lastName,Patients.id FROM Historys, Patients WHERE Historys.Doctors_id ='.$this->Session->doctor('id').' AND Historys.Patient_id = Patients.id AND Patients.mutuelle <> 0 ORDER BY Patients.name');

			$this->set($d);
		}

		function apps_edit($id = null){
			$this->loadModel('Patient');
			$this->loadModel('History');
			$historyId = '';
			$patientId = '';
			$d = array();
			if($id === null){
				// /!\ id HISTORY et id PATIENT /!\ \\
				$history = $this->History->query('SELECT DISTINCT Historys.id AS historyId,Patients.id AS patientId FROM Historys, Patients WHERE Historys.Doctors_id ='.$this->Session->doctor('id').' AND Historys.status = 0 AND Patients.mutuelle = 0');

				// debug($history);
				if(!empty($history)){
					$d['historyId'] = $history[0]->historyId;
					$d['patientId'] = $history[0]->patientId;
				}else{
					$this->Patient->save(array(
						'name' => 'NULL',
						'lastName' => 'NULL',
						'mutuelle' => 0
					));
					$d['patientId'] = $this->Patient->id;
					$this->History->save(array(
						'Patient_id' => $d['patientId'],
						'Doctors_id'=>$this->Session->doctor('id'),
						'status' => 0
					));
					$d['historyId'] = $this->History->id;	
				}
			}else{
				if(is_numeric($id))
					$d['patientId'] = $id;
				$history = $this->History->query('SELECT DISTINCT Historys.id AS historyId FROM Historys, Patients WHERE Historys.Doctors_id ='.$this->Session->doctor('id').' AND Historys.status = 0 AND Historys.Patient_id ='.$d['patientId']);
				
				if(!empty($history))
					$d['historyId'] = $history[0]->historyId;
				else{
					$history2 = $this->History->query('SELECT DISTINCT Historys.id AS historyId FROM Historys, Patients WHERE Historys.Doctors_id ='.$this->Session->doctor('id').' AND Historys.status = 1 AND Historys.Patient_id ='.$d['patientId']);
					if(!empty($history2)){
						$d['historyId'] = $history2[0]->historyId;
					}else{
						$this->History->save(array(
							'Patient_id' => $d['patientId'],
							'Doctors_id'=>$this->Session->doctor('id'),
							'status' => 0
						));

						$d['historyId'] = $this->History->id;
					}
					
				}
				// debug($d);
				// die();

			}
			// debug($d);
			// die();

			if($this->request->data){
				if($this->Patient->validates($this->request->data)){
					$flagTel = true;
					$flagMobile = true;
					if(!empty($this->request->data->phone)){
						if(preg_match('/^[0-9]{2,3}[. \/-]?[0-9]{7}$/', $this->request->data->phone) === 0){
							$this->Session->setFlash('Vous devez préciser un numéro de téléphonne valide');
							$flagTel = false;
								
						}
					}
					if(!empty($this->request->data->mobile)){
						if(preg_match('/^[0-9]{4}[. \/-]?[0-9]{6}$/',$this->request->data->mobile) === 0){
							$this->Session->setFlash('Vous devez préciser un numéro de GSM valide','error');
							$flagMobile =false;
						}
					}
					if($flagMobile && $flagTel){
						//History
						$historyObj = '';

						$historyObj->id = $this->request->data->historyId;
						$historyObj->Doctors_id= $this->Session->doctor('id');
						$historyObj->Patient_id = $d['patientId'];
						$historyObj->status = 1;
						$historyObj->content = htmlspecialchars($this->request->data->content);
						$historyObj->date = date('Y-m-d H:i:s');

						// debug($historyObj);
						$this->History->save($historyObj);

						unset($historyObj);
						unset($this->request->data->historyId);
						unset($this->request->data->content);
						//Patient
						$this->request->data->name = htmlentities($this->request->data->name, ENT_QUOTES, "UTF-8");
						$this->request->data->lastName = htmlentities($this->request->data->lastName, ENT_QUOTES, "UTF-8");
						$this->request->data->mail = htmlentities($this->request->data->mail, ENT_QUOTES, "UTF-8");
						$this->request->data->age = htmlentities(Date::parseDateToFormatMysql($this->request->data->age,'d/m/Y H:i:s'), ENT_QUOTES, "UTF-8");
						$this->request->data->adress = htmlentities($this->request->data->adress, ENT_QUOTES, "UTF-8");
						$this->request->data->id = $d['patientId'];

						// debug($this->request);
						// debug(array('history' => 'Mon blala dzdzdz'),true);
						// die();

						$this->Patient->save($this->request->data);
						// $this->Patient->save()

						$this->redirect('app/patients/index');
						$this->Session->setFlash('Le patient a bien été mis à jour','success',true);
					}
				}else{
					$this->Session->setFlash('Merci de corriger vos informations','error');	
				}
			}else{
				$history = $this->History->query('SELECT Historys.id AS historyId, Historys.content, Historys.date FROM Historys WHERE id ='.$d['historyId']);
				
				$this->request->data = $this->Patient->findFirst(array(
					'conditions' => array('id' => $d['patientId'])
				));
				$d['date'] = Date::formaterDate($history[0]->date);
				$this->request->data->age = substr(Date::formaterDate($this->request->data->age),0,-7);
				if($this->request->data->name == 'NULL'){
					$this->request->data->name = '';
					$this->request->data->lastName = '';
					$d['date'] = null;
				}
				$this->request->data->content = $history[0]->content;
				$this->request->data->historyId = nl2br($history[0]->historyId);
				// debug($history);
				// debug($this->request->data);
				// die();
			}	
			$this->set($d);
		}

		function apps_search(){
			$this->loadModel('Patient');
			$this->loadModel('History');
			$d = array();

			if(!empty($_POST['searchPatient'])){
				$search = $_POST['searchPatient'];
				$d['patients'] = $this->Patient->query('SELECT Patients.name, Patients.lastName, Patients.id AS patientId,Historys.id AS  historyId FROM Historys, Patients WHERE Historys.Doctors_id ='.$this->Session->doctor('id').' AND Patients.mutuelle <> 0 AND Historys.Patient_id = Patients.id AND Historys.status = 1 AND Patients.name LIKE \'%'.$search.'%\' ORDER BY Patients.name');
				if(count($d['patients']) == 1){
					$history = $this->History->query('SELECT Historys.id AS historyId, Historys.content, Historys.date FROM Historys WHERE id ='.$d['patients'][0]->historyId);
				
					$this->request->data = $this->Patient->findFirst(array(
						'conditions' => array('id' => $d['patients'][0]->patientId)
					));

					$d['date'] = Date::formaterDate($history[0]->date);

					if($this->request->data->name == 'NULL'){
						$this->request->data->name = '';
						$this->request->data->lastName = '';
						$d['date'] = null;
					}

					$this->request->data->content = $history[0]->content;
					$this->request->data->historyId = nl2br($history[0]->historyId);
					$this->redirect('app/patients/edit/'.$this->request->data->id);
					die();
				}else{
					$this->set($d);
				}
			}
		}

		
	}

?>