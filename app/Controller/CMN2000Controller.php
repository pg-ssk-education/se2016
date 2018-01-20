<?php
class CMN2000Controller extends AppController {
	public $helpers = array('Html', 'Form');
	
	// 使用するモデル
	public $uses = ['User'];

	public function index() {
		parent::checkLogin();
		$this->set('title_for_layout', 'ユーザ管理');
		$users=$this->User->findAll();
		$this->set('users', $users);
	}
	
	public function action() {
	}
	
	public function add() {
		edit();
	}
	
	public function edit() {
		$userId=$this->params['named']['id'];
		if(empty($userId)) {
			$this->set('title_for_layout', 'ユーザ登録');
		} else {
			$this->set('title_for_layout', 'ユーザ編集');
		}
		$user=$this->User->findByUserId($userId);
		$this->set('user', $user);
	}
	
	public function delete() {
		$userId=$this->params['named']['id'];
		$flg=$this->User->delete($userId);
		$this->redirect(['controller'=>'CMN2000', 'action'=>'index']);
	}
}
