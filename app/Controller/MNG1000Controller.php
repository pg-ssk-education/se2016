<?php
/*
Session['MNG1000'] => [
    'users'=>$users,
    $token => [
        'user' => [
            'USER_ID'      => '',
            'NAME'         => '',
            'NAME_KANA'    => '',
            'COMMENT'      => '',
            'EMPLOYEE_NUM' => '',
            'MAIL_ADDRESS' => '',
        ],
        'action' => 'insert' or 'update'
    ]
]
*/
class MNG1000Controller extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $uses = ['User', 'TransactionManager'];
    public $components = ['Security'];

    private $FUNCTION_NAME = 'MNG1000';

    public function beforeFilter()
    {
        $this->Security->requirePost(['insert', 'update']);
        $this->Security->blackHoleCallback = 'blackhole';
    }

    public function blackhole($type)
    {
        $this->setAlertMessage('予期しないエラーが発生しました。', 'error');
        $this->redirect(['controller' => $this->FUNCTION_NAME, 'action' => 'index']);
    }

    public function index()
    {
        if (!$this->checkLoggedIn()) {
            return;
        }

        $users = $this->User->findAll();
        $session = $this->Session->read($this->FUNCTION_NAME);
        if ($session == null) {
            $session = [];
        }
        $session = array_replace($session, ['users' => $users]);
        $this->Session->write($this->FUNCTION_NAME, $session);

        $this->set('title_for_layout', 'ユーザ管理:一覧');
        $this->set('users', $users);
        $this->render('index');
    }

    public function add()
    {
        $tokenData = [
            'user' => [
                'USER_ID'      => '',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ],
            'action' => 'insert'
        ];
        $session = $this->Session->read($this->FUNCTION_NAME);
        if ($session == null) {
            $this->redirect(['controller' => $this->FUNCTION_NAME, 'action' => 'index']);
            return;
        }
        $token = $this->getUniqId();
        $session = array_replace($session, [$token => $tokenData]);
        $this->Session->write($this->FUNCTION_NAME, $session);
        $this->redirect(['controller' => $this->FUNCTION_NAME, 'action' => 'edit', 't' => $token]);
    }

    public function edit()
    {
//        if (!array_key_exists('t', $this->params['named'])) {
//            $this->redirect(['controller' => $this->FUNCTION_NAME, 'action' => 'index']);
//            return;
//        }
//        $token = $this->params['named']['t'];
        $token = $this->params['named']['t'];
        if (!isset($token)) {
            $this->redirect(['controller' => $this->FUNCTION_NAME, 'action' => 'index']);
            return;
        }
        $session = $this->Session->read($this->FUNCTION_NAME);
        if ($session == null || !array_key_exists($token, $session)) {
            $this->redirect(['controller' => $this->FUNCTION_NAME, 'action' => 'index']);
            return;
        }
        $tokenData = $session[$token];

        $this->set('title_for_layout', 'ユーザ管理:編集');
        $this->set('tokenData', $tokenData);
        $this->set('token', $token);
        $this->render('edit');
    }

    public function save() {
        if (!$this->checkLoggedIn()) {
            return;
        }

        $token = $this->params['named']['t'];
        if (!isset($token)) {
            $this->redirect(['controller' => $this->FUNCTION_NAME, 'action' => 'index']);
            return;
        }
        $session = $this->Session->read($this->FUNCTION_NAME);
        if ($session == null || !array_key_exists($token, $session)) {
            $this->redirect(['controller' => $this->FUNCTION_NAME, 'action' => 'index']);
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

    public function getUniqId()
    {
        return uniqid();
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

    public function edit()
    {
        if (!$this->checkLogin()) {
            return;
        }

        $session = $this->Session->read('CMN2000');
        if ($session == null) {
            $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
            return;
        }

        //ToDo：namedにidがあるかのチェックをすること

        $userId = $this->params['named']['id'];
        $user = $this->getUserFromSession($userId);
        if ($user == null) {
            $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
            return;
        }

        $token = $this->getUniqId();
        $session = array_replace($session, [$token => $user]);
        $this->Session->write('CMN2000', $session);
        $this->redirect(['controller' => 'CMN2000', 'action' => 'edituser', 'id' => $token]);
    }

    public function edituser()
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

        $this->set('title_for_layout', 'ユーザ管理:編集');
        $this->set('user', $user);
        $this->set('action', 'update');
        $this->set('token', $token);
        $this->render('edit');
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

    public function delete()
    {
        if (!$this->checkLogin()) {
            return;
        }

        if (!array_key_exists('id', $this->params['named'])) {
            $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
            return;
        }
        $userId = $this->params['named']['id'];

        try {
            $this->TransactionManager->begin();

            $userOfDb = $this->User->findByUserId($userId, true);
            if ($userId == null) {
                $this->setAlertMessage('削除対象のユーザは存在しません。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
                throw new Exception();
            }

            $userOfSession = $this->getUserFromSession($userId);
            if ($userOfSession == null) {
                $this->setAlertMessage('削除対象のユーザは存在しません。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
                throw new Exception();
            }

            if ($userOfDb['User']['ROW_NUM'] != $userOfSession['User']['ROW_NUM'] || $userOfDb['User']['REVISION'] != $userOfSession['User']['REVISION']) {
                $this->setAlertMessage('削除対象ユーザは更新されているため削除できません。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
                throw new Exception();
            }

            $userOfDb['User'] = array_replace($userOfDb['User'], [
                'STATE'        => 1,
                'UPD_DATETIME' => $this->getNow(),
                'UPD_USER_ID'  => $this->Session->read('loginUserId'),
                'REVISION'     => $userOfDb['User']['REVISION'] + 1
            ]);

            if (!$this->saveUser($userOfDb)) {
                $this->setAlertMessage('予期せぬエラーが発生しました。', 'error');
                $this->redirect(['controller' => 'CMN2000', 'action' => 'index']);
                throw new Exception();
            }
            $this->TransactionManager->commit();
        } catch (Exception $e) {
            $this->TransactionManager->rollback();
            return;
        }

        $this->setAlertMessage('削除しました。', 'success');
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
