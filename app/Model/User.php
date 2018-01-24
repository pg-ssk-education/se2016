<?php
class User extends AppModel {
	var $useTable = 'm_user';
	var $primaryKey = 'USER_ID';

	public function findAll() {
		return $this->find('all',[
			'conditions' => ['User.STATE' => 0],
			'order' => ['User.USER_ID' => 'asc']
		]);
	}

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

	public function findByUserId($userId) {
		$conditions = [
			'User.USER_ID'=>$userId,
			'User.STATE'=>0
		];
		
		return $this->find('first', ['conditions' => $conditions]);
	}
}
