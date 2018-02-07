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
		CakeSession::delete('CMN2000');
	}

	public function tearDown() {
		CakeSession::delete('loginUserId');
		CakeSession::delete('CMN2000');
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
		$this->assertEquals('ユーザ管理:一覧', $vars['title_for_layout']);
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
	
	
	public function test_addは未ログインの場合にログイン画面を表示すること() {
		// [準備]
		CakeSession::delete('loginUserId');

		// [実行]
		$this->testAction('/CMN2000/add', ['method'=>'get']);

		// [確認]
		$this->assertNotContains('/CMN2000', $this->headers['Location']);
	}
	
	
	public function test_addはsessionにCMN2000が存在しなければCMN2000のindexに遷移すること() {
		// [準備]
		CakeSession::delete('CMN2000');
		
		// [実行]
		$this->testAction('/CMN2000/add', ['method'=>'get']);
		
		// [確認]
		$this->assertRegExp('/^.*CMN2000$/', $this->headers['Location']);
	}
	
	public function test_addはtokenをキーにしてsessionに空ユーザーを登録しadduserに遷移すること() {
		// [準備]
		CakeSession::write('CMN2000', ['Users'=>[]]);
		
		$CMN2000 = $this->generate('CMN2000', [
			'methods'=>[
				'getUniqId'
			]
		]);
		
		$CMN2000->expects($this->any())->
			method('getUniqId')->will($this->returnValue('1234'));
		
		// [実行]
		$this->testAction('/CMN2000/add', ['method'=>'get']);
		
		// [確認]
		$session = CakeSession::read('CMN2000');
		$this->assertNotEquals(null, $session);
		$this->assertEquals('', $session['1234']['User']['USER_ID']);
		$this->assertEquals('', $session['1234']['User']['NAME']);
		$this->assertEquals('', $session['1234']['User']['NAME_KANA']);
		$this->assertEquals('', $session['1234']['User']['COMMENT']);
		$this->assertEquals('', $session['1234']['User']['EMPLOYEE_NUM']);
		$this->assertEquals('', $session['1234']['User']['MAIL_ADDRESS']);
		
		$this->assertContains('/CMN2000/adduser/id:1234', $this->headers['Location']);
		
	}
	
	public function test_adduserは未ログインの場合にログイン画面を表示すること() {
		// [準備]
		CakeSession::delete('loginUserId');

		// [実行]
		$this->testAction('/CMN2000/adduser', ['method'=>'get']);

		// [確認]
		$this->assertNotContains('/CMN2000', $this->headers['Location']);
	}
	
	public function test_adduserはtokenが取得できない場合にCMN2000のindex画面に遷移すること(){
		// [準備]
		
		// [実行]
		$this->testAction('/CMN2000/adduser', ['method'=>'get']);
		
		// [確認]
		$this->assertRegExp('/^.*CMN2000$/', $this->headers['Location']);
	}
	
	public function test_adduserはSessionが取得できない場合にCMN2000のindex画面に遷移すること(){
		// [準備]
		CakeSession::write('CMN2000', ['Users'=>[]]);
		
		// [実行]
		$this->testAction('/CMN2000/adduser/id:1234', ['method'=>'get']);
		
		// [確認]
		$this->assertRegExp('/^.*CMN2000$/', $this->headers['Location']);
	}

	public function test_adduserはviewに表示情報を渡すこと(){
		// [準備]
		$user = [
            'User' => [
                'USER_ID'      => 'abcd',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ]
        ];
		CakeSession::write('CMN2000', ['Users'=>[],'1234'=>$user]);
		
		// [実行]
		$vars = $this->testAction('/CMN2000/adduser/id:1234', ['method'=>'get','return'=>'vars']);
		
		// [確認]
		$this->assertEquals('ユーザ管理:登録', $vars['title_for_layout']);
		$this->assertEquals('abcd', $vars['user']['User']['USER_ID']);
		$this->assertEquals('insert', $vars['action']);
		$this->assertEquals('1234', $vars['token']);
	}
	
	public function test_insertは未ログインの場合にログイン画面を表示すること() {
		// [準備]
		CakeSession::delete('loginUserId');

		// [実行]
		$this->testAction('/CMN2000/insert', ['method'=>'get']);

		// [確認]
		$this->assertNotContains('/CMN2000', $this->headers['Location']);
	}
	
	public function test_insertはtokenが取得できない場合にCMN2000のindex画面に遷移すること(){
		// [準備]
		
		// [実行]
		$this->testAction('/CMN2000/insert', ['method'=>'get']);
		
		// [確認]
		$this->assertRegExp('/^.*CMN2000$/', $this->headers['Location']);
	}
	
	public function test_insertはSessionが取得できない場合にCMN2000のindex画面に遷移すること(){
		// [準備]
		
		// [実行]
		$this->testAction('/CMN2000/insert/id:1234', ['method'=>'get']);
		
		// [確認]
		$this->assertRegExp('/^.*CMN2000$/', $this->headers['Location']);
	}
}
