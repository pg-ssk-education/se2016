<?php
class MNG1010Controller extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $uses = ['User', 'TransactionManager'];
    public $components = ['Security'];

	private const FUNCTION_NAME = 'MNG1010';
	private const MSG_INVALID_NAMED_PARAMETER = '名前付きパラメータに%sが設定されていません。';


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
        $this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
    }

    public function index()
    {
        $groups = $this->Group->findAll();

        $this->set('title_for_layout', 'グループ管理:一覧');
        $this->set('groups', $groups);
        $this->render('index');
    }

    public function add()
    {
        $token = $this->getNewToken();
		$emptyGroup = [
			'ID'           => null,
			'REVISION'     => null,
            'GROUP_ID'     => '',
            'NAME'         => '',
		];
		$this->Session->write(self::FUNCTION_NAME . $token, $emptyGroup);
        $this->redirect(['controller' => 'MNG1010', 'action' => 'edit', '?' => ['t' => $token]]);

   	}

    public function edit()
    {
        if ($this->request->is('post')) {
            $this->postEdit();
        } else {
            $this->getEdit();
        }
	}

	public function postEdit() {
		
		$groupId = $this->request->data('txtTargetGroupId');
		if (is_null($groupId)) {
			throw new BadRequestException('グループIDが未指定です。');
		}

		$groupOfSession = $this->getGroupFromSession($groupId);
		if (is_null($groupOfSession)) {
			throw new BadRequestException('指定されたグループIDがセッションのグループ一覧に存在しません。');
		}

        $token = $this->getNewToken();
		$targetGroup = [
			'ID'           => $groupOfSession['Group']['ID'],
			'REVISION'     => $groupOfSession['Group']['REVISION'],
            'GROUP_ID'     => $groupOfSession['Group']['GROUP_ID'],
            'NAME'         => $groupOfSession['Group']['NAME'],
		];
		$this->Session->write(self::FUNCTION_NAME . $token, $targetGroup);
        $this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'edit', '?' => ['t' => $token]]);
	}

	public function getEdit() {
		$token = $this->requet->query('t');
		if (is_null($token)) {
			throw new BadRequestException('トークンが未指定です。');
		}

		$targetGroup = $this->Session->read(self::FUNCTION_NAME . $token);
		if (is_null($targetGroup)) {
			$this->setAlertMessage('対象グループの編集は完了しています。', 'notice');
			$this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
            return;
		}

        $this->set('title_for_layout', 'グループ管理:編集');
        $this->set('group', $targetGroup);
        $this->set('token', $token);
        $this->render('edit');
	}

    public function delete()
    {
		$groupId = $this->request->data('txtTargetGroupId');
		if (is_null($groupId)) {
			throw new BadRequestException('グループIDが未指定です。');
		}

		$groupOfSession = $this->getGroupFromSession($groupId);
		if (is_null($groupOfSession)) {
			throw new BadRequestException('指定されたグループIDがセッションのグループ一覧に存在しません。');
		}

        try {
            $this->TransactionManager->begin();

            $groupOfDb = $this->Group->findById($groupOfSession['Group']['GROUP_ID'], true);
            if ($groupOfDb == null) {
                $this->setAlertMessage('削除対象のグループは存在しません。', 'error');
				$this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
				return;
            }

            if ($groupOfDb['Group']['REVISION'] !== $groupOfSession['Group']['REVISION']) {
                $this->setAlertMessage('削除対象のグループは更新されているため削除できません。', 'error');
				$this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
				return;
            }

			$updateValue = [
				'STATE'        => 1,
				'UPD_DATETIME' => $this->getNow(),
				'UPD_USER_ID'  => $this->Session->read('loginUserId'),
				'REVISION'     => $groupOfDb['Group']['REVISION'] + 1
			]
			$groupOfDb['Group'] = array_replace($groupOfDb['Group'], $updateValue);
			if (!$this->Group->save($groupOfDb, false, array_keys($updateValue))) {
				$this->setAlertMessage('グループを削除できませんでした。', 'error');
                throw new Exception();
			}

            $this->TransactionManager->commit();
			$this->setAlertMessage(sprintf('%sを削除しました。',$groupOfDb['Group']['GROUP_ID']), 'success');
        } catch (Exception $e) {
            $this->TransactionManager->rollback();
        }
		$this->redirect(['action' => 'index']);
    }

	public function insert() {
		$token = $this->requet->query('t');
		if (is_null($token)) {
			throw new BadRequestException('トークンが未指定です。');
		}

		if (!$this->Session->check(self::FUNCTION_NAME . $token)) {
			$this->setAlertMessage('グループ情報が未登録です。', 'notice');
			$this->redirect(['action' => 'index']);
            return;
		}
		$targetGroup = $this->Session->read(self::FUNCTION_NAME . $token);

		$inputValue = [
			'ID'           => $this->request->data('txtId')      ?: '',
            'GROUP_ID'     => $this->request->data('txtGroupId') ?: '',
            'NAME'         => $this->request->data('txtName')    ?: '',
            'COMMENT'      => $this->request->data('txtComment') ?: '',
		];

		$targetGroup = array_replace($targetGroup, $inputValue);
		$this->Session->write(self::FUNCTION_NAME . $token, $targetGroup);

		$this->Group->set(['Group' => $targetGroup]);
		if (!$this->User->validates(['fieldList' => array_keys($inputValue)])) {
			$this->setAlertMessages($this->Group->validationErrors, 'error');
            $this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
            return;
		}

		try {
            $this->TransactionManager->begin();

			if (!$this->User->save($userOfDb, false, array_keys($inputValue))) {
				$this->setAlertMessage('グループを登録できませんでした。', 'error');
                throw new Exception();
			}

            $this->TransactionManager->commit();
			$this->setAlertMessage(sprintf('%sを登録しました。',$userOfDb['User']['USER_NAME']), 'success');
			$this->Session->delete(self::FUNCTION_NAME . $token);
			$this->redirect(['action' => 'index']);
        } catch (Exception $e) {
            $this->TransactionManager->rollback();
			$this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
        }
	}





		if (isset($session[$token]['ID'])) {
			$this->update($inputValue, $session, $token);
		} else {
			$this->insert($inputValue, $session, $token);
		}

        if ($session == null) {
			throw new InternalErrorException('セッション変数が存在しません。');
        }

		if (!array_key_exists($token, $session])) {
			$this->setAlertMessage('対象ユーザの編集は完了しています。', 'notice');
			$this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
            return;
		}

		$inputValue = [
			'USER_ID'      => $this->request->data('txtUserId')      ?: '',
            'NAME'         => $this->request->data('txtName')        ?: '',
            'NAME_KANA'    => $this->request->data('txtNameKana')    ?: '',
            'COMMENT'      => $this->request->data('txtComment')     ?: '',
            'EMPLOYEE_NUM' => $this->request->data('txtEmployeeNum') ?: '',
            'MAIL_ADDRESS' => $this->request->data('txtMailAddress') ?: '',
		];

		$session[$token] = array_replace($session[$token], $inputValue);
		$this->Session->write(self::FUNCTION_NAME, $session);

		$this->User->set(['User' => $inputValue]);
        if (!$this->User->validates(['fieldList' => array_keys($inputValue)])) {
        }

	}

	private function redirectToIndex($token) {
		$session = $this->Session->read(self::FUNCTION_NAME);
		if (isset($session)) {

		}
		if ($session == null) {
			throw new InternalErrorException('セッション変数が存在しません。');
		}

	}

	private function update($inputValue, $session, $token) {
		try {
			$this->TransactionManager->begin();

			$userOfDb = $this->User->findById($session[$token]['ID'], true);
			if ($userOfDb == null) {
				$this->setAlertMessage('更新対象のユーザは削除されています。', 'error');
				$this->redirect(['controller' => $, 'action' => 'index']);
				throw new Exception();
			}

			if ($user['User']['ROW_NUM'] != $userOfDb['User']['ROW_NUM'] || $user['User']['REVISION'] != $userOfDb['User']['REVISION']) {
				$this->setAlertMessage('更新対象のユーザは更新されているため変更できません。', 'error');
				$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
				throw new Exception();
			}

			$this->User->set($user);
			if (!$this->User->validates()) {
				$this->setAlertMessage($this->User->validationErrors, 'error');
				$this->redirect(['controller' => 'CMN2000', 'action' => 'edituser', 'id' => $token]);
				throw new Exception();
			}

			$userOfDb['User'] = array_replace($userOfDb['User'], [
				'NAME'         => $user['User']['NAME'],
				'NAME_KANA'    => $user['User']['NAME_KANA'],
				'COMMENT'      => $user['User']['COMMENT'],
				'EMPLOYEE_NUM' => $user['User']['EMPLOYEE_NUM'],
				'MAIL_ADDRESS' => $user['User']['MAIL_ADDRESS'],
				'UPD_DATETIME' => $this->getNow(),
				'UPD_USER_ID'  => $this->Session->read('loginUserId'),
				'REVISION'     => $userOfDb['User']['REVISION'] + 1
			]);

			if (!$this->saveUser($userOfDb)) {
				$this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
				$this->redirect(['controller' => 'CMN2000', 'action' => 'edituser', 'id' => $token]);
				throw new Exception();
			}

			$this->TransactionManager->commit();
		} catch (Exception $e) {
			$this->TransactionManager->rollback();
			return;
		}

		unset($session[$token]);
		$this->Session->write('CMN2000', $session);
		$this->setAlertMessage('更新しました。', 'success');
		$this->redirect(['controller' => 'CMN2000', 'action' => 'index']);

	}




		$userOfSession = $this->getUserFromSession($userId);
		if (is_null($userId)) {
			throw new BadRequestException('指定されたユーザIDがユーザ一覧に存在しません。');
		}



        $session = array_replace($session, [$token => $user]);
        $this->Session->write('CMN2000', $session);



	}







