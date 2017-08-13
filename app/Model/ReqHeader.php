<?php
class ReqHeader extends AppModel 
{
    var $useTable = 't_req_header';

    var $primaryKey = 'REQ_ID';
    
    public $validate = array(
    );
    
    public function findByUserIdAndDocIdAndReqState($userId, $docId, $reqState) {
		$conditions = array('ReqHeader.USER_ID' => $userId);
		
		if (isset($docId)) {
			$conditions = $conditions + array('ReqHeader.DOC_ID' => $docId);
		}
		
		if (isset($reqState)) {
			$conditions = $conditions + array('ReqHeader.REQ_STATE' => $reqState);
		}

		return $this->find('all', array(
			'conditions' => $conditions
		));
    }
    
}