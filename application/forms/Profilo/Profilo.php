<?php

class Application_Form_Profilo_Profilo extends App_Form_Abstract
{
    public $pwd;
    public $vPwd;

    public function init()
    {

        $this->setMethod('post');
        $this->setName('modificaprofilo');
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

        $this->addElement('submit', 'modificaprofilo', array(
            'label' => 'Modifica Profilo',
            'decorators' => $this->buttonDecorators
        ));

//	$this->setDecorators(array(
//            'FormElements',
//            array('HtmlTag', array('tag' => 'table')),
//            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
//            'Form'
//        ));


    }

    public function pwdNotChanged()
    {
        $this->getElement('password')->setRequired(false);
        $this->getElement('password')->setIgnore(true);

        $this->getElement('verificapassword')->setRequired(false);
        $this->getElement('verificapassword')->setIgnore(true);

//        var_dump($this); die();
    }

}