<?php

class Application_Form_Admin_AggiungiCategoria extends App_Form_Abstract
{

    public function init()
    {
        $this->setMethod('post');
        $this->setName('createcategoria');
        $this->setAction('');

        $this->addElement('text', 'nome', array(
            'label' => "Nome categoria",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Nome categoria',
            'validators' => array(array('StringLength', true, array(1, 25))),
            'decorators' => $this->elementDecorators,
        ));


        $this->addElement('submit', 'submitcategoria', array(
            'label' => 'Aggiungi categoria',
            'decorators' => $this->buttonDecorators,
        ));
    }

}