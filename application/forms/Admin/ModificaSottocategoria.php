<?php

class Application_Form_Admin_ModificaSottocategoria extends App_Form_Abstract
{
    protected $categorie_select;

    public function init()
    {
        $this->setMethod('post');
        $this->setName('modificasottocategoria');
        $this->setAction('');

        $this->categorie_select = new Zend_Form_Element_Select('id_categoria');
        $this->categorie_select->setLabel('Scegli categoria: ');
        $this->categorie_select->setValue('---');
        $this->categorie_select->setRegisterInArrayValidator(false);
        $this->addElement($this->categorie_select);

        $this->addElement(
            'text',
            'nome',
            array(
                'label' => 'Nome Sottocategoria',
                'required' => true,
                'filters' => array('StringTrim'),
                'validators' => array(array('StringLength', true, array(1, 40))),
                'decorators' => $this->elementDecorators
            ));

        $this->addElement('hidden','id_sottocategoria',array(
            'values'
        ));

        $this->addElement('submit', 'submiteditsottocategoria', array(
            'label' => 'Aggiungi sottocategoria',
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
}