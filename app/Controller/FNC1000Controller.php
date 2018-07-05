<?php
class FNC1000Controller extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $uses = ['Notification', 'User', 'InvalidAccess'];
    public $components = ['Security'];

    public function beforeFilter()
    {
        $this->Security->requirePost(['login']);
        $this->Security->blackHoleCallback = 'blackhole';
    }

    public function blackhole($type)
    {
        $this->setAlertMessage('予期しないエラーが発生しました。', 'error');
        $this->redirect(['controller' => 'FNC1000', 'action' => 'index']);
    }

    public function root()
    {
        $this->redirect(['controller' => 'FNC1000', 'action' => 'index']);
    }

    public function index()
    {
        if ($this->loggedIn()) {
            $this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
            return;
        }

        $session = $this->Session->read('FNC1000');
        if (isset($session)) {
            $this->set('user_id', $session['userId'] ?? '');
        } else {
            $this->set('user_id', '');
        }

        $this->set('title_for_layout', 'ログイン');
        $this->set('notifications', $this->Notification->findAllByTargetUserId(''));
        $this->render('index');
    }

    public function login()
    {
        $userId = $this->request->data('txtUserId') ?? '';
        $unencryptedPassword = $this->request->data('txtPassword') ?? '';

        $session = ['userId' => $userId];
        $this->Session->write('FNC1000', $session);

        $this->InvalidAccess->deleteOverOneMinute();
        $invalidAccessCountWithinLastOneMinute = $this->InvalidAccess->findCountByClientIpWithinLastOneMinute($this->getClientIp());
        if ($invalidAccessCountWithinLastOneMinute >= 3) {
            $this->redirect(['controller' => 'FNC1000', 'action' => 'index']);
            return;
        }

        $user = $this->User->findByUserIdAndUnencryptedPassword($userId, $unencryptedPassword);
        if (empty($user)) {
            $this->InvalidAccess->create(['CLIENT_IP' => $this->getClientIp()]);
            $this->InvalidAccess->save();
            $this->setAlertMessage('ログインできません。ユーザＩＤ、パスワードを確認してください。', 'error');
            $this->redirect(['controller' => 'FNC1000', 'action' => 'index']);
            return;
        }

        $this->InvalidAccess->deleteAllByClientIp($this->getClientIp());
        $this->Session->write('loginUserId', $userId);
        $this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
    }

    public function logout()
    {
        $this->Session->destroy();
        $this->redirect(['controller' => 'FNC1000', 'action' => 'index']);
    }

    public function getClientIp()
    {
        return $this->request->clientIp(false);
    }
}
