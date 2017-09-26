<?php
class User extends AppModel {
	var $useTable = 'm_user';
	var $primaryKey = 'USER_ID';

	public $validate = [
		'USER_ID'=>[
			'rule'=>'notEmpty'
		],
		'PASSWORD'=>[
			'rule'=>'notEmpty'
		]
	];

	public function findByUserIdAndPassword($userId, $password) {
		$conditions = [
			'User.USER_ID'=>$userId,
			'User.PASSWORD'=>Security::hash($password, 'sha256', true),
			'User.STATE'=>0
		];
		$return = $this->find('first', ['conditions' => $conditions]);

		$this->log($this->getDataSource()->getLog(), LOG_INFO);
		return $return;
	}

  public function update($data) {
    $data['User']['UPD_DATETIME'] = DboSource::expression('NOW()');
    $data['User']['UPD_USER_ID'] = '';
    $data['User']['REVISION'] = $data['User']['REVISION'] + 1;
    $this->save($data);
  }
}
