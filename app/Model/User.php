<?php
/** 
 * /app/Model/User.php
 */
class User extends AppModel 
{
    var $useTable = 'm_user';
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
    
}