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
		
		// ログインを3回失敗するとログイン画面を1分間ロックする
		$this->set('failures', $this->InvalidAccess->validate($this->request->clientIp(false)));
		// インフォメーションを取得する
		$this->set('notifications', $this->Notification->getNotification(""));
	}
	
	public function login() {
		if ($this->request->is('post')) {
			
			// アクセス日時が1時間以上前のログイン失敗記録を削除する。
			$this->InvalidAccess->deleteAll(['InvalidAccess.ACCESS_DATETIME <= NOW() - INTERVAL 60 MINUTE'], false);
			
			// ログインを試行する。
			$user = $this->User->login($this->request->data('txtLoginId'), $this->request->data('txtPassword'));
			
			if(empty($user)){
				// ログインの失敗を記録する。
				$this->InvalidAccess->save(['InvalidAccess' => [
					'ACCESS_ID' => DboSource::expression('UUID()'), 
					'CLIENT_IP' => $this->request->clientIp(false), 
					'ACCESS_DATETIME' => DboSource::expression('NOW()'),
					'INS_USER_ID' => $this->request->data('txtLoginId'),
					'UPD_USER_ID' => $this->request->data('txtLoginId'),
				]]);
				
				$this->setError('ログインできません。ユーザＩＤ、パスワードを確認してください。(ERR_CMN1000_01)');
			} else {
			
				// ログインの失敗を削除する。
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
