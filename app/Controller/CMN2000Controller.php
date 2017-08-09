<?php
class CMN2000Controller extends AppController {
	public $helpers = array('Html', 'Form');
	
	// 使用するモデル
	public $uses = ['User'];

	public function index() {
		$users=$this->User->getUser();
		$this->set('users', $users);
	}
}
