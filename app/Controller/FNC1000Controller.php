<?php
class FNC1000Controller extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $uses = ['Notification', 'User', 'InvalidAccess'];
    public $components = ['Security'];

	private const FUNCTION_NAME = 'FNC1000';

    public function beforeFilter()
    {
        $this->Security->requirePost(['login']);
        $this->Security->blackHoleCallback = 'blackhole';
    }

    public function blackhole($type)
    {
        $this->setAlertMessage('予期しないエラーが発生しました。', 'error');
        $this->redirect(['action' => 'index']);
    }

    public function root()
    {
        $this->redirect(['action' => 'index']);
    }

    public function index()
    {
		// if the user has logged in, redirects to top page.
		if (isset($this->Session)) {
			if ($this->Session->check('loginUserId')) {
				$this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
				return;
			}
		}

		// restore input value from session.
		if ($this->Session->check(self::FUNCTION_NAME . 'userId')) {
            $this->set('user_id', $this->Session->check(self::FUNCTION_NAME . 'userId'));
        } else {
            $this->set('user_id', '');
        }

        $this->set('title_for_layout', 'ログイン');
        $this->set('notifications', $this->Notification->findAllByTargetUserId(''));
        $this->render('index');
    }

    public function login()
    {
		// if the user has logged in, redirects to top page.
		if (isset($this->Session)) {
			if ($this->Session->check('loginUserId')) {
				$this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
				return;
			}
		}

        $userId = $this->request->data('txtUserId') ?? '';
        $unencryptedPassword = $this->request->data('txtPassword') ?? '';

        $this->Session->write(self::FUNCTION_NAME . 'userId', $userId);

        $this->InvalidAccess->deleteOverOneMinute();
        $invalidAccessCountWithinLastOneMinute = $this->InvalidAccess->findCountByClientIpWithinLastOneMinute($this->getClientIp());
        if ($invalidAccessCountWithinLastOneMinute >= 3) {
            $this->redirect(['action' => 'index']);
            return;
        }

        $user = $this->User->findByUserIdAndUnencryptedPassword($userId, $unencryptedPassword);
        if (empty($user)) {
            $this->InvalidAccess->create(['CLIENT_IP' => $this->getClientIp()]);
            $this->InvalidAccess->save();
            $this->setAlertMessage('ログインできません。ユーザＩＤ、パスワードを確認してください。', 'error');
            $this->redirect(['action' => 'index']);
            return;
        }

        $this->InvalidAccess->deleteAllByClientIp($this->getClientIp());
        $this->Session->write('loginUserId', $userId);
        $this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
    }

    public function logout()
    {
        $this->Session->destroy();
        $this->redirect(['action' => 'index']);
    }

    public function getClientIp()
    {
        return $this->request->clientIp(false);
    }
}
