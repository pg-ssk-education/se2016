<?php
class CMN2020Controller extends AppController {
	public $helpers = ['Html', 'Form'];
	
	// 使用するモデル
	public $uses = ['WfRoute'];

	function index(){
		$wfRouteTable=[];
		$wfRoutes=$this->WfRoute->findAll();
		foreach ($wfRoutes as $wfRoute) {
			$users=[];
			$wfRouteSteps=$this->wfRouteStep->findAllByWfRouteId($wfRoute['WfRoute']['WF_ROUTE_ID']);

			foreach ($wfRouteSteps as $wfRouteStep) {
				$user=$this->User->findByUserId($wfRouteStep['WfRouteStep']['APPROVAL_USER_ID']);
				array_push($users, $user['User']['NAME']);
			}

			array_push($wfRouteTable, [
				'Route'=>$wfRoute,
				'ApprovalUserNames'=>implode(', ', $users)
			]);
		}
		$this->set('wfRouteTable', $wfRouteTable);
	}
	
	function action() {
	}
}