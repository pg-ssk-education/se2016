<?php
App::import('Controller', 'CMN2000');

App::uses('AppController', 'Controller');
App::uses('CMN2000Controller', 'Controller');
App::uses('Fabricate', 'Fabricate.Lib');

class CMN2000ControllerTest extends ControllerTestCase {

	public $fixtures = [
		'app.CMN2000Controller/User'
	];

	public function setUp() {
		parent::setUp();
		// ログイン済みに設定
		CakeSession::write('loginUserId', 'testuser');
	}

	public function tearDown() {
		CakeSession::delete('loginUserId');
	}


	public function test_indexは未ログインの場合にログイン画面を表示すること() {
		// [準備]
		CakeSession::delete('loginUserId');

		// [実行]
		$this->testAction('/CMN2000/index', ['method'=>'get']);

		// [確認]
		$this->assertNotContains('/CMN2000', $this->headers['Location']);
	}

	public function test_indexはログイン済みの場合にユーザ管理画面を表示すること() {
		// [準備]

		// [実行]
		$vars = $this->testAction('/CMN2000/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertEquals('ユーザ管理', $vars['title_for_layout']);
	}

	public function test_indexはviewにユーザ一覧を渡すこと() {
		// [準備]

		// [実行]
		$vars = $this->testAction('/CMN2000/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertCount(3, $vars['users']);
		$this->assertEquals('testuser1', $vars['users'][0]['User']['USER_ID']);
		$this->assertEquals('testuser2', $vars['users'][1]['User']['USER_ID']);
		$this->assertEquals('testuser3', $vars['users'][2]['User']['USER_ID']);
	}

	public function test_indexはsessionにユーザ一覧を保存すること() {
		// [準備]

		// [実行]
		$vars = $this->testAction('/CMN2000/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$session = CakeSession::read('CMN2000');
		
		$this->assertCount(3, $session['Users']);
		$this->assertEquals('testuser1', $session['Users'][0]['User']['USER_ID']);
		$this->assertEquals('testuser2', $session['Users'][1]['User']['USER_ID']);
		$this->assertEquals('testuser3', $session['Users'][2]['User']['USER_ID']);
	}
}
