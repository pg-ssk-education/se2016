<?php
/** 
 * /app/Model/InvalidAccess.php
 */
class InvalidAccess extends AppModel 
{
    /** 使用テーブル名 */
    var $useTable = 't_invalid_access';
    /** 主キー：名前がidの場合のみ、省略できる。 */
    var $primaryKey = 'ACCESS_ID';
    
    

    public function validate($clientIp) {
    	$this->log(array($clientIp));
		return $this->find('first', array(
			'conditions' => ['InvalidAccess.CLIENT_IP' => $clientIp],
			'fields' => ['COUNT(*) AS FAILURE_COUNT, CASE WHEN (COALESCE(MAX(InvalidAccess.ACCESS_DATETIME), NOW()) + INTERVAL 60 SECOND) > NOW() THEN 1 ELSE 0 END AS IS_LOCKED'],
			'group' => ['InvalidAccess.CLIENT_IP'],
			'recursive' => -1
		));
    }   
}