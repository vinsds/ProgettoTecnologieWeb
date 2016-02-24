<?php

class App_Controller_Admin extends App_Controller_Staff
{
    /** @var Application_Model_User _userModel */
    protected $_userModel;

    /** @var Application_Model_Assistenza _assistenzaModel  */
    protected $_assistenzaModel;

    /** @var */
    protected $_createForm;

    /** @var */
    protected $_editForm;

    /** @var */
    protected $_addCategoria;

    /** @var */
    protected $_addSubCategoria;

    /** @var   */
    protected $_editCategoria;

    /** @var   */
    protected $_editSubCategoria;


    public function init()
    {

        parent::init();

        $this->_userModel = new Application_Model_User();

        $this->_assistenzaModel = new Application_Model_Assistenza();


        $this->addCategoria= $this->aggiungicategoriaForm();
        $this->addSubCategoria= $this->aggiungisottocategoriaForm();
        $this->editCategoria = $this->editcategoriaForm();
        $this->editSubCategoria = $this->editsottocategoriaForm();


    }


    //// GESTIONE CATEGORIA E SOTTOCATEGORIA ////

    public function aggiungicategoriaForm()
    {
        $this->_addCategoria = new Application_Form_Admin_AggiungiCategoria();
        $this->_addCategoria->setAction($this->_helper->getHelper('url')->url(array(
            'controller'=>'categoria',
            'action'=>'addcategoria'
        )));
        return $this->_addCategoria;
    }

    public function aggiungisottocategoriaForm()
    {
        $this->_addSubCategoria = new Application_Form_Admin_AggiungiSottocategoria();
        $this->_addSubCategoria->setAction($this->_helper->getHelper('url')->url(array(
            'controller'=>'categoria',
            'action'=>'addsottocategoria'
        )));
        return $this->_addSubCategoria;
    }

    public function editcategoriaForm()
    {
        $this->_editCategoria = new Application_Form_Admin_ModificaCategoria();
        $this->_editCategoria->setAction($this->_helper->getHelper('url')->url(array(
            'controller'=>'categoria',
            'action'=>'editcategoria'
        )));
        return $this->_editCategoria;
    }

    public function editsottocategoriaForm()
    {
        $this->_editSubCategoria = new Application_Form_Admin_ModificaSottocategoria()  ;
        $this->_editSubCategoria->setAction($this->_helper->getHelper('url')->url(array(
            'controller'=>'categoria',
            'action'=>'editsottocategoria'
        )));
        return $this->_editSubCategoria;
    }



}

