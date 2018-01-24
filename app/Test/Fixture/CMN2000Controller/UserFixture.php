<?php
App::uses('Model', 'Model');

class UserFixture extends CakeTestFixture {
	public $connection = 'test';
	public $import = ['model'=>'User'];
	
	public $records = [
		[
			'USER_ID'=>'testuser2',
			'PASSWORD'=>'2f2b50323926a3893c9ff36b167ad2dad4dd48935d160bdb68971c9091534f8c',
			'NAME'=>'テストユーザ2',
			'NAME_KANA'=>'テストユーザ2',
			'COMMENT'=>'コメント2',
			'EMPLOYEE_NUM'=>'0002',
			'MAIL_ADDRESS'=>'0002@a',
			'INS_DATETIME'=>'2018-02-02',
			'INS_USER_ID'=>'testuser2',
			'UPD_DATETIME'=>'2018-02-02',
			'UPD_USER_ID'=>'testuser2',
			'ROW_NUM'=>2,
			'REVISION'=>2,
			'STATE'=>0
		],
		[
			'USER_ID'=>'testuser1',
			'PASSWORD'=>'2f2b50323926a3893c9ff36b167ad2dad4dd48935d160bdb68971c9091534f8c',
			'NAME'=>'テストユーザ1',
			'NAME_KANA'=>'テストユーザ1',
			'COMMENT'=>'コメント1',
			'EMPLOYEE_NUM'=>'0001',
			'MAIL_ADDRESS'=>'0001@a',
			'INS_DATETIME'=>'2018-01-01',
			'INS_USER_ID'=>'testuser1',
			'UPD_DATETIME'=>'2018-01-01',
			'UPD_USER_ID'=>'testuser1',
			'ROW_NUM'=>1,
			'REVISION'=>1,
			'STATE'=>0
		],
		[
			'USER_ID'=>'testuser3',
			'PASSWORD'=>'2f2b50323926a3893c9ff36b167ad2dad4dd48935d160bdb68971c9091534f8c',
			'NAME'=>'テストユーザ3',
			'NAME_KANA'=>'テストユーザ3',
			'COMMENT'=>'コメント3',
			'EMPLOYEE_NUM'=>'0003',
			'MAIL_ADDRESS'=>'0003@a',
			'INS_DATETIME'=>'2018-03-03',
			'INS_USER_ID'=>'testuser3',
			'UPD_DATETIME'=>'2018-03-03',
			'UPD_USER_ID'=>'testuser3',
			'ROW_NUM'=>3,
			'REVISION'=>3,
			'STATE'=>0
		],
		[
			'USER_ID'=>'testuser4',
			'PASSWORD'=>'2f2b50323926a3893c9ff36b167ad2dad4dd48935d160bdb68971c9091534f8c',
			'NAME'=>'テストユーザ4',
			'NAME_KANA'=>'テストユーザ4',
			'COMMENT'=>'コメント4',
			'EMPLOYEE_NUM'=>'0004',
			'MAIL_ADDRESS'=>'0004@a',
			'INS_DATETIME'=>'2018-04-04',
			'INS_USER_ID'=>'testuser4',
			'UPD_DATETIME'=>'2018-04-04',
			'UPD_USER_ID'=>'testuser4',
			'ROW_NUM'=>4,
			'REVISION'=>4,
			'STATE'=>1
		],
	];
}
