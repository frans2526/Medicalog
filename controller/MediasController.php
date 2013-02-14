<?php
	class MediasController extends Controller{
		
		function admin_index($id){
			$this->loadModel('Media');
			if($this->request->data && !empty($_FILES['file']['name'])){
				if(strpos($_FILES['file']['type'], 'image') !== false){
					if(preg_match('#jpeg$|gif$|jpg$|JPG$|png$#',$_FILES['file']['type'])){
						$dir = WEBROOT.DS.'img'.DS.date('Y-m');
						if(!file_exists($dir)) mkdir($dir,0755);

						if(strlen($_FILES['file']['type']) == 9){
							$file = time().'.'.substr($_FILES['file']['type'], -3);
						}else{
							$file = time().'.'.substr($_FILES['file']['type'], -4);
						}

						if(empty($this->request->data->name)){
							$this->request->data->name = $file;
						}
						
						move_uploaded_file($_FILES['file']['tmp_name'], $dir.DS.$file);
						chmod($dir.DS.$file,0755);
						$this->Media->save(array(
							'name'    => $this->request->data->name,
							'file'    => date('Y-m').'/'.$file,
							'Posts_id' => $id,
							'type'    => 'img',
							'Posts_Users_id' => $_SESSION['User']->id
						));
						$this->Session->setFlash("L'image a bien été uploadé");	
					}else{
						$this->Form->errors['file'] = 'Le média doit avoir le format .jpeg, .gif ou .png';
					}
				}else{
					$this->Form->errors['file'] = 'Le fichier n\'est pas une image';
				}
			}
			$this->layout = 'modal';
			$d['images'] = $this->Media->find(array(
				'conditions'  => array('Posts_id' => $id, 'Posts_Users_id' => $_SESSION['User']->id)
			));
			$d['post_id'] = $id;
			$this->set($d);
		}

		function admin_delete($id){
			$this->loadModel('Media');
			$media = $this->Media->findFirst(array(
				'conditions'  => array('id' => $id, 'Posts_Users_id' => $_SESSION['User']->id)
			));		
			unlink(WEBROOT.DS.'img'.DS.$media->file);
			$this->Media->delete($id);
			$this->Session->setFlash("Le média a bien été supprimé");
			$this->redirect('admin/medias/index/'.$media->Posts_id);
		}

	}
?>