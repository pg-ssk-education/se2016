<?php
/** 
 * /app/Controller/CMN1000Controller.php
 */
class CMN1000Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	
	// 使用するモデル
	public $uses = ['Notification', 'User', 'InvalidAccess'];
	
	public function index() {
		$this->set("title_for_layout","ログイン"); 
		
		$this->set('failures', $this->InvalidAccess->validate($this->request->clientIp(false)));
		$this->set('notifications', $this->Notification->getNotification());
	}
	
	public function login() {
		if ($this->request->is('post')) {
			//$this->log($this->request, LOG_DEBUG);
			$user = $this->User->login($this->request->data('txtLoginId'), $this->request->data('txtPassword'));
			if(empty($user)){
				$this->InvalidAccess->save(['InvalidAccess' => ['CLIENT_IP' => $this->request->clientIp(false), 'ACCESS_DATETIME' => DboSource::expression('NOW()')] ]);
				$this->setError('ログインできません。ユーザＩＤ、パスワードを確認してください。(ERR_CMN1000_01)');
			} else {
				$this->InvalidAccess->deleteAll(['InvalidAccess.CLIENT_IP' => $this->request->clientIp(false)], false);
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
