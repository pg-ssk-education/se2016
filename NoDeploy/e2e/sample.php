<?php
class WebDriverTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->setHost("localhost");
        $this->setPort(4444);
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://localhost/se2016/');
    }
    
    public function test_google()
    {
        $this->url('http://localhost/se2016/');
        $this->assertStringStartsWith('ログイン:', $this->title());
                
        $input = $this->byId('txtLoginId');
        $input->value('admin');

        $this->byId('txtPassword')->value("admin");
        
        $this->byCssSelector('.btn')->click();
        $this->assertStringStartsWith('トップ:', $this->title());
    
        $fp = fopen('hoge.png', 'w');
        fwrite($fp, $this->currentScreenshot());
        fclose($fp);
    }
}
