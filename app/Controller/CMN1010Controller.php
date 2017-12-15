<?php
class CMN1010Controller extends AppController {

	public $helpers = ['Html', 'Form'];

	// 使用するモデル
	//public $uses = array();
	public $uses = ['Notification'];
	

	public function index() {

		if(isset($_SESSION) && isset($_SESSION['CMN1010'])) {
			//$this->redirect(['controller'=>'CMN1000', 'action'=>'index']);
			$sessionData = $_SESSION['CMN1010'];
			$conditions = $sessionData['conditions'];
			
			if(isset($conditions) && !empty($conditions)) {
				$this->set('notifications', $this->Notification->find('all', ['conditions' => $conditions]));
				return;
			}
			//Todo:ログインユーザーを条件に入れること
		}
		
		$this->set('notifications', $this->Notification->find('all', ['conditions' => ['Notification.CONFIRMED' => '0']]));
	}
	
	public function action() {
		/*if ($this->request->data('hidAction') == 'reload') {*/
			$this->reload();
			return;
		/*}*/
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
		
		//$this->render('index');
		$level = [];
		
		if($this->request->data('infoChkbox') != null) {
			array_push($level, 'I');
		}
		
		if($this->request->data('warnChkbox') != null) {
			array_push($level, 'W');
		}
		
		if($this->request->data('alertChkbox') != null) {
			array_push($level, 'A');
		}
		
		$confirmed = 0;
		if($this->request->data('confChkbox') != null) {
			$confirmed = 1;
		}
		
		$conditions = [];
		if(!empty($level)) {
			array_merge($conditions, ['Notification.LEVEL' => $level]);
		}
		
		if($confirmed == 0) {
			array_merge($conditions, ['Notification.CONFIRMED' => '0']);
		} else {
			array_merge($conditions, ['Notification.CONFIRMED' => ['0', '1']]);
		}
		
		$sessionData = ['conditions' => $conditions];
		
		
		$this->Session->write('CMN1010', $sessionData);
		
		$this->redirect(['controller'=>'CMN1010', 'action'=>'index']);
		
	
	}
	
	
	public function confirm() {
	
		$this->render('index');
	
	}
	
}
