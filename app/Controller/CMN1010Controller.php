<?php
class CMN1010Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	//public $helpers = array('Ajax','Javascript');
	
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
		if ($this->request->data('hidAction') == 'reload') {
			$this->reload();
			return;
		}
		/*
		switch ($this->request->data('hidAction')) {
			case "reload":
				$this->reload();
				break;
			
			case "confirm":
				$this->confirm();
				break;
			
			default:
				//404エラーページに飛ばす
		}
		*/
	}
	
	
	public function reload() {
		
		$this->render('index');
		
		
	
	}
	
	
	public function confirm() {
	
		$this->render('index');
	
	}
	
}
