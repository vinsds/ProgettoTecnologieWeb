<?php

class Application_Service_Auth
{
    protected $_utenteModel;
    protected $_auth;

    public function __construct()
    {
    	//definita perchè devo leggere la tabella utente
        $this->_utenteModel = new Application_Model_User();
    }
    
	//metodo che ritorna true o false al chiamante
    public function authenticate($credentials)
    {
    	//definisco il canale (tipo file o tabella)
        $adapter = $this->getAuthAdapter($credentials);
        $auth    = $this->getAuth();
		//vediamo se si può autenticare tramite il canale che definisco io (adapter)
        $result  = $auth->authenticate($adapter);

        if (!$result->isValid()) {
            return false;
        }
        $user = $this->_utenteModel->getUserByName($credentials['user']);
		//estraggo e scrivo sulla sessione l'utente
        $auth->getStorage()->write($user);
        return true;
    }
    
	//verifica se qualche altro metodo ha instanziato l'oggetto autenticazione $auth
	//else gli assegna il componente di Zend
    public function getAuth()
    {
        if (null === $this->_auth) {
            $this->_auth = Zend_Auth::getInstance();
        }
        return $this->_auth;
    }
	
   //lo userò nel controller per estrarre i valori della "$_SESSION"
    public function getIdentity()
    {
        $auth = $this->getAuth();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        return false;
    }
    
	//per fare logout
    public function clear()
    {
        $this->getAuth()->clearIdentity();
    }
    
    public function getAuthAdapter($values)
    {
    	//inizializzo la tabella del DB
		$authAdapter = new Zend_Auth_Adapter_DbTable(
			Zend_Db_Table_Abstract::getDefaultAdapter(),	//PDO:il canale
			'user',	//nome tabella
			'user',
			'password'
		);
		$authAdapter->setIdentity($values['user']);	//setto user come identità
		$authAdapter->setCredential($values['password']); //setto password come credenziali
        return $authAdapter;
    }
}
