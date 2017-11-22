<?php
class WfRouteStep extends AppModel {
    var $useTable = 'm_wf_route_step';
    var $primaryKeyArray = ['WF_ROUTE_ID', 'STEP_NUM'];
    
    public function findAllByWfRouteId($wfRouteId) {

    	return $this->find('all', [
    		'conditions' => ['WfRouteStep.WF_ROUTE_ID' => $wfRouteId],
    		'order'      => ['WfRouteStep.STEP_NUM' => 'asc']
    	]);
    }
}