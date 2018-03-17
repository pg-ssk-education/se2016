<?php
require_once(dirname(__FILE__) . "/AbstractTest.php");

class CMN1000Test extends AbstractTest
{
    protected function setUp()
    {
        parent::setUp();
    }
    
    public function test_ログイン画面は未ログインの場合にログイン画面を表示すること()
    {
        //[準備]
        $this->url($this->BASE_URL . 'CMN1000/logout');
        
        //[実行]
        $this->url($this->BASE_URL . 'CMN1000/index');
        $this->assertStringStartsWith('ログイン', $this->title());
        
        sleep($this->SLEEP_SECONDS);
        
        $this->outputScreenshot('temp/CMN1000/ログイン画面は未ログインの場合にログイン画面を表示すること.png');
    }
    
    public function test_ログイン画面はログイン済みの場合にトップ画面に遷移すること()
    {
        //[準備]
        $this->url($this->BASE_URL . 'CMN1000/logout');
        
        //[実行]
        $this->url($this->BASE_URL . 'CMN1000/index');
        $this->assertStringStartsWith('ログイン', $this->title());
        
        $this->byId('txtLoginId')->value('admin');
        $this->byId('txtPassword')->value('admin');
        
        $this->outputScreenshot('temp/CMN1000/ログイン画面はログイン済みの場合にトップ画面に遷移すること-1.png');
        
        $this->byCssSelector('.btn')->click();
        $this->assertStringStartsWith('トップ', $this->title());
        
        sleep($this->SLEEP_SECONDS);
        
        $this->outputScreenshot('temp/CMN1000/ログイン画面はログイン済みの場合にトップ画面に遷移すること-2.png');
    }
    
    public function test_ログイン画面はログイン失敗の場合にメッセージを表示すること()
    {
        //[準備]
        $this->url($this->BASE_URL . 'CMN1000/logout');
        
        //[実行]
        $this->url($this->BASE_URL . 'CMN1000/index');
        $this->assertStringStartsWith('ログイン', $this->title());
        
        $this->byId('txtLoginId')->value('invalid');
        $this->byId('txtPassword')->value('admin');
        
        $this->outputScreenshot('temp/CMN1000/ログイン画面はログイン失敗の場合にメッセージを表示すること-1.png');
        
        $this->byCssSelector('.btn')->click();
        $this->assertStringStartsWith('ログイン', $this->title());
        $this->assertEquals('ログインできません。ユーザＩＤ、パスワードを確認してください。', $this->byClassName('alert-error')->text());
        
        sleep($this->SLEEP_SECONDS);
        
        $this->outputScreenshot('temp/CMN1000/ログイン画面はログイン失敗の場合にメッセージを表示すること-2.png');
    }
    
    public function test_ログイン画面はログアウトパラメーターでログアウトできること()
    {
        //[準備]
        $this->url($this->BASE_URL . 'CMN1000/logout');
        
        //[実行]
        $this->url($this->BASE_URL . 'CMN1000/index');
        $this->assertStringStartsWith('ログイン', $this->title());
        
        $this->byId('txtLoginId')->value('admin');
        $this->byId('txtPassword')->value('admin');
        $this->byCssSelector('.btn')->click();
        $this->assertStringStartsWith('トップ', $this->title());
        
        $this->outputScreenshot('temp/CMN1000/ログイン画面はログアウトパラメーターでログアウトできること-1.png');
        
        $this->url($this->BASE_URL . 'CMN1000/logout');
        $this->assertStringStartsWith('ログイン', $this->title());
        
        $this->url($this->BASE_URL . 'CMN1000/index');
        $this->assertStringStartsWith('ログイン', $this->title());
        
        sleep($this->SLEEP_SECONDS);
        
        $this->outputScreenshot('temp/CMN1000/ログイン画面はログアウトパラメーターでログアウトできること-2.png');
    }
}
