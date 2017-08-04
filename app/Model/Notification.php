<?php
/** 
 * /app/Model/Notification.php
 */
class Notification extends AppModel {
    /** 使用テーブル名 */
    var $useTable = 't_notification';
    /** 主キー：名前がidの場合のみ、省略できる。 */
    var $primaryKey = 'NOTIFICATION_ID';
    
    public function getNotification($userId) {
    	return $this->find('all', array(
    		'conditions' => array('Notification.TARGET_USER_ID' => $userId), 
    		'order' => array('Notification.ROW_NUM' => 'asc')
    	));
    }
}