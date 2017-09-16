<?php
class CMN1020Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	public $uses = ['User'];

	public function index() {
		$this->render('index');
	}

  public function send() {
		App::uses('RandomCharUtil', 'Vendor/Util');
		App::uses('MailUtil', 'Vendor/Util');
/*
		print($_SERVER["REQUEST_URI"]);
		print($_SERVER["HTTP_HOST"]);
		print(isset($_SERVER["HTTPS"]) ? 'https://' : 'http://');
*/
/*
		$user = $this->User->findByUserId($userId);
		$this->log($this->User->getDataSource()->getLog(), LOG_INFO);
		if (isset($user)) {
			$user['User']['PASSWORD_KEY'] = RandomCharUtil.createRandomChar(16, RandomCharUtil.NUMBER);
			$user['User']['PASSWORD_URL'] = RandomCharUtil.createRandomChar(16, RandomCharUtil.NUMBER . CHAR_LOWERCASE);
			$user['User']['PASSWORD_LIMIT'] = strtotime('+10 minute' , DboSource::expression('NOW()'));
			$this->User->update($user);
			$this->log($this->User->getDataSource()->getLog(), LOG_INFO);

			MailUtil.sendMail();
		}
*/
		$this->Session->setFlash('登録されているメールアドレスにパスワード変更ページのURLを送信しました。10分以内にパスワード変更を実施してください。');
		$this->render('complete');
  }


}
