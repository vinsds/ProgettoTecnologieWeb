<?php

class Application_Form_Staff_EditS extends App_Form_Abstract
{

    public function init(){
        $this->setMethod('post');
        $this->setName('editSoluzione');
        $this->setAction('');


        $this->addElement('text', 'nome', array(
            'label' => "Modifica soluzione",
            'filters'    => array('StringTrim'),
            'required'   => true,
            'placeholder' => 'Nome soluzione',
            'decorators' => $this->elementDecorators,
        ));


        $this->addElement('textarea', 'descrizione', array(
            'label' => "Descrizione soluzione",
            'filters'    => array('StringTrim'),
            'required'   => true,
            'placeholder' => 'Descrizione soluzione',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('hidden','id_soluzione',array(
            'value'=>''
        ));

        $this->addElement('submit', 'confirm', array(
            'label'    => 'Conferma modifche',
            'decorators' => $this->buttonDecorators,
        ));
    }

}