<?php
class FNC1020Controller extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $uses = ['QuestionaryAnswer', 'Questionary'];
    public $components = ['Security'];
    
    public function index()
    {
    
    }
    
    
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
    	$inputValue = $this->Session->read('FNC1020:input');
    	
    	if (is_null($inputValue)) {
    		$inputValue = ['TITLE'=>'','CONTENT '=>'','DISP_FROM'=>'','DISP_TO'=>'','ANSWER'=>''];
    	}
    	
        $this->set('input_value', $inputValue);
    	$this->render('register');
    }
    
    public function getRegister()
    {
    	//$inputValue = $this->request->data('input_value');
    	// TODO Quetionary�̃J������ݒ肷�� �Q�lMNG1000Controller 168�s��
    	$inputValue = [
            'TITLE'          => $this->request->data('txtTitle')        ?: '',
            'CONTENT'        => $this->request->data('txtContent')    ?: '',
            'DISP_FROM'      => $this->request->data('txtFrom')     ?: '',
            'DISP_TO'        => $this->request->data('txtTo') ?: '',
            'PASSWORD'       => $this->request->data('txtPassword') ?: '',
		];
		
    	$this->Session->write('FNC1020:input',$inputValue);
    	if (!$this->Questionary->validates(['fieldList' => array_keys($inputValue)])) {
    		$this->setAlertMessages($this->Questionary->validationErrors, 'error');
            $this->redirect(['action' => 'edit', '?' => ['t' => $token]]);
            return;
    	}
    	
        $this->set('input_value', $inputValue);
        
        $this->redirect('index');
    	
    }
    
	public function qr() {
	
		$id = $this->request->query('id');
		if (is_null($id)) {
			throw new BadRequestException('ID�����w��ł��B');
		}

		$this->set('id' , $id);

		$this->render('qr');
	}
}
    