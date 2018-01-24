<?php
class CMN2000Controller extends AppController {
	public $helpers = array('Html', 'Form');
	
	// 使用するモデル
	public $uses = ['User'];

	public function index() {
		parent::checkLogin();
		$this->set('title_for_layout', 'ユーザ管理');
		$users = $this->User->findAll();
		$session = ['Users' => $users];
		$this->Session->write('CMN2000', $session);
		$this->set('users', $users);
	}
	
	public function action() {
	}
	
	public function add() {
		edit();
	}
	
	public function edit() {
		$userId = $this->params['named']['id'];
		if (empty($userId)) {
			$this->set('title_for_layout', 'ユーザ登録');
		} else {
			$this->set('title_for_layout', 'ユーザ編集');
		}
		$user = $this->User->findByUserId($userId);
		$this->set('user', $user);
	}
	
	public function delete() {
		// ToDo NULLチェック。 ぬるぽ、がっ
		parent::checkLogin();
		$userId = $this->params['named']['id'];
		$userOfDb = $this->User->findByUserId($userId);
		$session = $this->Session->read('CMN2000');
		$users = $session['Users'];
		
		$userOfSession = null;
		foreach ($users as $user) {
			if ($user['User']['USER_ID'] == $userId) {
				$userOfSession = $user;
				break;
			}
		}
		
		if ($userOfSession != null) {
			if ($userOfDb['User']['ROW_NUM'] == $userOfSession['User']['ROW_NUM']) {
				if ($userOfDb['User']['REVISION'] == $userOfSession['User']['REVISION']) {
					$userOfDb['User']['STATE'] = 1;
					$userOfDb['User']['UPD_DATETIME'] = DboSource::expression('NOW()');
					$userOfDb['User']['UPD_USER_ID'] = $this->Session->read('loginUserId');
					$userOfDb['User']['REVISION'] = $userOfDb['User']['REVISION'] + 1;
					$this->User->save($userOfDb);
					
					parent::setAlertMessage('削除しました。', 'success');
					$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
				} else {
					parent::setAlertMessage('対象のユーザは更新されています。', 'error');
					$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
				}
			} else {
				// ToDo データベース不整合を通知すること
			}
		}
		parent::setAlertMessage('対象のユーザは存在しません。', 'error');
		$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
	}
}
