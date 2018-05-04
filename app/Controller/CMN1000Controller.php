<?php
class CMN1000Controller extends AppController
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
        $this->redirect(['controller' => 'CMN1000', 'action' => 'index']);
    }

    public function root()
    {
        $this->redirect(['controller' => 'CMN1000', 'action' => 'index']);
    }

    public function index()
    {
        if ($this->logined()) {
            $this->redirect(['controller' => 'CMN1010', 'action' => 'index']);
            return;
        }

        $this->set('title_for_layout', 'ログイン');
        $this->set('notifications', $this->Notification->findAllByTargetUserId(''));
        $this->set('invalidAccessCount', $this->InvalidAccess->findCountByClientIpWithinLastOneMinute($this->getClientIp()));
    }

    public function login()
    {
        $this->InvalidAccess->deleteOverOneMinute();

        $user = $this->User->findByUserIdAndPassword(
                $this->request->data('txtLoginId'),
                $this->request->data('txtPassword')
        );
        if (empty($user)) {
            $this->InvalidAccess->saveClientIp($this->getClientIp());
            $this->setAlertMessage('ログインできません。ユーザＩＤ、パスワードを確認してください。', 'error');
            $this->redirect(['controller' => 'CMN1000', 'action' => 'index']);
            return;
        }

        $this->InvalidAccess->deleteAllByClientIp($this->getClientIp());
        $this->Session->write('loginUserId', $this->request->data('txtLoginId'));

        $this->redirect(['controller' => 'CMN1010', 'action' => 'index']);
    }

    public function logout()
    {
        $this->Session->destroy();
//        $this->Session->delete('loginUserId');
        $this->redirect(['controller' => 'CMN1000', 'action' => 'index']);
    }

    public function getClientIp()
    {
        return $this->request->clientIp(false);
    }
}
