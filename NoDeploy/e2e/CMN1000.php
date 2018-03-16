<?php
class webDriverTest extends PHPUnit_Extensions_Selenium2TestCase
{
	protected function setUp()
	{
		parent::setUp();
		$this->setHost("localhost");
		$this->setPort(4444);
		$this->setBrowser('chrome');
		$this->setBrowserUrl('http://localhost:8080/se2016_nagata/');
	}
	
	public function test_ログイン画面は未ログインの場合にログイン画面を表示すること()
	{
		//[準備]
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/logout');
		
		//[実行]
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/index');
		$this->assertStringStartsWith('ログイン', $this->title());
		
		sleep(3);
		
		$fp = fopen('CMN1000_ログイン画面は未ログインの場合にログイン画面を表示すること.png', 'w');
		fwrite($fp, $this->currentScreenshot());
		fclose($fp);
	}
	public function test_ログイン画面はログイン済みの場合にトップ画面に遷移すること()
	{
		//[準備]
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/logout');
		
		//[実行]
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/index');
		$this->assertStringStartsWith('ログイン', $this->title());
		
		$this->byId('txtLoginId')->value('admin');
		$this->byId('txtPassword')->value('admin');
		
		$fp = fopen('CMN1000_ログイン画面はログイン済みの場合にトップ画面に遷移すること-1.png', 'w');
		fwrite($fp, $this->currentScreenshot());
		fclose($fp);
		
		$this->byCssSelector('.btn')->click();
		$this->assertStringStartsWith('トップ', $this->title());
		
		sleep(3);
		
		$fp = fopen('CMN1000_ログイン画面はログイン済みの場合にトップ画面に遷移すること-2.png', 'w');
		fwrite($fp, $this->currentScreenshot());
		fclose($fp);
	}
	public function test_ログイン画面はログイン失敗の場合にメッセージを表示すること()
	{
		//[準備]
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/logout');
		
		//[実行]
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/index');
		$this->assertStringStartsWith('ログイン', $this->title());
		
		$this->byId('txtLoginId')->value('invalid');
		$this->byId('txtPassword')->value('admin');
		
		$fp = fopen('CMN1000_ログイン画面はログイン失敗の場合にメッセージを表示すること-1.png', 'w');
		fwrite($fp, $this->currentScreenshot());
		fclose($fp);
		
		$this->byCssSelector('.btn')->click();
		$this->assertStringStartsWith('ログイン', $this->title());
		$this->assertEquals('ログインできません。ユーザＩＤ、パスワードを確認してください。', $this->byClassName('alert-error')->text());
		
		sleep(3);
		
		$fp = fopen('CMN1000_ログイン画面はログイン失敗の場合にメッセージを表示すること-2.png', 'w');
		fwrite($fp, $this->currentScreenshot());
		fclose($fp);
	}
	public function test_ログイン画面はログアウトパラメーターでログアウトできること()
	{
		//[準備]
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/logout');
		
		//[実行]
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/index');
		$this->assertStringStartsWith('ログイン', $this->title());
		
		$this->byId('txtLoginId')->value('admin');
		$this->byId('txtPassword')->value('admin');
		$this->byCssSelector('.btn')->click();
		$this->assertStringStartsWith('トップ', $this->title());
		
		$fp = fopen('CMN1000_ログイン画面はログアウトパラメーターでログアウトできること-1.png', 'w');
		fwrite($fp, $this->currentScreenshot());
		fclose($fp);
		
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/logout');
		$this->assertStringStartsWith('ログイン', $this->title());
		
		$this->url('http://localhost:8080/se2016_nagata/CMN1000/index');
		$this->assertStringStartsWith('ログイン', $this->title());
		
		sleep(3);
		
		$fp = fopen('CMN1000_ログイン画面はログアウトパラメーターでログアウトできること-2.png', 'w');
		fwrite($fp, $this->currentScreenshot());
		fclose($fp);
	}
}