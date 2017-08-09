<?php
class CMN1010Controller extends AppController {
	public $helpers = array('Html', 'Form');
	
	// 使用するモデル
	public $uses = array();

	public function index() {
		if(!isset($_SESSION)) {
			$this->redirect(['controller'=>'CMN1000', 'action'=>'index']);
		}
	}
}
