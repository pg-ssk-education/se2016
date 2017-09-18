<?php
App::uses('AppController', 'Controller');
App::uses('CMN1000Controller', 'Controller');
App::uses('Fabricate', 'Fabricate.Lib');

class CMN1000ControllerTest extends ControllerTestCase {

	public $fixtures = [
		'app.user',
		'app.CMN1000Controller/Notification',
		'app.CMN1000Controller/InvalidAccess'
	];

	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
	}

	public function test_indexは未ログインの場合にログイン画面を表示すること() {
		// [準備]
		// 未ログインに設定
		CakeSession::delete('loginUserId');

		// [実行]
		$vars = $this->testAction('/CMN1000/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertEquals('ログイン', $vars['title']);
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
		// 未ログインに設定
		CakeSession::delete('loginUserId');

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
		// 未ログインに設定
		CakeSession::delete('loginUserId');
		//
		$CMN1000 = $this->generate('CMN1000', [
			'models'=>[
				'InvalidAccess'=>[
					'findCountByClientIpOnLastOneMinute'
				]
			]
		]);
		$CMN1000->InvalidAccess->expects($this->once())->
			method('findCountByClientIpOnLastOneMinute')->will($this->returnValue(2));

		// [実行]
		$vars = $this->testAction('/CMN1000/index', ['method'=>'get', 'return'=>'vars']);

		// [確認]
		$this->assertEquals(2, $vars['invalidAccessCount']);
	}

	public function test_loginはgetの場合にindexに遷移すること() {
		// [準備]
		// 未ログインに設定
		CakeSession::delete('loginUserId');

		// [実行]
		$this->testAction('/CMN1000/login', ['method'=>'get']);

		// [確認]
		// デフォルトページなのでCMN1000が省略される
		// よってCMNが含まれないかを確認する
		$this->assertRegExp('/^(?!.*(CMN)).+/', $this->headers['Location']);
	}

/*


	public function testインフォーメーションを取得できること() {
		// Viewに渡された変数を確認する
		$result = $this->testAction('CMN1000/index', ['return' => 'vars']);
		$notification = $result['notifications'];

		// (デバッグ用)変数の内容を参照する。
		// ※test.phpでテストケースを実行後、[Enable Debug Output]リンクから確認できる
		var_dump($notification);

		$this->assertNotEmpty($notification);
		$this->assertCount(3, $notification);

		// ROW_NUMの昇順であることを確認する
		$this->assertEquals('1', $notification[0]['Notification']['ROW_NUM']);
		$this->assertEquals('2', $notification[1]['Notification']['ROW_NUM']);
		$this->assertEquals('3', $notification[2]['Notification']['ROW_NUM']);
	}

	public function login_ログイン成功の場合はトップ画面に遷移すること() {
		//TODO:ログイン可能ユーザの登録処理
		$data = [
			'txtLoginId'=>'admin',
			'txtPassword'=>'admin'
		];
		$this->testAction('/CMN1000/login', ['data'=>$data, 'method'=>'post', 'return'=>'contents']);
		$this->assertRegExp('/CMN1010/index', $this->headers['Location']);
	}

	public function login_ログイン失敗の場合は不正アクセスを追加し失敗メッセージを設定しindexに遷移すること() {
		$data = [
			'txtLoginId'=>'test',
			'txtPassword'=>'test'
		];
		$this->testAction('/CMN1000/login', ['data'=>$data, 'method'=>'post', 'return'=>'contents']);
		$this->assertRegExp('/CMN1000/index', $this->headers['Location']);
		$this->assertContains('ログインできません。ユーザＩＤ、パスワードを確認してください。(ERR_CMN1000_01)', $this->controller->Session->read('Message.flash'));
		//TODO:不正アクセスの追加確認
	}
*/
}
