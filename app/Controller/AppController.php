<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = ['DebugKit.Toolbar', 'Session'];
    public $uses = ['User'];

    public $helpers = [
        'Session',
        'Html' => ['className' => 'TwitterBootstrap.BootstrapHtml'],
        'Form' => ['className' => 'TwitterBootstrap.BootstrapForm'],
        'Paginator' => ['className' => 'TwitterBootstrap.BootstrapPaginator']
    ];
    public $layout = 'bootstrap4';

    public function setAlertMessage($message, $type)
    {
        // $type : error, success or notice
		if ($this->Session->check('Message.alert-' . $type)) {
			$old = $this->Session->read('Message.alert-' . $type);
			$this->Session->delete('Message.alert-' . $type);
			$this->Session->setFlash($old . "\n", $message, 'flash_' . $type, [], 'alert-' . $type);
		} else {
			$this->Session->setFlash($message, 'flash_' . $type, [], 'alert-' . $type);
		}
    }

	public function setAlertMessages($messages, $type) {
		$this->setAlertMessage(join("\n", $messages));
	}

	public function checkAuth($onlyAdminUser = false) {
		$loginUserId = null;
		if (isset($this->Session)) {
			if ($this->Session->check('loginUserId')) {
				$loginUserId = $this->Session->read('loginUserId');
			}
		}

		if (is_null($loginUserId)) {
			$this->redirectToLogin();
			return false;
		}

		$loginUser = $this->User->findByUserId($loginUserId);
		if (is_null($loginUser)) {
			$this->Session->destroy();
			$this->redirectToLogin();
			return false;
		}
		$this->set('login_user', $loginUser);

		// $adminGroupUser = $this->GroupUser->findByGroupIdAndUserId('admin', $loginUserId);
		$adminGroupUser = true;
		if (isset($adminGroupUser)) {
			$this->set('belong_to_admin_group', true);
		} else {
			$this->set('belong_to_admin_group', false);
			if ($onlyAdminUser) {
				$this->redirectToTop();
				return false;
			}
		}


		return true;
	}

	public function redirectToLogin() {
		$this->redirect(['controller' => 'FNC1000', 'action' => 'index']);
	}

	public function redirectToTop() {
		$this->redirect(['controller' => 'FNC1010', 'action' => 'index']);
	}
}
