<?php
class MNG1000Controller extends AppController
{
	public $helpers = ['Html', 'Form'];
	public $uses = ['User', 'TransactionManager'];
	public $components = ['Security'];

	public function beforeFilter()
	{
		$this->Security->requirePost(['add', 'delete', 'insert', 'update', 'cancel']);
		$this->Security->blackHoleCallback = 'blackhole';

		if (!$this->checkAuth(true)) {
			return;
		}
	}

	public function blackhole($type)
	{
		$this->setAlertMessage('予期しないエラーが発生しました。', 'error');
		$this->redirect(['controller' => 'MNG1000', 'action' => 'index']);
	}

	public function index()
	{
		$users = $this->User->findAll();
		$this->Session->write('MNG1000_users', $users);

		$this->set('title_for_layout', 'ユーザ管理:一覧');
		$this->set('users', $users);
		$this->render('index');
	}

	public function add()
	{
		$token = $this->getNewToken();
		$emptyUser = [
			'ID'		   => null,
			'REVISION'	   => null,
			'USER_ID'	   => '',
			'NAME'		   => '',
			'NAME_KANA'	   => '',
			'COMMENT'	   => '',
			'EMPLOYEE_NUM' => '',
			'MAIL_ADDRESS' => '',
		];
		$this->Session->write('MNG1000_' . $token, $emptyUser);
		$this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
	}

	public function edit()
	{
		if ($this->request->is('post')) {
			$this->postEdit();
		} else {
			$this->getEdit();
		}
	}

	public function postEdit()
	{
		$userId = $this->request->data('txtTargetUserId');
		if (is_null($userId)) {
			throw new BadRequestException('ユーザIDが未指定です。');
		}

		$userOfSession = $this->getUserFromSession($userId);
		if (is_null($userOfSession)) {
			throw new BadRequestException('指定されたユーザIDがセッションのユーザ一覧に存在しません。');
		}

		$token = $this->getNewToken();
		$targetUser = [
			'ID'		   => $userOfSession['User']['ID'],
			'REVISION'	   => $userOfSession['User']['REVISION'],
			'USER_ID'	   => $userOfSession['User']['USER_ID'],
			'NAME'		   => $userOfSession['User']['NAME'],
			'NAME_KANA'	   => $userOfSession['User']['NAME_KANA'],
			'COMMENT'	   => $userOfSession['User']['COMMENT'],
			'EMPLOYEE_NUM' => $userOfSession['User']['EMPLOYEE_NUM'],
			'MAIL_ADDRESS' => $userOfSession['User']['MAIL_ADDRESS'],
		];
		$this->Session->write('MNG1000_' . $token, $targetUser);
		$this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
	}

	public function getEdit()
	{
		$token = $this->requet->query('t');
		if (is_null($token)) {
			throw new NotFoundException('トークンが未指定です。');
		}

		$targetUser = $this->Session->read('MNG1000_' . $token);
		if (is_null($targetUser)) {
			$this->setAlertMessage('対象ユーザの編集は完了しています。', 'notice');
			$this->redirect(['action' => 'index']);
			return;
		}

		$this->set('title_for_layout', 'ユーザ管理:編集');
		$this->set('user', $targetUser);
		$this->set('token', $token);
		$this->render('edit');
	}

	public function delete()
	{
		$userId = $this->request->data('txtTargetUserId');
		if (is_null($userId)) {
			throw new BadRequestException('ユーザIDが未指定です。');
		}

		$userOfSession = $this->getUserFromSession($userId);
		if (is_null($userOfSession)) {
			throw new BadRequestException('指定されたユーザIDがセッションのユーザ一覧に存在しません。');
		}

		try {
			$this->TransactionManager->begin();

			$userOfDb = $this->User->findById($userOfSession['User']['ID'], true);
			if ($userOfDb == null) {
				$this->setAlertMessage('削除対象のユーザは存在しません。', 'error');
				throw new Exception();
			}

			if ($userOfDb['User']['REVISION'] !== $userOfSession['User']['REVISION']) {
				$this->setAlertMessage('削除対象のユーザは更新されているため削除できませんでした。', 'error');
				throw new Exception();
			}

			$updateValue = [
				'STATE'		   => 1,
				'UPD_DATETIME' => $this->getNow(),
				'UPD_USER_ID'  => $this->Session->read('loginUserId'),
				'REVISION'	   => $userOfDb['User']['REVISION'] + 1
			];
			$userOfDb['User'] = array_replace($userOfDb['User'], $updateValue);
			if (!$this->User->save($userOfDb, false, array_keys($updateValue))) {
				$this->setAlertMessage('ユーザを削除できませんでした。', 'error');
				throw new Exception();
			}

			$this->TransactionManager->commit();
			$this->setAlertMessage(sprintf('%sを削除しました。', $userOfDb['User']['USER_NAME']), 'success');
		} catch (Exception $e) {
			$this->TransactionManager->rollback();
		}
		$this->redirect(['action' => 'index']);
	}

