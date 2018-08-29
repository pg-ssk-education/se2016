<?php
class FNC1000Controller extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $uses = ['Notification', 'User', 'InvalidAccess', 'TransactionManager'];
    public $components = ['Security'];
    
    const SESSION_USER_ID = 'FNC1000:userId';
    const INTERVAL_FOR_COUNT_INVALID_ACCESS = '5 minutes';
    const LIMIT_COUNT_OF_INVALID_ACCESS = 3;

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
    
    public function index()
    {
    	if ($this->redirectToTopPageIfLoggedIn()) {
    		return;
    	}
    	
    	$this->set('user_id', ifnull($this->Session->read(self::SESSION_USER_ID), ''));
        $this->set('title_for_layout', 'ログイン');
        $this->set('notifications', $this->Notification->findAllByTargetUserId(''));
        $this->render('index');
    }

    public function login()
    {
    	if ($this->redirectToTopPageIfLoggedIn()) {
    		return;
    	}

        $userId = ifnull($this->request->data('txtUserId'), '');
        $unencryptedPassword = ifnull($this->request->data('txtPassword'), '');
        $this->Session->write(self::SESSION_USER_ID, $userId);

		try {
			$this->TransactionManager->begin();
			
			$clientIp = $this->getClientIp();
			$this->InvalidAccess->deleteBefore(self::INTERVAL_FOR_COUNT_INVALID_ACCESS);
			$invalidAccessCount = $this->InvalidAccess->findCountByClientIp($clientIp);
			if ($invalidAccessCount >= self::LIMIT_COUNT_OF_INVALID_ACCESS) {
 	            $this->setAlertMessage('規定回数間違ったためロックされています。しばらく経ってからログインしてください。', 'error');
		        $this->TransactionManager->commit();
				$this->redirect(['action' => 'index']);
				return;
			}

	        $user = $this->User->findByUserIdAndUnencryptedPassword($userId, $unencryptedPassword);
	        if (empty($user)) {
	            $this->InvalidAccess->create();
	            $invalidAccess = [
	            	'CLIENT_IP'    => $clientIp,
	            	'INS_DATETIME' => date_format(new DateTime(), 'Y-m-d H:i:s'),
	            	'INS_USER_ID'  => $userId
	            ];
	            $this->InvalidAccess->save(['InvalidAccess' => $invalidAccess], false);
		        $this->TransactionManager->commit();
	            $this->setAlertMessage('ログインできません。ユーザＩＤ、パスワードを確認してください。', 'error');
	            $this->redirect(['action' => 'index']);
				return;
	        }
	        
	        $this->TransactionManager->commit();
	        $this->Session->write('loginUserId', $userId);
	        $this->Session->delete(self::SESSION_USER_ID);
	        $this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
	    } catch (Exception $e) {
	    	$this->TransactionManager->rollback();
	    	throw new InternalErrorException($e->message);
	    }
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
    
    private function redirectToTopPageIfLoggedIn() {
    	if (isset($this->Session)) {
    		if ($this->Session->check('loginUserId')) {
                $this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
                return true;
    		}
    	}
    	
    	return false;
    }
    
}
