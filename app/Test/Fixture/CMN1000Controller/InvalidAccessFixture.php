<?php
class InvalidAccessFixture extends CakeTestFixture {
	public $connection = 'test';
	public $import = ['model'=>'InvalidAccess'];

	public function init() {
		$this->records = [
			[
				'ACCESS_ID'=>'1',
				'CLIENT_IP'=>'1.2.3.4',
				'INS_DATETIME'=>date('Y-m-d H:i:s'),
			],
			[
				'ACCESS_ID'=>'2',
				'CLIENT_IP'=>'1.2.3.4',
				'INS_DATETIME'=>date('Y-m-d H:i:s', strtotime('-5 second')),
			],
			[
				'ACCESS_ID'=>'3',
				'CLIENT_IP'=>'1.2.3.4',
				'INS_DATETIME'=>date('Y-m-d H:i:s', strtotime('-1 hour')),
			],
			[
				'ACCESS_ID'=>'4',
				'CLIENT_IP'=>'1.2.3.4',
				'INS_DATETIME'=>date('Y-m-d H:i:s', strtotime('-1 day')),
			],
			[
				'ACCESS_ID'=>'5',
				'CLIENT_IP'=>'1.2.3.4',
				'INS_DATETIME'=>date('Y-m-d H:i:s', strtotime('-1 month')),
			],
			[
				'ACCESS_ID'=>'6',
				'CLIENT_IP'=>'4.3.2.1',
				'INS_DATETIME'=>date('Y-m-d H:i:s', strtotime('-1 minute')),
			],
		];
		parent::init();
	}
}
