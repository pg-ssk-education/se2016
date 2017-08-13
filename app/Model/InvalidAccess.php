<?php
/** 
 * /app/Model/InvalidAccess.php
 */
class InvalidAccess extends AppModel 
{
    var $useTable = 't_invalid_access';
    var $primaryKey = 'ACCESS_ID';
    

    public function findByClientIp($clientIp) {

		return $this->find('first', array(
			'conditions' => ['InvalidAccess.CLIENT_IP' => $clientIp],
			'fields' => ['COUNT(*) AS FAILURE_COUNT, CASE WHEN (COALESCE(MAX(InvalidAccess.ACCESS_DATETIME), NOW()) + INTERVAL 60 SECOND) > NOW() THEN 1 ELSE 0 END AS IS_LOCKED'],
			'group' => ['InvalidAccess.CLIENT_IP'],
			'recursive' => -1
		));
    }  
    
    public function saveInvalidClientIp($clientIp) {

		$this->save(['InvalidAccess' => [
			'ACCESS_ID' => DboSource::expression('UUID()'), 
			'CLIENT_IP' => $clientIp, 
			'ACCESS_DATETIME' => DboSource::expression('NOW()'),
		]]);
    }
}