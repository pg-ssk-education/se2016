<?php
class Questionary extends AppModel
{
    public $useTable = 't_questionary';
    public $primaryKey = 'ID';
    
    public $validate = [
        'QUESTIONARY_ID ' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => '�A���P�[�gID��ݒ肵�Ă��������B'
            ]
        ],
        'TITLE' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => '�^�C�g����ݒ肵�Ă��������B'
            ]
        ],
        'CONTENT' => [
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => '�{����ݒ肵�Ă��������B'
            ]
        ],
        'DISP_FROM' => [
            'rule-notEmpty' => [
                'rule' => ['dateCheck'],
                'message' => '�L������FROM���s���Ȍ`���ł��B'
            ]
        ],
        'DISP_TO' => [
            'rule-notEmpty' => [
                'rule' => ['dateCheck'],
                'message' => '�L������TO���s���Ȍ`���ł��B'
            ]
        ],
        'PASSWORD' =>[
            'rule-notEmpty' => [
                'rule' => 'notBlank',
                'message' => '�p�X���[�h��ݒ肵�Ă��������B'
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