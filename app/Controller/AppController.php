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
class AppController extends Controller {
	public $components = ['DebugKit.Toolbar', 'Session'];

	public $helpers = ['Session',
	                   'Html' => ['className' => 'TwitterBootstrap.BootstrapHtml'],
	                   'Form' => ['className' => 'TwitterBootstrap.BootstrapForm'],
	                   'Paginator' => ['className' => 'TwitterBootstrap.BootstrapPaginator']];
	public $layout = 'bootstrap';

	public $messages = [];

	public function setAlertMessage($message, $type) {
		// $type : error or success or notice

		$this->addMessages($message, $type);

		$this->Session->delete('Message.alert-' . $type);
		$this->Session->setFlash(join("\n", $this->messages[$type]), 'flash_' . $type, [], 'alert-' . $type);
	}

	public function addMessages($message, $type) {
		$messages = [];

		if (!array_key_exists($type, $this->messages)) {
			$this->messages = array_merge($this->messages, [$type => []]);
		}

		if (is_array($message)) {
			foreach($message as $it) {
				$this->addMessages($it, $type);
			}
		} else {
			array_push($this->messages[$type], $message);
		}
	}

	public function logined() {
		if (isset($this->Session)) {
			$loginUserId = $this->Session->read('loginUserId');
			if (isset($loginUserId)) {
				return true;
			}
		}
		return false;
	}

	public function checkLogin() {
		if (isset($this->Session)) {
			$loginUserId = $this->Session->read('loginUserId');
			if (isset($loginUserId)) {
				return true;
			}
		}
		$this->redirect(['controller'=>'CMN1000', 'action'=>'index']);
		return false;
	}
}
