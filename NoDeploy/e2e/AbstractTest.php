<?php

class AbstractTest extends PHPUnit_Extensions_Selenium2TestCase
{
    public $BASE_URL = 'http://localhost/se2016/';
    public $SLEEP_SECONDS = 3;

    protected function setUp()
    {
        parent::setUp();
        $this->setHost("localhost");
        $this->setPort(4444);
        $this->setBrowser('chrome');
        $this->setBrowserUrl($this->BASE_URL);
    }

    protected function outputScreenshot($filename)
    {
        $filename = mb_convert_encoding($filename, "SJIS", "auto");
        $pathinfo = pathinfo($filename);
        if (!is_readable($pathinfo['dirname'])) {
            mkdir($pathinfo['dirname']);
        }
        $fp = fopen($filename, 'w');
        fwrite($fp, $this->currentScreenshot());
        fclose($fp);
    }
}
