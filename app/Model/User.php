<?php
class User extends AppModel
{
    public $useTable = 'm_user';
    public $primaryKey = 'USER_ID';

    public $validate = [
        'USER_ID' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'ユーザIDを設定してください。'
            ],
            'rule-alphaNumeric' => [
                'rule' => '/^[a-zA-Z0-9]+$/u',
                'message' => 'ユーザIDはアルファベットまたは数字のみで設定してください。'
            ],
            'rule-lengthBetween' => [
                'rule' => ['lengthBetween', 8, 32],
                'message' => 'ユーザIDは8文字以上32文字以下で設定してください。'
            ],
        ],
        'NAME' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => '氏名を設定してください。'
            ]
        ],
        'NAME_KANA' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => '氏名(カナ)を設定してください。'
            ]
        ],
        'EMPLOYEE_NUM' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => '社員番号を設定してください。'
            ],
            'rule-numeric' => [
                'rule' => '/^[0-9]+$/u',
                'message' => '社員番号は数字のみで設定してください。'
            ]
        ],
        'MAIL_ADDRESS' => [
            'rule-mail' => [
                'rule' => 'email',
                'message' => 'メールアドレスはメールアドレス形式で設定してください。',
                'allowEmpty' => true
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
