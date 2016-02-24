<?php

class Application_Form_Public_Contatti extends App_Form_Abstract
{

    public function init(){
        $this->setMethod('post');
        $this->setName('formContatti');
		$this->setAction('');

		$this->addElement('text', 'nome', array(
			'filters'    => array('StringTrim', 'StringToLower'),
			'validators' => array(
				array('StringLength', true, array(5, 25))
			),
			'required'   => true,
//			'value'=>'nome',
			'placeholder' => 'nome',
			'decorators' => $this->elementDecorators,
		));

		$this->addElement('text', 'cognome', array(
			'filters'    => array('StringTrim', 'StringToLower'),
			'validators' => array(
				array('StringLength', true, array(5, 25))
			),
			'required'   => true,
			'placeholder'=> 'Cognome',
			'decorators' => $this->elementDecorators,
		));

		$this->addElement('text', 'mail', array(
			'filters'    => array('StringTrim', 'StringToLower'),
			'validators' => array(
				array('StringLength', true, array(5, 25))
				//INSERIRE REGEX
			),
			'required'   => true,
			'placeholder'      => 'Mail',
			'decorators' => $this->elementDecorators,
		));

		$this->addElement('textarea', 'messaggio', array(
			'filters'    => array('StringTrim', 'StringToLower'),
			'validators' => array(
				array('StringLength', true, array(5, 25))
			),
			'required'   => true,
			'placeholder'      => 'Scrivi un messaggio...',
			'rows'=>7,
			'cols'=>40,
			'decorators' => $this->elementDecorators,
		));

		$this->addElement('submit', 'inviamessaggio', array(
			'label'    => 'invia messaggio',
			'decorators' => $this->buttonDecorators,
		));

//		$this->setDecorators(array(
//			'FormElements',
//			'Form'
//		));


//
//
//        $this->addElement(
//	        'text',
//    	    'nome',
//        	 array(
//          		'label' => 'Nome',
//
//				 'filters' => array('StringTrim'),
//            	'required' => true));
       
//	    $this->addElement(
//	        'text',
//    	    'cognome',
//        	 array(
//          		'label' => 'Cognome',
//            	'filters' => array('StringTrim'),
//            	'required' => true));
//
//		$this->addElement(
//	        'text',
//    	    'mail',
//        	 array(
//          		'label' => 'E-Mail',
//            	'filters' => array('StringTrim'),
//            	'required' => true));
//
//				$this->addElement(
//	        'text',
//    	    'telefono',
//        	 array(
//          		'label' => 'Telefono',
//            	'filters' => array('StringTrim'),
//            	'required' => true));
//
//        $this->addElement(
//	        'text',
//    	    'oggettomessaggio',
//        	 array(
//          		'label' => 'Oggetto Messaggio',
//            	'filters' => array('StringTrim'),
//            	'required' => true));
//
//
//
//		$this->addElement(
//	        'textarea',
//    	    'messaggio',
//        	 array(
//          		'label' => 'Inserire messaggio: ',
//          		'rows'=>10,
//          		'cols'=>40,
//            	'filters' => array('StringTrim'),
//            	'required' => true));
//
//
//        $this->addElement('submit', 'inviamessaggio', array(
//            'label' => 'Invia',
//        ));

//		$this->setDecorators(array(
//			'FormElements',
////			array('HtmlTag', array('tag' => 'div', 'style' => 'display:inline;')),
//			array('HtmlTag', array(
//				'tag' => 'div',
//				'class' => 'form')
//			),
////			array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
//			'Form'
//		));

    }
    
}