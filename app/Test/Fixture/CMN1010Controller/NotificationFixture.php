<?php
class NotificationFixture extends CakeTestFixture {
	public $connection = 'test';
	public $import = ['model'=>'Notification'];
	public $records = [
		[
			'NOTIFICATION_ID'=>'1',
			'TARGET_USER_ID'=>'testuser',
			'LEVEL'=>'I',
			'COMMENT'=>'testuser3行目',
			'UPD_DATETIME'=>'2010-09-10 12:34:56'
		],
		[
			'NOTIFICATION_ID'=>'2',
			'TARGET_USER_ID'=>'testuser',
			'LEVEL'=>'I',
			'COMMENT'=>'testuser1行目',
			'UPD_DATETIME'=>'2015-01-31 12:34:56'
		],
		[
			'NOTIFICATION_ID'=>'3',
			'TARGET_USER_ID'=>'testuser',
			'LEVEL'=>'I',
			'COMMENT'=>'testuser2行目',
			'UPD_DATETIME'=>'2010-09-10 12:34:57'
		],
		[
			'NOTIFICATION_ID'=>'4',
			'TARGET_USER_ID'=>'other',
			'LEVEL'=>'I',
			'COMMENT'=>'表示対象外',
			'UPD_DATETIME'=>'2010-09-11 12:34:56'
		],
		[
			'NOTIFICATION_ID'=>'5',
			'TARGET_USER_ID'=>'',
			'LEVEL'=>'I',
			'COMMENT'=>'表示対象外',
			'UPD_DATETIME'=>'2010-09-11 12:34:56'
		],
	];

	public function init() {
		parent::init();
	}
}
