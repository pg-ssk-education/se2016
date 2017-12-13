<?php
class CMN2000Controller extends AppController {
	public $helpers = array('Html', 'Form');
	
	// 使用するモデル
	public $uses = ['User'];

	public function index() {
		$users=$this->User->findAll();
		$this->set('users', $users);
	}
	
	public function action() {
		switch($this->request->data('hidAction')) {
			case "Add":
				add();
				break;
			case "Edit":
				edit();
				break;
			case "Delete":
				delete();
				break;
			default:
				Throw new NotFoundeException();
				break;
		}
		return false;
	}
	
	public function add() {
	}
	
	public function edit() {
	}
	
	public function delete() {
		if (isset($_POST['check'])) {
			$checks = $_POST['check'];
			
			foreach ($checks as $check) {
				$flg=$this->User->deleteByUserId($check);
			}
		}
		
	}
}
