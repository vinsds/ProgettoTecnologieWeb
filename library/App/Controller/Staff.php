<?php

class App_Controller_Staff extends App_Controller_Tecnico
{

    protected $_assMalfunzionamentoProdotto;
    protected $_prodottoModel;
    protected $_prodottoMalfunzionamento;
    protected $_tipoMalfunzionamento;
    protected $_prodottoComponente;
    protected $_componenti;
    protected $_componenteMalfunzionamento;
    protected $_assMalfunzionamentoComponente;
    protected $_assMalfunzionamentoSoluzione;
    protected $_malfunzionamento;
    protected $_soluzione;
    protected $_malfSol;
    protected $_search;

    protected $_formCreate;
    protected $_formCreateS;
    protected $_formEditM;
    protected $_formEditS;


    protected $editFormM;
    protected $editFormS;


    public function init()
    {
        parent::init();
        $this->_prodottoModel = new Application_Model_Prodotto();
        $this->_prodottoMalfunzionamento = new Application_Model_ProdottoMalfunzionamento();
        $this->_tipoMalfunzionamento = new Application_Model_Malfunzionamento();
        $this->_prodottoComponente = new Application_Model_ProdottoComponente();
        $this->_componenti = new Application_Model_Componente();
        $this->_componenteMalfunzionamento = new Application_Model_ComponenteMalfunzionamento();

        $this->_assMalfunzionamentoProdotto = new Application_Model_ProdottoMalfunzionamento();
        $this->_assMalfunzionamentoComponente = new Application_Model_ComponenteMalfunzionamento();
        $this->_assMalfunzionamentoSoluzione = new Application_Model_MalfunzionamentoSoluzione();
        $this->_malfunzionamento = new Application_Model_Malfunzionamento();
        $this->_soluzione = new Application_Model_Soluzione();
        $this->_search = new Application_Model_Cerca();
        $this->_malfSol = new Application_Resource_MalfunzionamentoSoluzione();

        $this->view->createFormM = $this->getCreateFormM();
        $this->view->createFormS = $this->getCreateFormS();
        $this->editFormM = $this->getEditFormM();
        $this->editFormS = $this->getEditFormS();

    }

    private function getCreateFormM()
    {
//        $urlHelper = $this->_helper->getHelper('url');
        $this->_formCreate = new Application_Form_Staff_Create();
        $this->_formCreate->setAction($this->_helper->getHelper('url')->url(array(
            'controller' => 'malfunzionamento',
            'action' => 'createm'),
            'default'
        ));
        return $this->_formCreate;
    }

    private function getCreateFormS()
    {

//        $urlHelper = $this->_helper->getHelper('url');
        $this->_formCreateS = new Application_Form_Staff_CreateS();
        $this->_formCreateS->setAction($this->_helper->getHelper('url')->url(array(
            'controller' => 'malfunzionamento',
            'action' => 'creates'),
            'default'
        ));
        return $this->_formCreateS;

    }


    private function getEditFormM()
    {

//        $urlHelper = $this->_helper->getHelper('url');
        $this->_formEditM = new Application_Form_Staff_Edit();
        $this->_formEditM->setAction($this->_helper->getHelper('url')->url(array(
            'controller' => 'malfunzionamento',
            'action' => 'editm'),
            'default'
        ));
        return $this->_formEditM;

    }

    private function getEditFormS()
    {

        $this->_formEditS = new Application_Form_Staff_EditS();
        $this->_formEditS->setAction($this->_helper->getHelper('url')->url(array(
            'controller' => 'malfunzionamento',
            'action' => 'edits'),
            'default'
        ));
        return $this->_formEditS;

    }




}