<?php
class CMN1010Controller extends AppController {

	public $helpers = ['Html', 'Form'];
	public $uses = ['Notification'];

	public function index() {
		parent::checkLogin();
		$userId = $this->Session->read('loginUserId');
		$this->set('notifications', $this->Notification->findAllByUserId($userId));
	}
}
