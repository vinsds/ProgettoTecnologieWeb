<?php

class App_Controller_Tecnico extends App_Controller_Utente {

	/** @var Application_Model_Malfunzionamento _tipoMalfunzionamento */
	protected $_tipoMalfunzionamento;

	/** @var Application_Model_ProdottoMalfunzionamento _prodottoMalfunzionamento */
	protected $_prodottoMalfunzionamento;

	/** @var Application_Model_Soluzione _soluzioni */
	protected $_soluzioni;

	/** @var Application_Model_MalfunzionamentoSoluzione _malfSol */
	protected $_malfSol;

    /** @var   */
	protected $_prodottoModel;

	/** @var   */
	protected $_sottocategorie;

	/** @var   */
	protected $_categorie;

	/** @var   */
	protected $_componenteMalfunzionamento;

	/** @var   */
	protected $_malfunzionamenti;

	/** @var   */
	protected $_componenti;

	/** @var   */
	protected $_ricercaComponente;

	/** @var   */
	protected  $_prodottoComponente;

	/** @var   */
	protected $_search;

	/** @var Application_Form_Public_Search searchForm */
	protected $search;

	/** @var  */
//	protected $_logged_user;

    public function init() {
        parent::init();
//        $this->_helper->layout->setLayout('utente');
        $this->_logger = Zend_Registry::get('log');

		$this->_tipoMalfunzionamento= new Application_Model_Malfunzionamento();
		$this->_prodottoMalfunzionamento= new Application_Model_ProdottoMalfunzionamento();
		$this->_soluzioni=new Application_Model_Soluzione();
		$this->_prodottoModel = new Application_Model_Prodotto();
		$this->_componenti= new Application_Model_Componente();
		$this->_ricercaComponente= new Application_Model_Componente();
		$this->_sottocategorie=new Application_Model_Sottocategorie();

		$this->_prodottoComponente=new Application_Model_ProdottoComponente();

		$this->_categorie=new Application_Model_Categorie();

		//DA CONTROLLARE --> Deve andarci il model
		$this->_malfSol= new Application_Resource_MalfunzionamentoSoluzione();
		$this->_componenteMalfunzionamento= new Application_Model_ComponenteMalfunzionamento();

		$this->_search=new Application_Model_Cerca();



//		$this ->_logged_user = Zend_Auth::getInstance()->getIdentity();
        
    }

	//DA MODIFICARE O DA TOGLIERE
//		protected function getNotifiche()
//	{
//		$this->_notificaModel = new Application_Model_Notifica();
//		$notifica = $this->_notificaModel->getNotificheByUserId($this->getLoggedUser()->id_user)->toArray();
//		$arr = array();
//		/* foreach($notifica as $k){
//			$this->_notificaModel->editStatus($k['id_notifica']);
//		}*/
//		$stato=array();
//		for($i=0; $i<sizeof($notifica); $i++)
//			{
//				if($notifica[$i]['letta']==0) $stato[$i]=$notifica[$i];
//			}
//
//		$n=sizeof($stato);
//		return $n;
//	}
	
}
