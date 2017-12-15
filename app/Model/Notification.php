<?php
class Notification extends AppModel {

    var $useTable = 't_notification';
    var $primaryKey = 'NOTIFICATION_ID';
    
    public function getNotification($userId) {
    	return $this->find('all', array(
    		'conditions' => array('Notification.TARGET_USER_ID' => $userId), 
    		'order' => array('Notification.ROW_NUM' => 'asc')
    	));
    }
}

