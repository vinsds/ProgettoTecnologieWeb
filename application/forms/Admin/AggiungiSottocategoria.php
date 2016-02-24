<?php

class Application_Form_Admin_AggiungiSottocategoria extends App_Form_Abstract
{
    protected $categorie_select;

    public function init()
    {
        $this->setMethod('post');
        $this->setName('createsottocategoria');
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
                'validators' => array(array('StringLength', true, array(1, 25))),
                'decorators' => $this->elementDecorators
            ));


        $this->addElement('submit', 'aggiungisottocategoria', array(
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