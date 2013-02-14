<?php
	class ContactsController extends Controller{
		
		function apps_index(){
			$this->loadModel('Contact');
			$d['contacts'] = $this->Contact->find(array(
				'fields' => 'id, fName, lName',
				'conditions' => array('Doctors_id'=>$this->Session->doctor('id'),'NOT'=>array('field'=>'other','value' => '-1')),
				'order' => 'fName'
			));
			$this->set($d);
		}

		function apps_add($id = null){
			$this->loadModel('Contact');
			if($id === null){
				$contact = $this->Contact->findFirst(array(
					'conditions' => array('other' => '-1', 'Doctors_id'=>$this->Session->doctor('id'))
				));
				if(!empty($contact)){
					$id = $contact->id;
				}else{
					$this->Contact->save(array(
						'other' =>'-1',
						'Doctors_id'=>$this->Session->doctor('id')
					));
					$id = $this->Contact->id;
				}
			}
			$d['id'] = $id;
			if($this->request->data){
				if($this->Contact->validates($this->request->data)){
					$flagTel = true;
					$flagMobile = true;
					if(!empty($this->request->data->tel)){
						if(preg_match('/^[0-9]{2,3}[. \/-]?[0-9]{7}$/', $this->request->data->tel) === 0){
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
						$this->request->data->Doctors_id = $this->Session->doctor('id');
						$this->request->data->fName = htmlentities($this->request->data->fName, ENT_QUOTES, "UTF-8");
						$this->request->data->lName = htmlentities($this->request->data->lName, ENT_QUOTES, "UTF-8");
						$this->request->data->mail = htmlentities($this->request->data->mail, ENT_QUOTES, "UTF-8");
						$this->request->data->other = htmlentities($this->request->data->other, ENT_QUOTES, "UTF-8");
						if(is_numeric($d['id']) && isset($_GET['t']))
							$this->request->data->id = $d['id'];
						$this->Contact->save($this->request->data);
						$this->redirect('app/contacts/index');
						$this->Session->setFlash('Le contact a bien été mis à jour','success',true);
					}
				}else{
					$this->Session->setFlash('Merci de corriger vos informations','error');	
				}
			}	
			$this->set($d);
		}

		function apps_show($id){
			$this->loadModel('Contact');
			$d['contact'] = $this->Contact->findFirst(array(
					'conditions' => array('id'=>$id, 'Doctors_id'=>$this->Session->doctor('id'))
			));
			$this->set($d);
		}

		function apps_delete($id){
			if(is_numeric($id) && isset($_GET['t'])){
				$this->loadModel('Contact');
				$this->Contact->delete($id);
				$this->Session->setFlash('Le contact a bien été supprimé');
				$this->redirect('app/contacts/index');
			}else{
				$this->Session->setFlash('Erreur lors de la suppression du contact','error');
				$this->redirect('app/contacts/index');
			}
		}
	}

?>