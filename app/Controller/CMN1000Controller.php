<?php
/** 
 * /app/Controller/CMN1000Controller.php
 */
class CMN1000Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	
	// 使用するモデル
	public $uses = ['Notification', 'User'];
	
	public function index() {
		$this->set("title_for_layout","ログイン"); 
		$this->set('notifications', $this->Notification->getNotification());
		
		$this->set("testdata", $this->User->test());
		//$this->set("testdatas", 'aiueo');
		
	}
	
	public function login() {
		if ($this->request->is('post')) {
			//$this->log($this->request, LOG_DEBUG);
			$user = $this->User->login($this->request->data('txtLoginId'), $this->request->data('txtPassword'));
			if(empty($user)){
				$this->setError('ログインできません。ユーザＩＤ、パスワードを確認してください。(ERR_CMN1000_01)');
			} else {
				// セッションを開始して次の画面に遷移する
				if(!isset($_SESSION)) {
					session_start();
				}
				$this->redirect(['controller'=>'CMN1010', 'action'=>'index']);
			}
			
		}
	}
	
	private function setError($msg) {
		$this->Session->setFlash($msg);
		$this->redirect(['controller'=>'CMN1000', 'action'=>'index']);
	}
}
