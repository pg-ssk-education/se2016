<?php
class InvalidAccess extends AppModel
{
    public $useTable = 't_invalid_access';
    public $primaryKey = 'ACCESS_ID';

    public function findCountByClientIpWithinLastOneMinute($clientIp)
    {
        $conditions = [
            'InvalidAccess.CLIENT_IP' => $clientIp,
            ['InvalidAccess.INS_DATETIME >= NOW() - INTERVAL 60 SECOND']
        ];
        $return = $this->find('count', ['conditions' => $conditions]);

        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $return;
    }

    public function deleteOverOneMinute()
    {
        $conditions = [['InvalidAccess.INS_DATETIME <= NOW() - INTERVAL 60 MINUTE']];
        $this->deleteAll($conditions, false);

        $this->log($this->getDataSource()->getLog(), LOG_INFO);
    }

    public function deleteAllByClientIp($clientIp)
    {
        $conditions = ['InvalidAccess.CLIENT_IP' => $clientIp];
        $this->deleteAll($conditions, false);

        $this->log($this->getDataSource()->getLog(), LOG_INFO);
    }

    public function saveClientIp($clientIp)
    {
        $this->save(['InvalidAccess' => [
            'ACCESS_ID' => DboSource::expression('UUID()'),
            'CLIENT_IP' => $clientIp
        ]]);

        $this->log($this->getDataSource()->getLog(), LOG_INFO);
    }
}
