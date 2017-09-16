<?php
class CMN1020ControllerTest extends ControllerTestCase {

	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function test_sendは入力ユーザIDが存在しない場合にcompleteを表示すること() {
		$cmn1020Controller = $this->setMock('CMN1020Controller', ['render']);

		$cmn1020Controller->expects($this->once())
			->method('render')
			->with($this->equalTo('complete'));
	}
}
