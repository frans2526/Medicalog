<?php
class PagesController extends Controller{
	

	function view($id){
		
		$this->loadModel('Post');
		$d['page'] = $this->Post->findFirst(array(
			'conditions' => array('id' => $id, 'type' => 'page','online' => 1)
		));
		if(empty($d['page'])){
			$this->e404('Page introuvable');
		}
		$this->set($d);
	}

	/**
	*Permet de récupérer les pages pour le menu
	**/
	function getMenu(){
		$this->loadModel('Post');
		return $this->Post->find(array(
			'conditions' => array('online' => 1, 'type' => 'page')
		));
	}

	function search(){
		if(!empty($_POST['search'])){
			$this->loadModel('Post');
			$d['page'] = $this->Post->query('SELECT id, title FROM Posts WHERE type=\'page\' AND title LIKE \'%'.$_POST['search'].'%\'');
			if(count($d['page']) == 1){
				$this->redirect('pages/view/'.$d['page'][0]->id);
				die();
			}else{
				// debug($d);
				$d['title'] = count($d['page'])==0?'Aucun résultat trouvé':'Recherche';
				$this->set($d);
			}
			
		}
	}

	/**
	* ADMIN
	**/

	function admin_index(){
		$perPage = 10;
		$this->loadModel('Post');
		$condition = array('type' => 'page');
		$d['posts'] = $this->Post->find(array(
			'fields'     => 'id,title,online',
			'conditions' => $condition,
			'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
		));
		$d['total'] = $this->Post->findCount($condition);
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}

	/**
	* Permet d'éditer une page
	**/
	function admin_edit($id = null){
		$this->loadModel('Post');
		if($id === null){
			$post = $this->Post->findFirst(array(
				'conditions' => array('online' => -1)
			));
			if(!empty($post)){
				$id = $post->id;
			}else{
				$this->Post->save(array(
				'online' => -1,
				'Users_id' => -1
				));
				$id = $this->Post->id;
			}
		}
		$d['id'] = $id;
		if($this->request->data){
			if($this->Post->validates($this->request->data)){
				$this->request->data->slug = creerSlug($this->request->data->title);
				$this->request->data->type = 'page';
				$this->request->data->created = date('Y-m-d H:i:s');
				$this->request->data->Users_id = $this->Session->user('id');

				$this->Post->save($this->request->data);
				$this->redirect('admin/pages/index');
				$this->Session->setFlash('La page a bien été mise à jour','success',true);							
			}else{
				$this->Session->setFlash('Merci de corriger vos informations','error');	
			}
		}else{
			$this->request->data = $this->Post->findFirst(array(
				'conditions' => array('id' => $id)
			));	
		}
		
		$this->set($d);
	}

	/**
	* Permet de supprimer une page
	**/
	function admin_delete($id){
		if(is_numeric($id) && isset($_GET['t'])){
			$this->loadModel('Post');
			$this->Post->delete($id);
			$this->Session->setFlash('La page '.$id.' a bien été supprimé');
			$this->redirect('admin/pages/index');
		}else{
			$this->Session->setFlash('Erreur lors de la suppression de la page','error');
			$this->redirect('admin/pages/index');
		}
	}

	/**
	* Permet de lister les contenus publié
	**/
	function admin_tinymce(){
		$this->loadModel('Post');
		$this->layout = 'modal';
		$d['posts'] = $this->Post->find(array(
			'conditions' => array('online' => '1')
		));
		// $d['doctors'] = '/doctors/register';
		$this->set($d);
	}
}

?>