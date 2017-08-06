<?php
/** 
 * /app/Model/User.php
 */
class User extends AppModel 
{
    /** 使用テーブル名 */
    var $useTable = 'm_user';
    /** 主キー：名前がidの場合のみ、省略できる。 */
    var $primaryKey = 'USER_ID';
    
    public $validate = array(
    	'USER_ID' => array(
    		'rule' => 'notEmpty'
    	),
    	'PASSWORD' => array(
    		'rule' => 'notEmpty'
    	)
    );
    
    public function login($id, $password) {
    	$this->log(array($id, $password));
		return $this->find('first', array(
			'conditions' => ['User.USER_ID' => $id, 'User.PASSWORD' => hash('sha256', 'egahoo2k'.base64_encode($id).$password.'egahoo2k')],
			'recursive' => -1
		));
    }
    
    public function test() {
    	return $this->query('select * from se2016_m_user', array());
    }
    
}