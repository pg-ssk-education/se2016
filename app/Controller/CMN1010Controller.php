<?php
class CMN1010Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	
	// 使用するモデル
	//public $uses = array();
	public $uses = ['Notification'];
	

	public function index() {
		if(!isset($_SESSION)) {
			//$this->redirect(['controller'=>'CMN1000', 'action'=>'index']);
			
			
		}
		
		if(empty($this->data['class1']) === false) {
			$this->set('notifications', $this->Notification->getNotification('test1'));
			$this->set('loginUserName', $this->data['class1']);
		}
		else {
			$this->set('notifications', $this->Notification->getNotification('test'));
			$this->set('loginUserName', 'false');
		}
	}
	
	public function action() {
	
		switch ($this->request->data('hidAction') {
			case "reload":
				reload();
				break;
			
			case "confirm":
				confirm();
				break;
			
			default:
				//404エラーページに飛ばす
	
	}
	
	
	public function reload() {
		
		
		
	
	}
	
	
	public function confirm() {
	
	
	}
	
}
