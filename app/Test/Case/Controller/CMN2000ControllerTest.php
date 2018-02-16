<?php
App::import('Controller', 'CMN2000');

App::uses('AppController', 'Controller');
App::uses('CMN2000Controller', 'Controller');
App::uses('Fabricate', 'Fabricate.Lib');
App::uses('User', 'Model');

class CMN2000ControllerTest extends ControllerTestCase
{
    public $fixtures = [
        'app.CMN2000Controller/User'
    ];

    public function setUp()
    {
        parent::setUp();
        CakeSession::write('loginUserId', 'testuser');
        CakeSession::delete('CMN2000');
    	CakeSession::delete('Message');
    	$this->User = ClassRegistry::init('User');
    }

    public function tearDown()
    {
        CakeSession::delete('loginUserId');
        CakeSession::delete('CMN2000');
    	CakeSession::delete('Message');
    }


    public function test_indexは未ログインの場合にログイン画面を表示すること()
    {
        // [準備]
        CakeSession::delete('loginUserId');

        // [実行]
        $this->testAction('/CMN2000/index', ['method' => 'get']);

        // [確認]
        $this->assertStringEndsWith('/CMN1000', $this->headers['Location']);
    }

    public function test_indexはログイン済みの場合にユーザ管理画面を表示すること()
    {
        // [準備]

        // [実行]
        $vars = $this->testAction('/CMN2000/index', ['method' => 'get', 'return' => 'vars']);

        // [確認]
        $this->assertEquals('ユーザ管理:一覧', $vars['title_for_layout']);
    }

    public function test_indexはviewにユーザ一覧を渡すこと()
    {
        // [準備]

        // [実行]
        $vars = $this->testAction('/CMN2000/index', ['method' => 'get', 'return' => 'vars']);

        // [確認]
        $this->assertCount(3, $vars['users']);
        $this->assertEquals('testuser1', $vars['users'][0]['User']['USER_ID']);
        $this->assertEquals('testuser2', $vars['users'][1]['User']['USER_ID']);
        $this->assertEquals('testuser3', $vars['users'][2]['User']['USER_ID']);
    }

    public function test_indexはsessionにユーザ一覧を保存すること()
    {
        // [準備]

        // [実行]
        $vars = $this->testAction('/CMN2000/index', ['method' => 'get', 'return' => 'vars']);

        // [確認]
        $session = CakeSession::read('CMN2000');

        $this->assertCount(3, $session['Users']);
        $this->assertEquals('testuser1', $session['Users'][0]['User']['USER_ID']);
        $this->assertEquals('testuser2', $session['Users'][1]['User']['USER_ID']);
        $this->assertEquals('testuser3', $session['Users'][2]['User']['USER_ID']);
    }


    public function test_addは未ログインの場合にログイン画面を表示すること()
    {
        // [準備]
        CakeSession::delete('loginUserId');

        // [実行]
        $this->testAction('/CMN2000/add', ['method' => 'get']);

        // [確認]
        $this->assertStringEndsWith('/CMN1000', $this->headers['Location']);
    }


    public function test_addはsessionにCMN2000が存在しなければCMN2000のindexに遷移すること()
    {
        // [準備]
        CakeSession::delete('CMN2000');

        // [実行]
        $this->testAction('/CMN2000/add', ['method' => 'get']);

        // [確認]
        $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    }

    public function test_addはtokenをキーにしてsessionに空ユーザーを登録しadduserに遷移すること()
    {
        // [準備]
        CakeSession::write('CMN2000', ['Users' => []]);

        $CMN2000 = $this->generate('CMN2000', [
            'methods' => [
                'getUniqId'
            ]
        ]);
        $CMN2000->expects($this->any())->
            method('getUniqId')->will($this->returnValue('1234'));

        // [実行]
        $this->testAction('/CMN2000/add', ['method' => 'get']);

        // [確認]
        $session = CakeSession::read('CMN2000');
        $user = [
            'User' => [
                'USER_ID'      => '',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ]
        ];
        $this->assertEquals($user, $session['1234']);
        $this->assertStringEndsWith('/CMN2000/adduser/id:1234', $this->headers['Location']);
    }

