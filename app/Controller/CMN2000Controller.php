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

	public function insert() {
		parent::checkLogin();
		$userId = $this->request->data('txtUserId');
		$userOfDb = $this->User->findByUserId($userId);
		if ($userOfDb != null) {
			parent::setAlertMessage('登録対象のユーザは既に存在します。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
			// ToDo 登録画面に戻って、入力値をセットする。
		}
		$userOfDb = [
			'User'=>[
				'USER_ID' => $userId,
				'NAME' => $this->request->data('txtName'),
				'NAME_KANA' => $this->request->data('txtNameKana'),
				'COMMENT' => $this->request->data('txtComment'),
				'EMPLOYEE_NUM' => $this->request->data('txtEmployeeNum'),
				'MAIL_ADDRESS' => $this->request->data('txtMailAddress'),
				'INS_USER_ID' => $this->Session->read('loginUserId'),
				'UPD_USER_ID' => $this->Session->read('loginUserId')
			]
		];
		$this->User->save($userOfDb);
		parent::setAlertMessage('登録しました。', 'success');
		$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
	}

	public function update() {
		parent::checkLogin();
		$userId = $this->request->data('hidUserId');
		$userOfDb = $this->User->findByUserId($userId);
		
		$userOfSession = $this->getUserFromSession($userId);
		
		if ($userOfSession != null) {
			if ($userOfDb['User']['ROW_NUM'] == $userOfSession['User']['ROW_NUM']) {
				if ($userOfDb['User']['REVISION'] != $userOfSession['User']['REVISION']) {
					parent::setAlertMessage('更新対象のユーザは更新されています。', 'error');
					$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
				}

				$userOfDb['User']['NAME'] = $this->request->data('txtName');
				$userOfDb['User']['NAME_KANA'] = $this->request->data('txtNameKana');
				$userOfDb['User']['COMMENT'] = $this->request->data('txtComment');
				$userOfDb['User']['EMPLOYEE_NUM'] = $this->request->data('txtEmployeeNum');
				$userOfDb['User']['MAIL_ADDRESS'] = $this->request->data('txtMailAddress');
				$userOfDb['User']['UPD_DATETIME'] = DboSource::expression('NOW()');
				$userOfDb['User']['UPD_USER_ID'] = $this->Session->read('loginUserId');
				$userOfDb['User']['REVISION'] = $userOfDb['User']['REVISION'] + 1;
				
				$this->User->save($userOfDb);
				
				parent::setAlertMessage('更新しました。', 'success');
				$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
			} else {
				// ToDo データベース不整合を通知すること
			}
		}
		parent::setAlertMessage('更新対象のユーザは存在しません。', 'error');
		$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
	}
	
	public function add() {
		parent::checkLogin();
		$this->set('title_for_layout', 'ユーザ登録');
		$this->set('user', null);
		$this->set('action', 'insert');
		$this->render('edit');
	}
	
	public function edit() {
		parent::checkLogin();
		$this->set('title_for_layout', 'ユーザ編集');
		$userId = $this->params['named']['id'];
		$user = $this->User->findByUserId($userId);
		if ($user == null) {
			parent::setAlertMessage('編集対象のユーザは存在しません。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$this->set('user', $user);
		$this->set('action', 'update');
	}
	
	public function delete() {
		// ToDo NULLチェック。 ぬるぽ、がっ
		parent::checkLogin();
		$userId = $this->params['named']['id'];
		$userOfDb = $this->User->findByUserId($userId);
		
		$userOfSession = $this->getUserFromSession($userId);
		
		if ($userOfSession != null) {
			if ($userOfDb['User']['ROW_NUM'] == $userOfSession['User']['ROW_NUM']) {
				if ($userOfDb['User']['REVISION'] != $userOfSession['User']['REVISION']) {
					parent::setAlertMessage('削除対象のユーザは更新されています。', 'error');
					$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
				}
				$userOfDb['User']['STATE'] = 1;
				$userOfDb['User']['UPD_DATETIME'] = DboSource::expression('NOW()');
				$userOfDb['User']['UPD_USER_ID'] = $this->Session->read('loginUserId');
				$userOfDb['User']['REVISION'] = $userOfDb['User']['REVISION'] + 1;
				$this->User->save($userOfDb);
					
				parent::setAlertMessage('削除しました。', 'success');
				$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
			} else {
				// ToDo データベース不整合を通知すること
			}
		}
		parent::setAlertMessage('削除対象のユーザは存在しません。', 'error');
		$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
	}
	
	public function getUserFromSession($userId) {
		$session = $this->Session->read('CMN2000');
		$users = $session['Users'];
		foreach ($users as $user) {
			if ($user['User']['USER_ID'] == $userId) {
				return $user;
			}
		}
		return null;
	}
}
