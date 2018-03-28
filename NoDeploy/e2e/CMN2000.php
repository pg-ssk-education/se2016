<?php
require_once(dirname(__FILE__) . "/AbstractTest.php");

class CMN2000Test extends AbstractTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->deleteTableData(['se2016_m_user']);
        $this->executeSql('insert into se2016_m_user (USER_ID, NAME, PASSWORD) values (:user_id, :name, :password)', [
            [
                ':user_id'  => 'testuser1',
                ':name'     => 'テストユーザ１',
                ':password' => '9f9ff97a8f087c7233a4964367b6f06d4130aaf4c3d4486d987b84d46817d9b4'
            ],
            [
                ':user_id'  => 'testuser2',
                ':name'     => 'テストユーザ２',
                ':password' => '9f9ff97a8f087c7233a4964367b6f06d4130aaf4c3d4486d987b84d46817d9b4'
            ],
            [
                ':user_id'  => 'testuser3',
                ':name'     => 'テストユーザ３',
                ':password' => '9f9ff97a8f087c7233a4964367b6f06d4130aaf4c3d4486d987b84d46817d9b4'
            ]
        ]);
    }

    public function login()
    {
        $this->url($this->BASE_URL . 'CMN1000/logout');
        $this->url($this->BASE_URL . 'CMN1000/index');
        $this->assertStringStartsWith('ログイン', $this->title());
        $this->byId('txtLoginId')->value('testuser1');
        $this->byId('txtPassword')->value('testuser');
        $this->byCssSelector('.btn')->click();
        $this->assertStringStartsWith('トップ', $this->title());
    }

    public function test_CSRF対策されていること()
    {
        $this->login();
        $this->url($this->BASE_URL . 'CMN2000/index');

        $obj = $this->byName('data[_Token][key]');
        $this->assertTrue(isset($obj));
    }


    public function test_一覧画面は登録されているユーザを一覧表示すること()
    {
        $this->login();
        $this->url($this->BASE_URL . 'CMN2000/index');

        $this->assertStringStartsWith('testuser1', $this->byXPath('//*[@id="users"]/tbody/tr[1]/td[1]')->text());
        $this->assertStringStartsWith('testuser2', $this->byXPath('//*[@id="users"]/tbody/tr[2]/td[1]')->text());
        $this->assertStringStartsWith('testuser3', $this->byXPath('//*[@id="users"]/tbody/tr[3]/td[1]')->text());

        $this->assertStringStartsWith('テストユーザ１', $this->byXPath('//*[@id="users"]/tbody/tr[1]/td[2]')->text());
        $this->assertStringStartsWith('テストユーザ２', $this->byXPath('//*[@id="users"]/tbody/tr[2]/td[2]')->text());
        $this->assertStringStartsWith('テストユーザ３', $this->byXPath('//*[@id="users"]/tbody/tr[3]/td[2]')->text());
    }

    public function test_一覧画面は登録されているユーザが存在しない場合に一覧表示しないこと()
    {
        $this->login();
        $this->deleteTableData(['se2016_m_user']);
        $this->url($this->BASE_URL . 'CMN2000/index');

        $this->assertStringStartsWith('No data available in table', $this->byXPath('//*[@id="users"]/tbody')->text());
    }
    public function test_一覧画面は追加画面に遷移できること()
    {
        $this->login();
        $this->url($this->BASE_URL . 'CMN2000/index');
        $this->byClassName('btnAdd')->click();
        $this->assertStringStartsWith('ユーザ管理:登録', $this->title());
    }

    /*
            public function test_一覧画面は編集画面に遷移できること()
            {
            }

            public function test_一覧画面はユーザを削除できること()
            {
            }

            public function test_一覧画面はユーザ削除エラー時にエラーメッセージを表示すること()
            {
            }

            public function test_編集画面はユーザを追加できること()
            {
            }

            public function test_編集画面はエラー時にエラーメッセージを表示すること()
            {
            }
        */
}
