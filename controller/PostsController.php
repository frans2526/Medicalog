<?php
class PostsController extends Controller{
	
	function index(){
		$perPage = 3;
		$this->loadModel('Post');
		$this->loadModel('User');
		$condition = array('online' => 1, 'type' => 'post');
		$d['posts'] = $this->Post->find(array(

			'conditions' => $condition,
			'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
			'order'      => 'created DESC'

		));
		for ($i=0; $i < count($d['posts']); $i++) { 
			$d['posts'][$i]->created = substr(Date::formaterDate($d['posts'][$i]->created),0,-9);
		}
		
		//pagination
		$d['total'] = $this->Post->findCount($condition);
		$d['page'] = ceil($d['total'] / $perPage);

		//savoir qui a écrit
		$u['user'] = $this->User->find(array());

		$this->set($u);
		$this->set($d);
	}


	function view($id,$slug){

		$this->loadModel('Post');
		$this->loadModel('User');
		$condition = array('online' => 1, 'id' => $id, 'type' => 'post');

		$d['post'] = $this->Post->findFirst(array(
			'fields'     => 'id,slug,content,title,created',
			'conditions' => $condition
		));
		if(empty($d['post'])){
			$this->e404('Page introuvable');
		}
		if($slug != $d['post']->slug){
			$this->redirect("posts/view/id:$id/slug:".$d['post']->slug,301);
		}
		$d['post']->created = substr(Date::formaterDate($d['post']->created),0,-9);
		

		$this->set($d);
	}


	/**
	* ADMIN
	**/

	function admin_index(){
		$perPage = 10;
		$this->loadModel('Post');
		$condition = array('type' => 'post');
		$d['posts'] = $this->Post->find(array(
			'fields'     => 'id,title,online',
			'conditions' => $condition,
			'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
			'order'      => 'id DESC'

		));
		$d['total'] = $this->Post->findCount($condition);
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}

	/**
	* Permet d'éditer un article
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
				$this->request->data->type = 'post';
				$this->request->data->created = date('Y-m-d H:i:s');
				$this->request->data->Users_id = $this->Session->user('id');

				$this->Post->save($this->request->data);
				$this->redirect('admin/posts/index');
				$this->Session->setFlash('L\'article a bien été mis à jour','success',true);							
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
	* Permet de supprimer un article
	**/
	function admin_delete($id){
		if(is_numeric($id) && isset($_GET['t'])){
			$this->loadModel('Post');
			$this->Post->delete($id);
			$this->Session->setFlash('L\'article '.$id.' a bien été supprimé');
			$this->redirect('admin/posts/index');
		}else{
			$this->Session->setFlash('Erreur lors de la suppression du post','error');
			$this->redirect('admin/posts/index');
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
		$this->set($d);
	}

}

?>
