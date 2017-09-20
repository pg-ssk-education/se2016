<?php
App::uses('Model', 'Model');

class UserFixture extends CakeTestFixture {
	public $connection = 'test';
	public $import = ['model'=>'User'];
	/*
	public $records = [
		['USER_ID' => 'oda', 'PASSWORD' => '4f92d6c838d9167d4875e692790f137926503d6a15fc7a639c2075d41d42bfbd', 'NAME' => '織田信長', 'NAME_KANA' => 'オダノブナガ', 'COMMENT' => '尾張', 'SEAL_FILE_ID' => '', 'EMPLOYEE_NUM' => '', 'MAIL_ADDRESS' => 'honnouji@sample.com', 'PASSWORD_LIMIT' => '9999-12-31', 'PASSWORD_KEY' => 'nobunaga', 'INS_DATETIME' => '2017-06-04 12:34:56', 'INS_USER_ID' => 'system', 'UPD_DATETIME' => '2017-06-04 12:34:56', 'UPD_USER_ID' => 'system', 'ROW_NUM' => 1, 'REVISION' => 1, 'STATE' => 0]
	];
	*/
	public $records = [
		[
			'USER_ID'=>'testuser',
			'PASSWORD'=>'2f2b50323926a3893c9ff36b167ad2dad4dd48935d160bdb68971c9091534f8c',
			'NAME'=>'テストユーザ',
			'NAME_KANA'=>'テストユーザ'
		],
	];
}
