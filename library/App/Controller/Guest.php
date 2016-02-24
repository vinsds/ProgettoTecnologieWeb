<?php

class App_Controller_Guest extends Zend_Controller_Action {
    
    protected $_logger;

    /** @var Application_Model_Faq _faqModel  */
    protected $_faqModel;

    /** @var Application_Model_Prodotto _prodottoModel */
    protected $_prodottoModel;

    /** @var Application_Model_ProdottoComponente _componenti */
    protected $_componenti;

    /** @var Application_Model_Componente _ricercaComponente */
    protected $_ricercaComponente;

    /** @var Application_Model_Sottocategorie _sottocategorie */
    protected  $_sottocategorie;

    /** @var Application_Model_Categorie _categorie */
    protected $_categorie;

    /** @var Application_Model_Menu _menu */
    protected $_menu;

    /** @var Application_Model_Cerca _cerca */
    protected $_cercaModel;

    /** @var Application_Model_Assistenza _centri */
    protected $_centri;

    public function init() {
        
        $this->_helper->layout->setLayout('layout');
        $this->_logger = Zend_Registry::get('log');

        $this->_faqModel = new Application_Model_Faq();
        $this->_prodottoModel = new Application_Model_Prodotto();
        $this->_componenti= new Application_Model_ProdottoComponente();
        $this->_ricercaComponente= new Application_Model_Componente();
        $this->_sottocategorie=new Application_Model_Sottocategorie();
        $this->_categorie=new Application_Model_Categorie();
        $this->_cercaModel=new Application_Model_Cerca();
        $this->_centri=new Application_Model_Assistenza();


    }





    
}