    public function test_adduserは未ログインの場合にログイン画面を表示すること()
    {
        // [準備]
        CakeSession::delete('loginUserId');

        // [実行]
        $this->testAction('/CMN2000/adduser', ['method' => 'get']);

        // [確認]
        $this->assertStringEndsWith('/CMN1000', $this->headers['Location']);
    }

    public function test_adduserはtokenが取得できない場合にCMN2000のindex画面に遷移すること()
    {
        // [準備]

        // [実行]
        $this->testAction('/CMN2000/adduser', ['method' => 'get']);

        // [確認]
        $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    }

    public function test_adduserはSessionが取得できない場合にCMN2000のindex画面に遷移すること()
    {
        // [準備]
        CakeSession::write('CMN2000', ['Users' => []]);

        // [実行]
        $this->testAction('/CMN2000/adduser/id:1234', ['method' => 'get']);

        // [確認]
        $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    }

    public function test_adduserはviewに表示情報を渡すこと()
    {
        // [準備]
        $user = [
            'User' => [
                'USER_ID'      => 'abcd',
                'NAME'         => '氏名',
                'NAME_KANA'    => 'シメイ',
                'COMMENT'      => 'コメント',
                'EMPLOYEE_NUM' => '123',
                'MAIL_ADDRESS' => 'test@example.com',
            ]
        ];
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);

        // [実行]
        $vars = $this->testAction('/CMN2000/adduser/id:1234', ['method' => 'get','return' => 'vars']);

