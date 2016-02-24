<?php

class Application_Form_Admin_ModificaProdotto extends App_Form_Abstract
{
    protected $categorie_select;
    protected $sub_categorie_select;

    public function init()
    {
        $this->setMethod('post');
        $this->setName('modificaprodotto');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAction('');

        $this->categorie_select = new Zend_Form_Element_Select('id_categoria');
        $this->categorie_select->setLabel('Categoria prodotto: ');
        $this->categorie_select->setValue('---');
        $this->addElement($this->categorie_select);


        $this->sub_categorie_select = new Zend_Form_Element_Select('id_sottocategoria');
        $this->sub_categorie_select->setLabel('Sottocategoria prodotto: ');
        $this->sub_categorie_select->setValue('---');
        $this->sub_categorie_select->setRegisterInArrayValidator(false);
//        $this->sub_categorie_select->setAttrib('class' , 'hidden');
        $this->addElement($this->sub_categorie_select);


//        $this->addElement('hidden', 'id_prodotto', array(
//            'value' => ''
//        ));

        $this->addElement('file', 'img_path', array(
            'label' => 'Immagine del prodotto',
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
                'label' => 'Nome prodotto',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 40))),
                'decorators' => $this->elementDecorators
            ));

//        $this->addElement(
//            'text',
//            'desc_prod',
//            array(
//                'label' => 'Descrizione prodotto',
//                'required' => true,
//                'filters' => array('StringTrim'),
//                'validators' => array(array('StringLength', true, array(1, 100))),
//                'decorators' => $this->elementDecorators
//            ));

        $this->addElement('textarea', 'desc_prod', array(
            'label' => "Descrizione lunga prodotto",
            'filters' => array('StringTrim'),
            'required' => true,
            'placeholder' => 'Descrizione centro',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'istruzioni', array(
            'label' => "Istruzioni",
            'filters' => array('StringTrim'),
            'required' => true,
            'placeholder' => 'Istruzioni',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'note', array(
            'label' => "Note",
            'filters' => array('StringTrim'),
            'required' => true,
            'placeholder' => 'Note',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('hidden','id_prodotto',array(
            'value'=>''
        ));

        $this->addElement('submit', 'submiteditprodotto', array(
            'label' => 'Inserisci prodotto',
            'decorators' => $this->buttonDecorators,
        ));
    }

    /* riceve i dati della query getCategorie()  */

    public function AddCategorieToSelect($data)
    {
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->categorie_select->addMultiOption($data[$i]['id_categoria'], $data[$i]['nome']);
        }

    }

    public function AddSubCategorieToSelect($data)
    {
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->sub_categorie_select->addMultiOption($data[$i]['id_sottocategoria'], $data[$i]['nome']);
        }

    }
}