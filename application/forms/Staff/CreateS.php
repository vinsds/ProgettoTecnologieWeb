<?php

class Application_Form_Staff_CreateS extends App_Form_Abstract{

    public function init(){
        $this->setMethod('post');
        $this->setName('createSoluzione');
        $this->setAction('');

        $this->addElement('text', 'nome_soluzione', array(
            'label' => "Nome soluzione",
            'filters'    => array('StringTrim'),
            'required'   => true,
            'placeholder' => 'Nome soluzione',
            'validators' => array(array('StringLength', true, array(5, 25))),
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'descrizione_soluzione', array(
            'label' => "Descrizione soluzione",
            'filters'    => array('StringTrim'),
            'required'   => true,
            'placeholder' => 'Descrizione soluzione',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('submit', 'submit-addSol', array(
            'label'    => 'inserisci soluzione',
            'decorators' => $this->buttonDecorators,
        ));
    }
}