	public function insert()
	{
		$token = $this->requet->data('txtToken');
		if (is_null($token)) {
			throw new BadRequestException('トークンが未指定です。');
		}

		if (!$this->Session->check('MNG1000_' . $token)) {
			$this->setAlertMessage('対象ユーザの編集は完了しています。', 'notice');
			$this->redirect(['action' => 'index']);
			return;
		}
		$targetUser = $this->Session->read('MNG1000_' . $token);

		$inputValue = [
			'USER_ID'	   => $this->request->data('txtUserId')		 ?: '',
			'NAME'		   => $this->request->data('txtName')		 ?: '',
			'NAME_KANA'	   => $this->request->data('txtNameKana')	 ?: '',
			'COMMENT'	   => $this->request->data('txtComment')	 ?: '',
			'EMPLOYEE_NUM' => $this->request->data('txtEmployeeNum') ?: '',
			'MAIL_ADDRESS' => $this->request->data('txtMailAddress') ?: '',
		];

		$targetUser = array_replace($targetUser, $inputValue);
		$this->Session->write(self::FUNCTION_NAME . $token, $targetUser);

		$this->User->set(['User' => $targetUser]);
		if (!$this->User->validates(['fieldList' => array_keys($inputValue)])) {
			$this->setAlertMessages($this->User->validationErrors, 'error');
			$this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
			return;
		}

		try {
			$this->TransactionManager->begin();

			if (!$this->User->save($userOfDb, false, array_keys($inputValue))) {
				$this->setAlertMessage('ユーザを登録できませんでした。', 'error');
				throw new Exception();
			}

			$this->TransactionManager->commit();
			$this->setAlertMessage(sprintf('%sを登録しました。', $userOfDb['User']['USER_NAME']), 'success');
			$this->Session->delete(self::FUNCTION_NAME . $token);
			$this->redirect(['action' => 'index']);
		} catch (Exception $e) {
			$this->TransactionManager->rollback();
			$this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
		}
	}

	public function update()
	{
		$token = $this->requet->data('txtToken');
		if (is_null($token)) {
			throw new BadRequestException('トークンが未指定です。');
		}

		if (!$this->Session->check('MNG1000_' . $token)) {
			$this->setAlertMessage('対象ユーザの編集は完了しています。', 'notice');
			$this->redirect(['action' => 'index']);
			return;
		}
		$userOfSession = $this->Session->read('MNG1000_' . $token);

		$inputValue = [
			'NAME'		   => $this->request->data('txtName')		 ?: '',
			'NAME_KANA'	   => $this->request->data('txtNameKana')	 ?: '',
			'COMMENT'	   => $this->request->data('txtComment')	 ?: '',
			'EMPLOYEE_NUM' => $this->request->data('txtEmployeeNum') ?: '',
			'MAIL_ADDRESS' => $this->request->data('txtMailAddress') ?: '',
		];

		$userOfSession = array_replace($userOfSession, $inputValue);
		$this->Session->write(self::FUNCTION_NAME . $token, $userOfSession);

		$this->User->set(['User' => $userOfSession]);
		if (!$this->User->validates(['fieldList' => array_keys($inputValue)])) {
			$this->setAlertMessages($this->User->validationErrors, 'error');
			$this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
			return;
		}

		try {
			$this->TransactionManager->begin();

			$userOfDb = $this->User->findById($userOfSession['ID']);
			if (is_null($userOfDb)) {
				$this->setAlertMessage('更新対象のユーザが存在しません。', 'error');
				throw new Exception();
			}

			if ($userOfSession['REVISION'] !== $userOfDb['User']['REVISION']) {
				$this->setAlertMessage(sprintf('%sは別プロセスで変更されているため更新できません。', $userOfDb['User']['USER_NAME']), 'error');
				throw new Exception();
			}

			$userOfDb['User'] = array_replace($userOfDb['User'], $inputValue);
			if (!$this->User->save($userOfDb, false, array_keys($inputValue))) {
				$this->setAlertMessage('ユーザを登録できませんでした。', 'error');
				throw new Exception();
			}

			$this->TransactionManager->commit();
			$this->setAlertMessage(sprintf('%sを更新しました。', $userOfDb['User']['USER_NAME']), 'success');
			$this->Session->delete(self::FUNCTION_NAME . $token);
			$this->redirect(['action' => 'index']);
		} catch (Exception $e) {
			$this->TransactionManager->rollback();
			$this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
		}
	}

	public function getNewToken()
	{
		$token = uniqid();
		$session = $this->Session->read(self::FUNCTION_NAME);
		if ($session == null) {
			return $token;
		}

		while (array_key_exists($token, $session)) {
			$token = uniqid();
		}
		return $token;
	}

	public function saveUser($user)
	{
		return $this->User->save($user, false);
	}

	public function getUserFromSession($userId)
	{
		$session = $this->Session->read('CMN2000');
		$users = $session['Users'];
		foreach ($users as $user) {
			if ($user['User']['USER_ID'] == $userId) {
				return $user;
			}
		}
		return null;
	}

	public function getNow()
	{
		return date('Y-m-d H:i:s');
	}
}
