<?php
	class SitemapController extends Controller{
		function index(){
			$this->loadModel('Post');
			$d['pages'] = $this->Post->find(array(
				'conditions' => array('type' => 'page','online' => 1)
			));
			$d['posts'] = $this->Post->find(array(
				'conditions' => array('type' => 'post','online' => 1)
			));
			$this->set($d);
		}
	}

?>