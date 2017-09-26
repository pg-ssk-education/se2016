<?php
class CMN1010Controller extends AppController {
	public $helpers = array('Html', 'Form');

	// 使用するモデル
	public $uses = array();

	public function index() {
		$this->set('title', 'トップ');
	}
}
