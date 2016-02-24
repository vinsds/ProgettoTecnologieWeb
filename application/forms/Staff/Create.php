<?php

class Application_Form_Staff_Create extends App_Form_Abstract
{

    public function init(){
        $this->setMethod('post');
        $this->setName('createMalfunzionamento');
        $this->setAction('');

        $this->addElement('text', 'nome_malfunzionamento', array(
            'label' => "Nome malfunzionamento",
            'filters'    => array('StringTrim'),
            'required'   => true,
            'validators' => array(array('StringLength', true, array(5, 25))),
            'placeholder' => 'Nome malfunzionamento',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'descrizione_malfunzionamento', array(
            'label' => "Descrizione malfunzionamento",
            'filters'    => array('StringTrim'),
            'required'   => true,
            'placeholder' => 'Descrizione malfunzionamento',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('submit', 'submitaddMalf', array(
            'label'    => 'inserisci malfunzionamento',
            'decorators' => $this->buttonDecorators,
        ));
    }

}