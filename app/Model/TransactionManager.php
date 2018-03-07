<?php
App::uses('AppModel', 'Model');
class TransactionManager extends AppModel {
    public $useTable = false;
	private $dataSource = null;
    public function begin(){
        $this->dataSource = $this->getDataSource();
        $this->dataSource->begin($this);
    }
    public function commit(){
    	if ($this->dataSource != null) {
    		$this->dataSource->commit();
    	}
    }
    public function rollback(){
        if ($this->dataSource != null) {
    		$this->dataSource->rollback();
    	}
    }
}
