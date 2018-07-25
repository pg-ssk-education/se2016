<?php
class Questionary extends AppModel
{
    public $useTable = 't_questionary';
    public $primaryKey = 'ID';
    
    public function save($data = null, $validate = true, $fieldList = [])
    {
		$result = parent::save($data, $validate, $fieldList);
        $this->log($this->getDataSource()->getLog(), LOG_INFO);
        return $result;
    }
}