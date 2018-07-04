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

        $this->restoreInputValueFromSession();

        $this->set('title_for_layout', 'ログイン');
        $this->set('notifications', $this->Notification->findAllByTargetUserId(''));
        $this->render('index');
    }

    private function restoreInputValueFromSession()
    {
        $session = $this->Session->read('FNC1000');
        if (isset($session)) {
            $this->set('userId', $session['userId']);
            $this->set('password', $session['password']);
        } else {
            $this->set('userId', '');
            $this->set('password', '');
        }
    }

    public function login()
    {
        $this->storeInputValueToSession();

        $this->InvalidAccess->deleteOverOneMinute();
        $invalidAccessCountWithinLastOneMinute = $this->InvalidAccess->findCountByClientIpWithinLastOneMinute($this->getClientIp());
        if ($invalidAccessCountWithinLastOneMinute >= 3) {
            $this->redirect(['controller' => 'FNC1000', 'action' => 'index']);
            return;
        }

        $user = $this->User->findByUserIdAndUnencryptedPassword($this->request->data('txtUserId'), $this->request->data('txtPassword'));
        if (empty($user)) {
            $this->InvalidAccess->saveClientIp($this->getClientIp());
            $this->setAlertMessage('ログインできません。ユーザＩＤ、パスワードを確認してください。', 'error');
            $this->redirect(['controller' => 'FNC1000', 'action' => 'index']);
            return;
        }

        $this->InvalidAccess->deleteAllByClientIp($this->getClientIp());
        $this->Session->write('loginUserId', $this->request->data('txtUserId'));

        $this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
    }

    private function storeInputValueToSession()
    {
        $session = ['userId' => $this->request->data('txtUserId'), 'password' => $this->request->data('txtPassword')];
        $this->Session->write('FNC1000', $session);
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