//        if (!array_key_exists('t', $this->params['named'])) {
//            $this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
//            return;
//        }
//        $token = $this->params['named']['t'];
        $token = $this->params['named']['t'];
        if (!isset($token)) {
            $this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
            return;
        }
        $session = $this->Session->read(self::FUNCTION_NAME);
        if ($session == null || !array_key_exists($token, $session)) {
            $this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
            return;
        }

        $this->set('title_for_layout', 'ユーザ管理:編集');
        $this->set('method', $session[$token]['method']);
		$this->set('user', $session[$token]['user']);
        $this->set('token', $token);
        $this->render('edit');
    }

    public function save() {
        if (!$this->checkLoggedIn()) {
            return;
        }

        $token = $this->params['named']['t'];
        if (!isset($token)) {
            $this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
            return;
        }
        $session = $this->Session->read(self::FUNCTION_NAME);
        if ($session == null || !array_key_exists($token, $session)) {
            $this->redirect(['controller' => self::FUNCTION_NAME, 'action' => 'index']);
            return;
        }
        $user = $session[$token];

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




            if ($this->request->is('post')) {
                $this->postAdd();
            } else {
                $this->getAdd();
            }
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

    public function insert()
    {
        if (!$this->checkLogin()) {
            return;
        }

        if (!array_key_exists('id', $this->params['named'])) {
            $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
            return;
        }
        $token = $this->params['named']['id'];

        $session = $this->Session->read('CMN2000');
        if ($session == null) {
            $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
            return;
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
            return;
        }

        try {
            $this->TransactionManager->begin();

            if ($this->User->findByUserId($user['User']['USER_ID']) != null) {
                $this->setAlertMessage('ユーザIDが重複しています。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'adduser', 'id' => $token]);
                throw new Exception();
            }
            if ($this->User->findDeletedByUserId($user['User']['USER_ID']) != null) {
                $this->setAlertMessage('削除されたユーザとユーザIDが重複しています。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'adduser', 'id' => $token]);
                throw new Exception();
            }

            $user['User'] = array_replace($user['User'], [
                'INS_USER_ID'  => $this->Session->read('loginUserId'),
                'UPD_USER_ID'  => $this->Session->read('loginUserId')
            ]);
            if (!$this->saveUser($user)) {
                $this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'adduser', 'id' => $token]);
                throw new Exception();
            }
            $this->TransactionManager->commit();
        } catch (Exception $e) {
            $this->TransactionManager->rollback();
            return;
        }

        unset($session[$token]);
        $this->Session->write('CMN2000', $session);
        $this->setAlertMessage('登録しました。', 'success');
        $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
    }

    public function saveUser($user)
    {
        return $this->User->save($user, false);
    }

    public function update()
    {
        if (!$this->checkLogin()) {
            return;
        }

        if (!array_key_exists('id', $this->params['named'])) {
            $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
            return;
        }

        $token = $this->params['named']['id'];
        $session = $this->Session->read('CMN2000');
        if ($session == null || !array_key_exists($token, $session)) {
            $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
            return;
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

        try {
            $this->TransactionManager->begin();

            $userOfDb = $this->User->findByUserId($user['User']['USER_ID'], true);
            if ($userOfDb == null) {
                $this->setAlertMessage('更新対象のユーザは削除されています。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
                throw new Exception();
            }

            if ($user['User']['ROW_NUM'] != $userOfDb['User']['ROW_NUM'] || $user['User']['REVISION'] != $userOfDb['User']['REVISION']) {
                $this->setAlertMessage('更新対象のユーザは更新されているため変更できません。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
                throw new Exception();
            }

            $this->User->set($user);
            if (!$this->User->validates()) {
                $this->setAlertMessage($this->User->validationErrors, 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'edituser', 'id' => $token]);
                throw new Exception();
            }

            $userOfDb['User'] = array_replace($userOfDb['User'], [
                'NAME'         => $user['User']['NAME'],
                'NAME_KANA'    => $user['User']['NAME_KANA'],
                'COMMENT'      => $user['User']['COMMENT'],
                'EMPLOYEE_NUM' => $user['User']['EMPLOYEE_NUM'],
                'MAIL_ADDRESS' => $user['User']['MAIL_ADDRESS'],
                'UPD_DATETIME' => $this->getNow(),
                'UPD_USER_ID'  => $this->Session->read('loginUserId'),
                'REVISION'     => $userOfDb['User']['REVISION'] + 1
            ]);

            if (!$this->saveUser($userOfDb)) {
                $this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'edituser', 'id' => $token]);
                throw new Exception();
            }

            $this->TransactionManager->commit();
        } catch (Exception $e) {
            $this->TransactionManager->rollback();
            return;
        }

        unset($session[$token]);
        $this->Session->write('CMN2000', $session);
        $this->setAlertMessage('更新しました。', 'success');
        $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
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
