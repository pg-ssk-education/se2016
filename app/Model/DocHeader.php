<?php
class DocHeader extends AppModel 
{
    var $useTable = 'm_doc_header';

    var $primaryKey = 'DOC_ID';
    
    public $validate = array(
    );
    
    public function findByKey($docId) {
		return $this->find('first', array(
			'conditions' => ['DocHeader.DOC_ID' => $id]
		));
    }
    
}