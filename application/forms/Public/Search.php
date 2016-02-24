<?php

class Application_Form_Public_Search extends App_Form_Abstract
{

    public function init(){
        $this->setMethod('post');
        $this->setName('formRicerca');
        $this->setAction('');

        $this->addElement('text', 'desc_prod', array(
            'filters'    => array('StringTrim', 'StringToLower'),
//            'validators' => array(
//                array('StringLength', true, array(5, 25))
//            ),
            'required'   => false,
            'placeholder' => 'Inserire prodotto da ricercare...',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'descrizione', array(
            'filters'    => array('StringTrim', 'StringToLower'),
//            'validators' => array(
//                array('StringLength', true, array(5, 25))
//            ),
            'required'   => false,
            'placeholder' => 'Inserire malfunzionamento da ricercare...',
            'decorators' => $this->elementDecorators,
        ));



        $this->addElement('submit', 'search-send', array(
            'label'    => 'Avvia ricerca',
            'decorators' => $this->buttonDecorators,
        ));
    }

}