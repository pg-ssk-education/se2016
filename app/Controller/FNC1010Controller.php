<?php
class FNC1010Controller extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $uses = ['Notification'];

    public function index()
    {
        if (!$this->checkAuth()) {
            return;
        }

        $this->set('title_for_layout', 'トップ');
        $this->set('notifications', $this->Notification->findAllByTargetUserId($this->Session->read('loginUserId')));
    }
}
