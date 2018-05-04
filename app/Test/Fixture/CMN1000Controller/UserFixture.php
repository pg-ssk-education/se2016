<?php
App::uses('Model', 'Model');

class UserFixture extends CakeTestFixture {
	public $connection = 'test';
	public $import = ['model'=>'User'];

	public $records = [
		[
			'USER_ID'=>'testuser',
			'PASSWORD'=>'2f2b50323926a3893c9ff36b167ad2dad4dd48935d160bdb68971c9091534f8c',
			'NAME'=>'テストユーザ',
			'NAME_KANA'=>'テストユーザ'
		],
	];
}
