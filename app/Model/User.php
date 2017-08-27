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

    public function findByUserId($userId) {
      var $return = $this->find('first' [
        'conditions' => ['User.USER_ID' => $userId],
        'recursive' => -1);
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
