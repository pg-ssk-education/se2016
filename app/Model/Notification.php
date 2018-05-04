<?php
class Notification extends AppModel
{
    public $useTable = 't_notification';
    public $primaryKey = 'NOTIFICATION_ID';

    public function findAllByTargetUserId($targetUserId)
    {
        $conditions = [
            'Notification.TARGET_USER_ID' => $targetUserId,
            'Notification.STATE'          => 0
        ];
        $order = [
            'Notification.UPD_DATETIME' => 'desc'
        ];
        $notifications =  $this->find('all', [
            'conditions' => $conditions,
            'order'      => $order
        ]);

        $this->log($this->getDataSource()->getLog(), LOG_INFO);

        return $notifications;
    }
}
