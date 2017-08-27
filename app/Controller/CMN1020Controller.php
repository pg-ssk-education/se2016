<?php
class CMN1020Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	public $uses = ['User'];

	public function index() {
		$this->render('index');
	}

  public function send() {
		/*
		$user = $this->User->findByUserId($userId);
		$this->log($this->User->getDataSource()->getLog(), LOG_DEBUG);
		if (isset($user)) {
			$key = createRandomChar(16, ['alnum']);
			$url = createRandomChar(16, ['num', 'lc']);
			$user['User']['PASSWORD_KEY'] = $key;
			$user['User']['PASSWORD_URL'] = $url;
		}
		*/
		$this->Session->setFlash('登録されているメールアドレスにパスワード変更ページのURLを送信しました。10分以内にパスワード変更を実施してください。');
		$this->render('complete');
  }
}
