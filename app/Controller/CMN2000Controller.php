<?php
class CMN2000Controller extends AppController {
	public $helpers = array('Html', 'Form');
	
	// 使用するモデル
	public $uses = ['User'];

	public function index() {
		$users=$this->User->findAll(['order' => ['User.USER_ID' => 'asc']]);
		$this->set('users', $users);
	}
	
	public function action() {
    switch($this->response->data('hidAction')) {
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
	}
}
