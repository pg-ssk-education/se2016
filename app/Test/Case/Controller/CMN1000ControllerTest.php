<?php
App::import('Controller', 'CMN1000');

App::uses('AppController', 'Controller');
App::uses('CMN1000Controller', 'Controller');
App::uses('Fabricate', 'Fabricate.Lib');

class CMN1000ControllerTest extends ControllerTestCase {

	public $fixtures = [
		'app.CMN1000Controller/User',
		'app.CMN1000Controller/Notification',
		'app.CMN1000Controller/InvalidAccess'
	];

	public function setUp() {
		parent::setUp();
		CakeSession::delete('loginUserId');
	}

	public function tearDown() {
		CakeSession::delete('loginUserId');
	}

	public function test_indexは未ログインの場合にログイン画面を表示すること() {
		// [準備]

		// [実行]
		$vars = $this->testAction('/CMN1000/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertEquals('ログイン', $vars['title_for_layout']);
	}

	public function test_indexはログイン済みの場合にトップ画面に遷移すること() {
		// [準備]
		// ログイン済みに設定
		CakeSession::write('loginUserId', 'testuser');

		// [実行]
		$this->testAction('/CMN1000/index', ['method'=>'get']);

		// [確認]
		$this->assertContains('/CMN1010', $this->headers['Location']);
	}

	public function test_indexはviewにグローバルな通知情報を渡すこと() {
		// [準備]

		// [実行]
		$vars = $this->testAction('/CMN1000/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertCount(3, $vars['notifications']);
		$this->assertEquals('1行目', $vars['notifications'][0]['Notification']['COMMENT']);
		$this->assertEquals('2行目', $vars['notifications'][1]['Notification']['COMMENT']);
		$this->assertEquals('3行目', $vars['notifications'][2]['Notification']['COMMENT']);
	}

	public function test_indexはviewにクライアントIPの直近1分間の不正アクセス回数を渡すこと() {
		// [準備]
		// クライアントIPを設定
		$CMN1000 = $this->generate('CMN1000', [
			'methods'=>[
				'getClientIp'
			]
		]);
		$CMN1000->expects($this->any())->
			method('getClientIp')->will($this->returnValue('1.2.3.4'));

		// [実行]
		$vars = $this->testAction('/CMN1000/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertEquals(2, $vars['invalidAccessCount']);
	}

	public function test_loginはgetの場合にindexに遷移すること() {
		// [準備]

		// [実行]
		$this->testAction('/CMN1000/login', ['method'=>'get']);

		// [確認]
		// デフォルトページなのでCMN1000が省略される
		// よってCMNが含まれないかを確認する
		$this->assertRegExp('/^(?!.*(CMN1000\/index)).+/', $this->headers['Location']);
	}

	public function test_loginはログイン成功の場合にトップ画面に遷移すること() {
		// [準備]
		// クライアントIPを設定
		$CMN1000 = $this->generate('CMN1000', [
			'methods'=>[
				'getClientIp'
			]
		]);
		$CMN1000->expects($this->any())->
			method('getClientIp')->will($this->returnValue('1.2.3.4'));

		// [実行]
		$data = [
			'txtLoginId'=>'testuser',
			'txtPassword'=>'password'
		];
		$this->testAction('/CMN1000/login', ['method'=>'post', 'data'=>$data]);

		// [確認]
		$this->assertContains('/CMN1010', $this->headers['Location']);
	}

	public function test_loginはログイン失敗の場合に不正アクセスを追加し失敗メッセージを設定しindexに遷移すること() {
		// [準備]
		$CMN1000 = $this->generate('CMN1000', [
			'methods'=>[
				'getClientIp'
			],
			'models'=>[
				'InvalidAccess'=>[
					'saveClientIp'
				]
			]
		]);
		// クライアントIPを設定
		$CMN1000->expects($this->any())->
			method('getClientIp')->will($this->returnValue('192.168.0.10'));
		// InvalidAccess->saveClientIp()の呼び出し期待回数を1回に設定
		$CMN1000->InvalidAccess->expects($this->exactly(1))->method('saveClientIp');

		// [実行]
		$data = [
			'txtLoginId'=>'testuser',
			'txtPassword'=>'invalid'
		];
		$this->testAction('/CMN1000/login', ['data'=>$data, 'method'=>'post', 'return'=>'contents']);

		// [確認]
		$this->assertRegExp('/^(?!.*(CMN1000\/index)).+/', $this->headers['Location']);
		$this->assertContains('ログインできません。ユーザＩＤ、パスワードを確認してください。', CakeSession::read('Message.alert-error'));
	}
	
	public function test_logoutはセッションのログイン情報を削除しインデックスに遷移すること() {
    // [準備]
		// ログイン済みに設定
		CakeSession::write('loginUserId', 'testuser');
		
		// [実行]
		$this->testAction('/CMN1000/logout', ['method'=>'get']);
		
		// [確認]
		$this->assertFalse(CakeSession::check('loginUserId'));
		$this->assertRegExp('/^(?!.*(CMN1000\/index)).+/', $this->headers['Location']);
	}
}
