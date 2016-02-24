<?php

class Application_Form_Admin_AggiungiUtente extends App_Form_Abstract
{
    public $pwd;
    public $vPwd;

    public function init()
    {

        $this->setMethod('post');
        $this->setName('createutente');
        $this->setAction('');


        $this->addElement(
            'text',
            'nome',
            array(
                'label' => 'Nome',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators
            ));

        $this->addElement(
            'text',
            'cognome',
            array(
                'label' => 'Cognome',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators
            ));

        $this->addElement(
            'select',
            'sesso',
            array(
                'label' => 'Sesso',
                'multiOptions' => array('M' => 'Uomo', 'F' => 'Donna'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators,
            ));

        $this->addElement(
            'text',
            'nascita',
            array(
                'label' => 'Data di nascita (YYYY-MM-GG)',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators
            ));

        $this->addElement(
            'text',
            'citta',
            array(
                'label' => 'Luogo di nascita',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators
            ));

        $this->addElement(
            'text',
            'email',
            array(
                'label' => 'E-mail',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators,
            ));


        $this->addElement(
            'text',
            'user',
            array(
                'label' => 'Username',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators,
            ));

        $this->pwd = $this->createElement(
            'text',
            'password',
            array(
                'label' => 'Password',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators
            ));
        $this->addElement($this->pwd);

        $this->vPwd = $this->createElement(
            'password',
            'verificapassword',
            array(
                'label' => 'Verifica Password',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators
            ));

        $this->addElement($this->vPwd);

        $this->addElement('select', 'role', array(
            'label' => 'Livello',
            'multiOptions' => array(
                'tecnico' => 'Tecnico',
                'staff' => 'Staff',
                'admin' => 'Admin',),
            'required' => true,
            'validators' => array(array('StringLength', true)),
            'decorators' => $this->elementDecorators,
        ));


        $this->addElement('submit', 'creaprofilo', array(
            'label' => 'Crea Profilo',
            'decorators' => $this->buttonDecorators,
        ));

    }

    public function pwdNotChanged()
    {
        $this->getElement('password')->setRequired(false);
        $this->getElement('password')->setIgnore(true);

        $this->getElement('verificapassword')->setRequired(false);
        $this->getElement('verificapassword')->setIgnore(true);
    }

}