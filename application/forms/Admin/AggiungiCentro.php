<?php

class Application_Form_Admin_AggiungiCentro extends App_Form_Abstract
{

    public function init()
    {
        $this->setMethod('post');
        $this->setName('createcentro');
        $this->setAction('');

        $this->addElement('text', 'nome', array(
            'label' => "Nome centro",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Nome centro',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'indirizzo', array(
            'label' => "Indirizzo centro",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Indirizzo centro',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'mail', array(
            'label' => "Mail centro",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => false,
            'placeholder' => 'Mail centro',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'telefono', array(
            'label' => "Telefono centro",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Telefono centro',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'descrizione', array(
            'label' => "Descrizione centro",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => false,
            'placeholder' => 'Descrizione centro',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('submit', 'submitCentro', array(
            'label' => 'inserisci centro',
            'decorators' => $this->buttonDecorators,
        ));


    }

}