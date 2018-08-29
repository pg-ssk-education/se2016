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
            'GROUP_ID'  => $this->request->data('txtGroupId')    ?: '',
            'NAME'      => $this->request->data('txtName') ?: '',
            'COMMENT'   => $this->request->data('txtComment') ?: ''
		];

		$targetGroup = array_replace($targetGroup, $inputValue);
		$this->Session->write(self::FUNCTION_NAME . $token, $targetGroup);

		$group = $this->Group->create();
        $group['Group']['GROUP_ID'] = $inputValue['GROUP_ID'];
        $user['Group']['NAME'] = $inputValue['NAME'];
        $user['Group']['COMMENT'] = $inputValue['COMMENT'];

		$this->Group->set(['Group' => $targetGroup]);
		if (!$this->User->validates(['fieldList' => array_keys($inputValue)])) {
			$this->setAlertMessages($this->Group->validationErrors, 'error');
            $this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
            return;
		}

		try {
			$this->TransactionManager->begin();

			$groupOfDb = ['Group' => $inputValue];
			
			if (!$this->Group->save($groupOfDb, false, array_keys($inputValue))) {
				$this->setAlertMessage('グループを登録できませんでした。', 'error');
				throw new Exception();
			}

			$this->TransactionManager->commit();
			$this->setAlertMessage(sprintf('%sを登録しました。', $groupOfDb['Group']['NAME']), 'success');
			$this->Session->delete(self::FUNCTION_NAME . $token);
			$this->redirect(['action' => 'index']);
		} catch (Exception $e) {
			$this->TransactionManager->rollback();
			$this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
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

			$groupOfDb = $this->User->findById($session[$token]['ID'], true);
			if ($groupOfDb == null) {
				$this->setAlertMessage('更新対象のグループは削除されています。', 'error');
				$this->redirect(['controller' => $, 'action' => 'index']);
				throw new Exception();
			}

			if ($group['Group']['REVISION'] != $groupOfDb['Group']['REVISION']) {
				$this->setAlertMessage('更新対象のグループは更新されているため変更できません。', 'error');
				$this->redirect(['action' => 'index']);
				throw new Exception();
			}

			$this->Group->set($group);
			if (!$this->Group->validates()) {
				$this->setAlertMessage($this->Group->validationErrors, 'error');
				$this->redirect(['action' => 'edit', 'id' => $token]);
				throw new Exception();
			}

			$groupOfDb['Group'] = array_replace($groupOfDb['Group'], [
				'NAME'    => $group['Group']['NAME'],
				'COMMENT'      => $group['Group']['COMMENT'],
				'UPD_DATETIME' => $this->getNow(),
				'UPD_USER_ID'  => $this->Session->read('loginUserId'),
				'REVISION'     => $groupOfDb['Group']['REVISION'] + 1
			]);

			if (!$this->saveGroup($groupOfDb)) {
				$this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
				$this->redirect(['action' => 'edit', 'id' => $token]);
				throw new Exception();
			}

			$this->TransactionManager->commit();
            $this->setAlertMessage(sprintf('%sを更新しました。', $groupOfDb['Group']['GROUP_NAME']), 'success');
            $this->Session->delete(self::FUNCTION_NAME . $token);
            $this->redirect(['action' => 'index']);
		} catch (Exception $e) {
			$this->TransactionManager->rollback();
			return;
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

    public function getNow()
    {
        return date('Y-m-d H:i:s');
    }
}
