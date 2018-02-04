<?php
class CMN2000Controller extends AppController {

	public $helpers = ['Html', 'Form'];
	public $uses = ['User'];
	public $components = ['Security'];

	public function beforeFilter() {
		$this->Security->requirePost(['insert', 'update']);
		$this->Security->blackHoleCallback = 'blackhole';
	}

	public function blackhole($type) {
		$this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
		$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
	}

	public function index() {
		$this->checkLogin();

		$users = $this->User->findAll();
		$session = $this->Session->read('CMN2000');
		if ($session == null) {
			$session = [];
		}
		$session = array_replace($session, ['Users' => $users]);
		$this->Session->write('CMN2000', $session);

		$this->set('title_for_layout', 'ユーザ管理:一覧');
		$this->set('users', $users);
	}

	public function add() {
		$this->checkLogin();

		$user = [
			'User' => [
				'USER_ID'      => '',
				'NAME'         => '',
				'NAME_KANA'    => '',
				'COMMENT'      => '',
				'EMPLOYEE_NUM' => '',
				'MAIL_ADDRESS' => '',
			]
		];
		$session = $this->Session->read('CMN2000');
		if ($session == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$token = uniqid();
		$session = array_replace($session, [$token => $user]);
		$this->Session->write('CMN2000', $session);
		$this->redirect(['controller' => 'CMN2000', 'action' => 'adduser', 'id' => $token]);
	}

	public function adduser() {
		$this->checkLogin();

		$token = $this->params['named']['id'];
		if ($token == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$session = $this->Session->read('CMN2000');
		if ($session == null || $session[$token] == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$user = $session[$token];

		$this->set('title_for_layout', 'ユーザ管理:登録');
		$this->set('user', $user);
		$this->set('action', 'insert');
		$this->set('token', $token);
		$this->render('edit');
	}

	public function insert() {
		$this->checkLogin();

		$token = $this->params['named']['id'];
		if ($token == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		$session = $this->Session->read('CMN2000');
		if ($session == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		$user = [
			'User' => [
				'USER_ID'      => $this->request->data('txtUserId')      ?: '',
				'NAME'         => $this->request->data('txtName')        ?: '',
				'NAME_KANA'    => $this->request->data('txtNameKana')    ?: '',
				'COMMENT'      => $this->request->data('txtComment')     ?: '',
				'EMPLOYEE_NUM' => $this->request->data('txtEmployeeNum') ?: '',
				'MAIL_ADDRESS' => $this->request->data('txtMailAddress') ?: '',
			]
		];

		$session = array_replace($session, [$token => $user]);
		$this->Session->write('CMN2000', $session);

		$this->User->set($user);
		if (!$this->User->validates()) {
			$this->setAlertMessage($this->User->validationErrors, 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'adduser', 'id' => $token]);
		}

		if ($this->User->findByUserId($user['User']['USER_ID']) != null) {
			$this->setAlertMessage('ユーザIDが重複しています。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'adduser', 'id' => $token]);
		}
		if ($this->User->findDeletedByUserId($user['User']['USER_ID']) != null) {
			$this->setAlertMessage('削除されたユーザとユーザIDが重複しています。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'adduser', 'id' => $token]);
		}

		$user['User'] = array_replace($user['User'], [
			'INS_USER_ID'  => $this->Session->read('loginUserId'),
			'UPD_USER_ID'  => $this->Session->read('loginUserId')
		]);
		if (!$this->User->save($user)) {
			$this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'adduser', 'id' => $token]);
		}

		unset($session[$token]);
		$this->Session->write('CMN2000', $session);
		$this->setAlertMessage('登録しました。', 'success');
		$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
	}

	public function edit() {
		$this->checkLogin();

		$userId = $this->params['named']['id'];
		$user = $this->getUserFromSession($userId);
		if ($user == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		$session = $this->Session->read('CMN2000');
		if ($session == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$token = uniqid();
		$session = array_replace($session, [$token => $user]);
		$this->Session->write('CMN2000', $session);
		$this->redirect(['controller' => 'CMN2000', 'action' => 'edituser', 'id' => $token]);
	}

	public function edituser() {
		$this->checkLogin();

		$token = $this->params['named']['id'];
		if ($token == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$session = $this->Session->read('CMN2000');
		if ($session == null || $session[$token] == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$user = $session[$token];

		$this->set('title_for_layout', 'ユーザ管理:編集');
		$this->set('user', $user);
		$this->set('action', 'update');
		$this->set('token', $token);
		$this->render('edit');
	}

	public function update() {
		$this->checkLogin();

		$token = $this->params['named']['id'];
		if ($token == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		$session = $this->Session->read('CMN2000');
		if ($session == null || $session[$token] == null) {
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		$user = $session[$token];
		$user['User'] = array_replace($user['User'], [
			'NAME'         => $this->request->data('txtName')        ?: '',
			'NAME_KANA'    => $this->request->data('txtNameKana')    ?: '',
			'COMMENT'      => $this->request->data('txtComment')     ?: '',
			'EMPLOYEE_NUM' => $this->request->data('txtEmployeeNum') ?: '',
			'MAIL_ADDRESS' => $this->request->data('txtMailAddress') ?: '',
		]);

		$session = array_replace($session, [$token => $user]);
		$this->Session->write('CMN2000', $session);

		$userOfDb = $this->User->findByUserId($user['User']['USER_ID']);
		if ($userOfDb == null) {
			$this->setAlertMessage('更新対象のユーザは削除されています。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		if ($user['User']['ROW_NUM'] != $userOfDb['User']['ROW_NUM'] || $user['User']['REVISION'] != $userOfDb['User']['REVISION']) {
			$this->setAlertMessage('更新対象のユーザは更新されているため変更できません。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		$this->User->set($user);
		if (!$this->User->validates()) {
			$this->setAlertMessage($this->User->validationErrors, 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'edituser', 'id' => $token]);
		}

		$userOfDb['User'] = array_replace($userOfDb['User'], [
			'NAME'         => $user['User']['NAME'],
			'NAME_KANA'    => $user['User']['NAME_KANA'],
			'COMMENT'      => $user['User']['COMMENT'],
			'EMPLOYEE_NUM' => $user['User']['EMPLOYEE_NUM'],
			'MAIL_ADDRESS' => $user['User']['MAIL_ADDRESS'],
			'UPD_DATETIME' => DboSource::expression('NOW()'),
			'UPD_USER_ID'  => $this->Session->read('loginUserId'),
			'REVISION'     => $userOfDb['User']['REVISION'] + 1
		]);

		if (!$this->User->save($userOfDb)) {
			$this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'edituser', 'id' => $token]);
		}

		unset($session[$token]);
		$this->Session->write('CMN2000', $session);
		$this->setAlertMessage('更新しました。', 'success');
		$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
	}

	public function delete() {
		$this->checkLogin();

		$userId = $this->params['named']['id'];
		if ($userId == null) {
			$this->setAlertMessage('削除対象のユーザが指定されていません。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$userOfDb = $this->User->findByUserId($userId);
		if ($userId == null) {
			$this->setAlertMessage('削除対象のユーザは存在しません。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}
		$userOfSession = $this->getUserFromSession($userId);
		if ($userOfSession == null) {
			$this->setAlertMessage('削除対象のユーザは存在しません。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		if ($userOfDb['User']['ROW_NUM'] != $userOfSession['User']['ROW_NUM'] || $userOfDb['User']['REVISION'] != $userOfSession['User']['REVISION']) {
			$this->setAlertMessage('削除対象ユーザは更新されているため削除できません。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		$userOfDb['User'] = array_replace($userOfDb['User'], [
			'STATE'        => 1,
			'UPD_DATETIME' => DboSource::expression('NOW()'),
			'UPD_USER_ID'  => $this->Session->read('loginUserId'),
			'REVISION'     => $userOfDb['User']['REVISION'] + 1
		]);
		if (!$this->User->save($userOfDb)) {
			$this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
			$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
		}

		$this->setAlertMessage('削除しました。', 'success');
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
