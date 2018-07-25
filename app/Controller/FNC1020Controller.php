<?php
class FNC1020Controller extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $uses = ['QuestionaryAnswer', 'Questionary'];
    public $components = ['Security'];
    
    
    
    
    public function register()
    {
    	if ($this->request->is('post')) {
            $this->postRegister();
        } else {
            $this->getRegister();
        }
        
        
        
    }
    
    public function postRegister()
    {
    	
    }
    
    public function getRegister()
    {
    	$inputValue = $this->Session->read('FNC1020:input');
    	
    	if (is_null($inputValue)) {
    		$inputValue = ['TITLE'=>'','CONTENT '=>'','DISP_FROM'=>'','DISP_TO'=>'','ANSWER'=>''];
    	}
    	
        $this->set('input_value', $inputValue);
        
        $this->render('register');
    	
    }
    
}
    