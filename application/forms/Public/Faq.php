<?php 
class Application_Form_Public_Faq extends App_Form_Abstract
{
	protected $_faqModel;
    
    public function init(){
        $this->_faqModel = new Application_Model_Faq();
        $this->setMethod('post');
        $this->setName('aggiungifaq');
        $this->setAction('');


		$this->addElement('textarea', 'domanda', array(
				'label' => "Domanda",
				'filters'    => array('StringTrim', 'StringToLower'),
				'required'   => true,
				'placeholder' => 'Domanda F.A.Q',
				'decorators' => $this->elementDecorators,
		));

		$this->addElement('textarea', 'risposta', array(
				'label' => "Risposta",
				'filters'    => array('StringTrim', 'StringToLower'),
				'required'   => true,
				'placeholder' => 'Risposta F.A.Q',
				'decorators' => $this->elementDecorators,
		));

		$this->addElement('submit', 'submitaddfaq', array(
				'label'    => 'inserisci f.a.q.',
				'decorators' => $this->buttonDecorators,
		));
		
    }
    
}