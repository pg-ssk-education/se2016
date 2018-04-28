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
        return $this->find('all', [
            'conditions' => ['User.STATE'   => 0],
            'order'      => ['User.USER_ID' => 'asc']
        ]);
    }

    public function findByUserIdAndPassword($userId, $password)
    {
        $conditions = [
            'User.USER_ID'  => $userId,
            'User.PASSWORD' => Security::hash($password, 'sha256', true),
            'User.STATE'    => 0
        ];
        return $this->find('first', ['conditions' => $conditions]);
    }

    public function findByUserId($userId)
    {
        $conditions = [
            'User.USER_ID' => $userId,
            'User.STATE'   => 0
        ];
        return $this->find('first', ['conditions' => $conditions]);
    }
    public function findDeletedByUserId($userId)
    {
        $conditions = [
            'User.USER_ID' => $userId,
            'User.STATE'   => 1
        ];
        return $this->find('first', ['conditions' => $conditions]);
    }
}
