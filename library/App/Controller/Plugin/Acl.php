<?php

class App_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	protected $_acl;
	protected $_role;
	protected $_auth;

	public function __construct()
	{
        $this->_auth = Zend_Auth::getInstance();
		$this->_role = !$this->_auth->hasIdentity() ? 'guest' : $this->_auth->getIdentity()->role;
    	$this->_acl = new Application_Model_Acl();    	
	}
	
	//stesso nome dell'hook (per vedere se esiste una risorsa a cui accedere che ha il nome del controller richiesto)
    public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		if (!$this->_acl->isAllowed($this->_role, $request->getControllerName())) {
			$this->_auth->clearIdentity();
			$this->denyAccess();
		}
	}
	
	public function denyAccess()
	{
   		$this->_request->setModuleName('default')
   					   ->setControllerName('login') //public
					   ->setActionName('index');
	}
	
	public function getRole()
	{
		return $this->_role;
	}
}
