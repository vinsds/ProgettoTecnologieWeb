<?php

class Application_Form_Admin_InserisciComponente extends App_Form_Abstract
{
    protected $sottocategorie;
    protected $categorie_select;

    public function init()
    {
        $this->setMethod('post');
        $this->setName('createcomponente');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAction('');

//        $this->categorie_select = new Zend_Form_Element_Select('id_categoria');
//        $this->categorie_select->setLabel('Categoria componente: ');
//        $this->categorie_select->setValue('---');
//        $this->categorie_select->setRegisterInArrayValidator(false);
//        $this->addElement($this->categorie_select);

        $this->sottocategorie = new Zend_Form_Element_Select('id_sottocategoria');
        $this->sottocategorie->setLabel('Sottocategoria componente: ');
        $this->sottocategorie->setValue('---');
        $this->sottocategorie->setRegisterInArrayValidator(false); //necessario
        $this->addElement($this->sottocategorie);

        $this->addElement('file', 'img_path', array(
            'label' => 'Immagine del componenente',
            'destination' => APPLICATION_PATH.'/../public/import/',
            'validators' => array(
                array('Count', false, 1),
                array('Size', false, 3096000),
                array('Extension', false, array('jpg','png'))
            )
        ));

        $this->addElement(
            'text',
            'nome',
            array(
                'label' => 'Nome componente',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 40))),
                'decorators' => $this->elementDecorators
            ));

        $this->addElement('textarea', 'desc_comp', array(
            'label' => "Descrizione lunga prodotto",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Descrizione componenente',
            'decorators' => $this->elementDecorators,
        ));

//        $this->addElement('textarea', 'desc_long', array(
//            'label' => "Descrizione lunga prodotto",
//            'filters' => array('StringTrim', 'StringToLower'),
//            'required' => true,
//            'placeholder' => 'Descrizione lunga componente',
//            'decorators' => $this->elementDecorators,
//        ));

        $this->addElement('textarea', 'istruzioni', array(
            'label' => "Istruzioni",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Istruzioni',
            'decorators' => $this->elementDecorators,
        ));
//
        $this->addElement('textarea', 'note', array(
            'label' => "Note",
            'filters' => array('StringTrim', 'StringToLower'),
            'required' => true,
            'placeholder' => 'Note',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('submit', 'submitcomponente', array(
            'label' => 'Inserisci componente',
            'decorators' => $this->buttonDecorators,
        ));
    }

    public function AddCategorieToSelect($data)
    {
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->categorie_select->addMultiOption($data[$i]['id_categoria'], $data[$i]['nome']);
        }

    }

    public function AddSubCatToSelect($data)
    {
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->sottocategorie->addMultiOption($data[$i]['id_sottocategoria'], $data[$i]['nome']);
        }

    }

}