        // [確認]
        $this->assertEquals('ユーザ管理:登録', $vars['title_for_layout']);
        $this->assertEquals($user, $vars['user']);
        $this->assertEquals('insert', $vars['action']);
        $this->assertEquals('1234', $vars['token']);
    }

    public function test_insertは未ログインの場合にログイン画面を表示すること()
    {
        // [準備]
        CakeSession::delete('loginUserId');

        // [実行]
        $this->testAction('/CMN2000/insert', ['method' => 'post']);

        // [確認]
        $this->assertStringEndsWith('/CMN1000', $this->headers['Location']);
    }

    public function test_insertはtokenが取得できない場合にCMN2000のindex画面に遷移すること()
    {
        // [準備]

        // [実行]
        $this->testAction('/CMN2000/insert', ['method' => 'post']);

        // [確認]
        $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    }

    public function test_insertはSessionが取得できない場合にCMN2000のindex画面に遷移すること()
    {
        // [準備]

        // [実行]
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post']);

        // [確認]
        $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    }

    public function test_insertは入力に誤りがある場合にエラーメッセージをViewに設定しadduser画面に遷移すること()
    {
        // [準備]
        $user = [
            'User' => [
                'USER_ID'      => '',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ]
        ];
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);

        // [実行]
    	$post = [
    		'txtUserId' => '',
    		'txtName' => '',
    		'txtNameKana' => '',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '',
    		'txtMailAddress' => 'test'
        ];
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000/adduser/id:1234', $this->headers['Location']);
    	$this->assertContains('ユーザIDを設定してください。', CakeSession::read('Message.alert-error.message'));
    	$this->assertContains('氏名を設定してください。', CakeSession::read('Message.alert-error.message'));
    	$this->assertContains('氏名(カナ)を設定してください', CakeSession::read('Message.alert-error.message'));
    	$this->assertContains('社員番号を設定してください。', CakeSession::read('Message.alert-error.message'));
    	$this->assertContains('メールアドレスはメールアドレス形式で設定してください。', CakeSession::read('Message.alert-error.message'));

        // [準備]
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);
        // [実行]
    	$post = [
    		'txtUserId' => 'ユーザ',
    		'txtName' => 'テストユーザ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => 'いちにさんよん',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000/adduser/id:1234', $this->headers['Location']);
    	$this->assertContains('ユーザIDはアルファベットまたは数字のみで設定してください。', CakeSession::read('Message.alert-error.message'));
    	$this->assertContains('社員番号は数字のみで設定してください。', CakeSession::read('Message.alert-error.message'));

        // [準備]
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);
        // [実行]
    	$post = [
    		'txtUserId' => '1234567',
    		'txtName' => 'テストユーザ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];

        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000/adduser/id:1234', $this->headers['Location']);
    	$this->assertContains('ユーザIDは8文字以上32文字以下で設定してください。', CakeSession::read('Message.alert-error.message'));

        // [準備]
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);
        // [実行]
    	$post = [
    		'txtUserId' => '123456789012345678901234567890123',
    		'txtName' => 'テストユーザ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000/adduser/id:1234', $this->headers['Location']);
    	$this->assertContains('ユーザIDは8文字以上32文字以下で設定してください。', CakeSession::read('Message.alert-error.message'));

    	// [準備]
        CakeSession::write('CMN2000', ['Users' => [],'1111' => $user]);
        // [実行]
    	$post = [
    		'txtUserId' => '12345678',
    		'txtName' => 'テストユーザ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:1111', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    	$this->assertContains('登録しました。', CakeSession::read('Message.alert-success.message'));

    	// [準備]
        CakeSession::write('CMN2000', ['Users' => [],'2222' => $user]);
        // [実行]
    	$post = [
    		'txtUserId' => '12345678901234567890123456789012',
    		'txtName' => 'テストユーザ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:2222', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    	$this->assertContains('登録しました。', CakeSession::read('Message.alert-success.message'));
    }

    public function test_insertは入力に誤りがある場合にSessionのユーザ情報を入力値で更新すること()
    {
        // [準備]
        $user = [
            'User' => [
                'USER_ID'      => '',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ]
        ];
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);

        // [実行]
    	$post = [
    		'txtUserId' => '1234567',
    		'txtName' => 'てすとゆーざ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
        $user = [
            'User' => [
                'USER_ID'      => '1234567',
                'NAME'         => 'てすとゆーざ',
                'NAME_KANA'    => 'テストユーザ',
                'COMMENT'      => 'コメント',
                'EMPLOYEE_NUM' => '1234',
                'MAIL_ADDRESS' => 'test@example.com',
            ]
        ];
    	$this->assertEquals($user, CakeSession::read('CMN2000.1234'));
    }

    public function test_insertは登録しようとしたユーザIDがテーブルに存在する場合にエラーメッセージをViewに設定しadduser画面に遷移すること()
    {
        // [準備]
        $user = [
            'User' => [
                'USER_ID'      => '',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ]
        ];
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);

        // [実行]
    	$post = [
    		'txtUserId' => 'testuser1',
    		'txtName' => 'てすとゆーざ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000/adduser/id:1234', $this->headers['Location']);
    	$this->assertContains('ユーザIDが重複しています。', CakeSession::read('Message.alert-error.message'));
    }

    public function test_insertは登録しようとしたユーザIDが削除ユーザとしてテーブルに存在する場合にエラーメッセージをViewに設定しadduser画面に遷移すること()
    {
        // [準備]
        $user = [
            'User' => [
                'USER_ID'      => '',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ]
        ];
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);

        // [実行]
    	$post = [
    		'txtUserId' => 'testuser4',
    		'txtName' => 'てすとゆーざ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000/adduser/id:1234', $this->headers['Location']);
    	$this->assertContains('削除されたユーザとユーザIDが重複しています。', CakeSession::read('Message.alert-error.message'));
    }

    public function test_insertはテーブルの登録に失敗した場合にエラーメッセージをViewに設定しadduser画面に遷移すること()
    {
        // [準備]
        $user = [
            'User' => [
                'USER_ID'      => '',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ]
        ];
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);

        $CMN2000 = $this->generate('CMN2000', [
            'methods' => [
                'saveUser'
            ]
        ]);
        $CMN2000->expects($this->any())->
            method('saveUser')->will($this->returnValue(false));

        // [実行]
    	$post = [
    		'txtUserId' => 'testuser',
    		'txtName' => 'てすとゆーざ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
        $this->assertStringEndsWith('/CMN2000/adduser/id:1234', $this->headers['Location']);
    	$this->assertContains('予期せぬエラーが発生しました。', CakeSession::read('Message.alert-error.message'));
    }

    public function test_insertは入力値をテーブルに登録すること()
    {
        // [準備]
        $user = [
            'User' => [
                'USER_ID'      => '',
                'NAME'         => '',
                'NAME_KANA'    => '',
                'COMMENT'      => '',
                'EMPLOYEE_NUM' => '',
                'MAIL_ADDRESS' => '',
            ]
        ];
        CakeSession::write('CMN2000', ['Users' => [],'1234' => $user]);

        // [実行]
    	$post = [
    		'txtUserId' => 'testuser',
    		'txtName' => 'てすとゆーざ',
    		'txtNameKana' => 'テストユーザ',
    		'txtComment' => 'コメント',
    		'txtEmployeeNum' => '1234',
    		'txtMailAddress' => 'test@example.com'
        ];
        $this->testAction('/CMN2000/insert/id:1234', ['method' => 'post','data' => $post]);

        // [確認]
    	$userOfDb = $this->User->findByUserId('testuser');
    	$this->assertEquals($userOfDb['User']['USER_ID'] ,'testuser');
    	$this->assertEquals($userOfDb['User']['NAME'] ,'てすとゆーざ');
    	$this->assertEquals($userOfDb['User']['NAME_KANA'] ,'テストユーザ');
    	$this->assertEquals($userOfDb['User']['COMMENT'] ,'コメント');
    	$this->assertEquals($userOfDb['User']['EMPLOYEE_NUM'] ,'1234');
    	$this->assertEquals($userOfDb['User']['MAIL_ADDRESS'] ,'test@example.com');
        $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    	$this->assertContains('登録しました。', CakeSession::read('Message.alert-success.message'));
    }




    public function test_editは未ログインの場合にログイン画面を表示すること()
    {
        // [準備]
        CakeSession::delete('loginUserId');

        // [実行]
        $this->testAction('/CMN2000/edit', ['method' => 'post']);

        // [確認]
        $this->assertStringEndsWith('/CMN1000', $this->headers['Location']);
    }

    public function test_editはsessionにCMN2000が存在しなければCMN2000のindexに遷移すること()
    {
      // [準備]
      CakeSession::delete('CMN2000');

      // [実行]
      $this->testAction('/CMN2000/edit/id:testuser1', ['method' => 'get']);

      // [確認]
      $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    }

    public function test_editはリストに存在しないユーザIDが渡された場合にCMN2000のindexに遷移すること()
    {
      // [準備]
      CakeSession::write('CMN2000', ['Users' => $this->User->findAll()]);

      // [実行]
      $this->testAction('/CMN2000/edit/id:unknownuser', ['method' => 'get']);

      // [確認]
      $this->assertStringEndsWith('/CMN2000', $this->headers['Location']);
    }

    public function test_editはtokenをキーにしてsessionに指定ユーザーを登録しedituserに遷移すること()
    {
      // [準備]
      CakeSession::write('CMN2000', ['Users' => $this->User->findAll()]);
      $CMN2000 = $this->generate('CMN2000', [
          'methods' => [
              'getUniqId'
          ]
      ]);
      $CMN2000->expects($this->any())->
          method('getUniqId')->will($this->returnValue('1234'));

      // [実行]
      $this->testAction('/CMN2000/edit/id:testuser1', ['method' => 'get']);

      // [確認]
      $user = $this->User->findByUserId('testuser1');
      $this->assertEquals($user, CakeSession::read('CMN2000.1234'));
      $this->assertStringEndsWith('/CMN2000/edituser/id:1234', $this->headers['Location']);
    }











	//updateの分
	public function test_updateは未ログインの場合にログイン画面を表示すること() {
		// [準備]
		CakeSession::delete('loginUserId');

		// [実行]
		$this->testAction('/CMN2000/update', ['method'=>'get']);

		// [確認]
		$this->assertNotContains('/CMN2000', $this->headers['Location']);
	}

	public function test_updateはtokenが取得できない場合にCMN2000のindex画面に遷移すること(){
		// [準備]

		// [実行]
		$this->testAction('/CMN2000/update', ['method'=>'get']);

		// [確認]
		$this->assertRegExp('/^.*CMN2000$/', $this->headers['Location']);
	}

	public function test_updateはSessionが取得できない場合にCMN2000のindex画面に遷移すること(){
		// [準備]

		// [実行]
		$this->testAction('/CMN2000/update/id:1234', ['method'=>'get']);

		// [確認]
		$this->assertRegExp('/^.*CMN2000$/', $this->headers['Location']);
	}

}
