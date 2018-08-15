<?php
class InvalidAccess extends AppModel
{
    public $useTable = 't_invalid_access';
    public $primaryKey = 'ID';

    public function findCountByClientIp($clientIp)
    {
        $conditions = [
            'InvalidAccess.CLIENT_IP' => $clientIp
        ];
        $result = $this->find('count', ['conditions' => $conditions]);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }

    public function deleteBefore($interval)
    {
    	$now = new DateTime();
    	$dateIntervalForDalete = DateInterval::createFromDateString($interval);
    	$thresoldInsDatetimeForDelete = date_format(date_sub($now, $dateIntervalForDalete), 'Y-m-d H:i:s');
        $conditions = [
        	["InvalidAccess.INS_DATETIME <= '$thresoldInsDatetimeForDelete'"]
        ];
        $this->deleteAll($conditions, false);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
    }
    
    public function save($data = null, $validate = true, $fieldList = [])
    {
		$result = parent::save($data, $validate, $fieldList);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }
}
