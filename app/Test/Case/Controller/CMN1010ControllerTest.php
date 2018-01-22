<?php
App::import('Controller', 'CMN1010');

App::uses('AppController', 'Controller');
App::uses('CMN1010Controller', 'Controller');
App::uses('Fabricate', 'Fabricate.Lib');

class CMN1010ControllerTest extends ControllerTestCase {

	public $fixtures = [
		'app.CMN1010Controller/Notification'
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
		$this->testAction('/CMN1010/index', ['method'=>'get']);

		// [確認]
		$this->assertNotContains('/CMN1010', $this->headers['Location']);
	}

	public function test_indexはログイン済みの場合にトップ画面を表示すること() {
		// [準備]

		// [実行]
		$vars = $this->testAction('/CMN1010/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertEquals('トップ', $vars['title_for_layout']);
	}

	public function test_indexはviewにログインユーザーの通知情報だけを渡すこと() {
		// [準備]

		// [実行]
		$vars = $this->testAction('/CMN1010/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertCount(3, $vars['notifications']);
		$this->assertEquals('testuser1行目', $vars['notifications'][0]['Notification']['COMMENT']);
		$this->assertEquals('testuser2行目', $vars['notifications'][1]['Notification']['COMMENT']);
		$this->assertEquals('testuser3行目', $vars['notifications'][2]['Notification']['COMMENT']);
	}
}
