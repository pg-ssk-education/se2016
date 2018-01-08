<?php
class CMN1000Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	public $uses = ['Notification', 'User', 'InvalidAccess'];

	public function index() {
		// すでにログイン済みの場合はトップページへ遷移
		if ($this->logined()) {
//			$this->redirect(['controller'=>'CMN1010', 'action'=>'index']);
		}

		$this->set('title_for_layout', 'ログイン');
		$this->set('notifications',
			$this->Notification->findAllByTargetUserId('', null, ['Notification.UPD_DATETIME' => 'desc']));
		$this->set('invalidAccessCount',
			$this->InvalidAccess->findCountByClientIpOnLastOneMinute($this->getClientIp()));
	}

	public function login() {
		if ($this->request->is('post')) {
			// 不用データが蓄積されないよう、1分以上前の不正アクセスはクリア
			$this->InvalidAccess->deleteOverOneMinute();

			$user = $this->User->findByUserIdAndPassword(
				$this->request->data('txtLoginId'), $this->request->data('txtPassword'));
			if (empty($user)) {
				$this->InvalidAccess->saveClientIp($this->getClientIp());
				/*
				$this->Session->setFlash(
					'ログインできません。ユーザＩＤ、パスワードを確認してください。', 'flash_alert', [], 'alert');
				*/
				parent::setAlertMessage('ログインできません。ユーザＩＤ、パスワードを確認してください。', 'error');
				$this->redirect(['controller' => 'CMN1000', 'action' => 'index']);
				return;
			}

			$this->InvalidAccess->deleteAll(
				['InvalidAccess.CLIENT_IP' => $this->getClientIp()], false);

			// ログイン処理
			$this->Session->write('loginUserId', $this->request->data('txtLoginId'));

			$this->redirect(['controller' => 'CMN1010', 'action' => 'index']);
			return;
		}

		$this->redirect(['controller' => 'CMN1000', 'action' => 'index']);
	}

	public function getClientIp() {
		return $this->request->clientIp(false);
	}
}
