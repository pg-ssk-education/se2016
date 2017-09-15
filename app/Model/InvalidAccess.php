<?php
/**
 * /app/Model/InvalidAccess.php
 */
class InvalidAccess extends AppModel
{
  var $useTable = 't_invalid_access';
  var $primaryKey = 'ACCESS_ID';

  public function findCountByClientIpAndLastOneMinute($clientIp) {
	   return $this->find('count', [
		     'conditions' => ['InvalidAccess.CLIENT_IP' => $clientIp, ], 'InvalidAccess.ACCESS_DATETIME' => '>= NOW() - INTERVAL 60 SECOND']
	      ]);
  }

  public function saveInvalidClientIp($clientIp) {

	$this->save(['InvalidAccess' => [
		'ACCESS_ID' => DboSource::expression('UUID()'),
		'CLIENT_IP' => $clientIp,
		'ACCESS_DATETIME' => DboSource::expression('NOW()'),
	]]);
  }
}
