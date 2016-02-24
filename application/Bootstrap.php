<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	protected $_logger;
	protected $_view;

        protected function _initRequest()
	// Aggiunge un'istanza di Zend_Controller_Request_Http nel Front_Controller
	// che permette di utilizzare l'helper baseUrl() nel Bootstrap.php
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }
        
	protected function _initLogging()
    {
        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Firebug();
        $logger->addWriter($writer);

        Zend_Registry::set('log', $logger);

        $this->_logger = $logger;
    	$this->_logger->info('Bootstrap ' . __METHOD__);
    }
	
	protected function _initViewSettings()
	{
		$this->bootstrap('view');
		$this->_view=$this->getResource('view');
                $this->_view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
		$this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/main.css'))
			->appendStylesheet($this->_view->baseUrl('plugins/font-awesome/css/font-awesome.css'));

		$this->_view->headScript()->appendFile($this->_view->baseUrl('js/jquery.js', 'text/javascript'))
			->appendFile($this->_view->baseUrl('js/main.js', 'text/javascript'));

		$this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
		$this->_view->headTitle('Corso di Tecnologie Web - Zend Project');

	}
	
	protected function _initDefaultModuleAutoloader()
	 {
    	$loader = Zend_Loader_Autoloader::getInstance();
		$loader->registerNamespace('App_');
        $this->getResourceLoader()
             ->addResourceType('modelResource','models/resources','Resource');  
  	}
	 
	//serve per dire al front controller che ho un nuovo plugin (lo registro) 
	 protected function _initFrontControllerPlugin()
    {
    	$front = Zend_Controller_Front::getInstance(); //xkè è un singleton
    	$front->registerPlugin(new App_Controller_Plugin_Acl());
    }
    
    
    protected function _initDbParms()
    {
    	include_once (APPLICATION_PATH . '../../include/connect.php');
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
    			'host'     => $HOST,
    			'username' => $USER,
    			'password' => $PASSWORD,
			'dbname' => $DB,
			'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8;')
				));  
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
	}
     
	
}
