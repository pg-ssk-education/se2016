<?php
class WfRoute extends AppModel {
    var $useTable = 'm_wf_route';
    var $primaryKey = 'WF_ROUTE_ID';
    
    public function findAll() {
    	return $this->find('all', [
    		'order' => ['WfRoute.UPD_DATETIME' => 'desc']
    	]);
    }
}