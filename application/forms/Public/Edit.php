<?php 
class Application_Form_Public_Edit extends App_Form_Abstract
{
	protected $_faqModel;
    
    public function init(){
        $this->_faqModel = new Application_Model_Faq();
        $this->setMethod('post');
        $this->setName('editfaq');
        $this->setAction('');


		$this->addElement('textarea', 'domanda', array(
				'label' => "Descrizione soluzione",
				'filters'    => array('StringTrim', 'StringToLower'),
				'required'   => false,
				'placeholder' => 'Domanda F.A.Q',
				'decorators' => $this->elementDecorators,
		));

		$this->addElement('textarea', 'risposta', array(
				'label' => "Descrizione soluzione",
				'filters'    => array('StringTrim', 'StringToLower'),
				'required'   => false,
				'placeholder' => 'Risposta F.A.Q',
				'decorators' => $this->elementDecorators,
		));

		$this->addElement('submit', 'submit-addSol', array(
				'label'    => 'conferma modifica',
				'decorators' => $this->buttonDecorators,
		));


	}
    
}