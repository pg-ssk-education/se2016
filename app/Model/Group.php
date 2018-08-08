<?php
class User extends AppModel
{
    public $useTable = 'm_group';
    public $primaryKey = 'ID';

    public $validate = [
        'NAME' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'グループ名を設定してください。'
            ]
        ]
    ];

    public function findAll()
    {
        $result = $this->find('all', [
            'conditions' => ['User.STATE'   => 0],
            'order'      => ['User.USER_ID' => 'asc']
        ]);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }

    public function findByUserIdAndEncryptedPassword($userId, $encryptedPassword)
    {
        $conditions = [
            'User.USER_ID'  => $userId,
            'User.PASSWORD' => $encryptedPassword,
            'User.STATE'    => 0
        ];
        $result = $this->find('first', ['conditions' => $conditions]);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }

    public function findByUserIdAndUnencryptedPassword($userId, $unencryptedPassword)
    {
        $encryptedPassword = Security::hash($unencryptedPassword, 'sha256', true);
        return $this->findByUserIdAndEncryptedPassword($userId, $encryptedPassword);
    }

    public function findByUserId($userId, $forUpdate = false)
    {
        $conditions = [
            'User.USER_ID' => $userId,
            'User.STATE'   => 0
        ];
        $result = $this->find('first', ['conditions' => $conditions, 'lock' => $forUpdate]);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }

    public function findByUserIdWithoutState($userId)
    {
        $conditions = [
            'User.USER_ID' => $userId
        ];
        $result =  $this->find('first', ['conditions' => $conditions]);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }

    public function save($data = null, $validate = true, $fieldList = [])
    {
		$result = parent::save($data, $validate, $fieldList);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }

	public function setCommonColumnValue($data) {
		if (isset($data['ID'])) {
		} else {
			$data['INS_DATETIME'] = date('Y-m-d H:i:s');
			$data['INS_USER_ID']  = $this->Session->read('loginUserId') ?: '';
			$data['REVISION']     = 1;
		}
	}
}
