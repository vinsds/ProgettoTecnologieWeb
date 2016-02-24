<?php 
class Application_Form_Public_Login extends App_Form_Abstract
{
    
    public function init(){
        
        $this->setMethod('post');
        $this->setName('login');
        $this->setAction('');


        $this->addElement('text', 'user', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'placeholder'      => 'nome utente',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 25))
            ),
            'required'   => true,
            'placeholder'      => 'password',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('submit', 'login', array(
            'label' => 'Login',
            'decorators' => $this->buttonDecorators,
        ));
    }




    
}