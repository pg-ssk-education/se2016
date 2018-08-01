<?php
class Questionary extends AppModel
{
    public $useTable = 't_questionary';
    public $primaryKey = 'ID';
    
    public $validate = [
        'QUESTIONARY_ID ' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'アンケートIDを設定してください。'
            ]
        ],
        'TITLE' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'タイトルを設定してください。'
            ]
        ],
        'CONTENT' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => '本文を設定してください。'
            ]
        ],
        'DISP_FROM' => [
            'rule-notEmpty' => [
                'rule' => ['dateCheck'],
                'message' => '有効期限FROMが不正な形式です。'
            ]
        ],
        'DISP_TO' => [
            'rule-notEmpty' => [
                'rule' => ['dateCheck'],
                'message' => '有効期限TOが不正な形式です。'
            ]
        ],
        'PASSWORD' =>[
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'パスワードを設定してください。'
            ]
        ]
    ];
    
    public function dateCheck($target)
    {
    	if(DateTime::createFromFormat('Y/m/d',$target) === FALSE ) {
    		return FALSE;
    	}
    	return TRUE;
    }
    
    public function save($data = null, $validate = true, $fieldList = [])
    {
		$result = parent::save($data, $validate, $fieldList);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }
    
}