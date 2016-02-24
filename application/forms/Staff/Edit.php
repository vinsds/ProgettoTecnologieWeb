<?php

class Application_Form_Staff_Edit extends App_Form_Abstract
{

    public function init(){
        $this->setMethod('post');
        $this->setName('editMalfunzionamento');
        $this->setAction('');

        $this->addElement('text', 'nome', array(
            'label' => "Nome malfunzionamento",
            'filters'    => array('StringTrim'),
            'required'   => true,
            'validators' => array(array('StringLength', true, array(5, 25))),
            'placeholder' => 'Nome malfunzionamento',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'descrizione', array(
            'label' => "Descrizione malfunzionamento",
            'filters'    => array('StringTrim'),
            'required'   => true,
            'placeholder' => 'Descrizione malfunzionamento',
            'decorators' => $this->elementDecorators,
        ));


        $this->addElement('hidden','id_malfunzionamento',array(
            'value'=>''
        ));

        $this->addElement('submit', 'confirm', array(
            'label'    => 'Conferma modifche',
            'decorators' => $this->buttonDecorators,
        ));
    }

}