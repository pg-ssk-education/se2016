<?php
class CMN2020Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	
	// 使用するモデル
	public $uses = ['WfRoute'];

	function index(){
		$wfRoutes=$this->WfRoute->getWfRoute();
		$wfRouteTable=array();
		$this->set('wfRoutes',$wfRoutes);
		foreach ($wfRoutes as $wfRoute):
			if(array_key_exists($wfRoute['WfRoute']['WF_ROUTE_ID'],$wfRouteTable)==false){
				$wfRouteTable[$wfRoute['WfRoute']['WF_ROUTE_ID']]=$wfRoute['WfRoute']['APPROVAL_USER_ID'];
			}else{
				$wfRouteTable[$wfRoute['WfRoute']['WF_ROUTE_ID']].=$wfRoute['WfRoute']['APPROVAL_USER_ID'];
			}
		endforeach;
		$this->set('wfRouteTable',$wfRouteTable);

	}
}