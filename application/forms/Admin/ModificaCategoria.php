<?php

class Application_Form_Admin_ModificaCategoria extends App_Form_Abstract
{

    public function init()
    {
        $this->setMethod('post');
        $this->setName('editcategoria');
        $this->setAction('');

        $this->addElement('text', 'nome', array(
            'label' => "Nome categoria",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Nome categoria',
            'validators' => array(array('StringLength', true, array(1, 40))),
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('hidden','id_categoria',array(
            'values'=>''
        ));


        $this->addElement('submit', 'submiteditcategoria', array(
            'label' => 'Aggiungi categoria',
            'decorators' => $this->buttonDecorators,
        ));
    }

}