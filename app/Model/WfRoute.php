<?php
class WfRoute extends AppModel {
    /** 使用テーブル名 */
    var $useTable = 'm_wf_route';
    /** 主キー：名前がidの場合のみ、省略できる。 */
    var $primaryKeyArray = array('WF_ROUTE_ID','STEP_NUM');
    
    public function getWfRoute() {
    	return $this->find('all', array(
    		'order' => array('WfRoute.WF_ROUTE_ID' => 'asc','WfRoute.STEP_NUM' => 'asc')
    	));
    }
}