<?php

class Application_Model_UserAssistenza extends App_Model_Abstract
{
    public function __construct()
    {
        $this->_logger = Zend_Registry::get('log');
    }

    public function getUserByProdotto($prodotto)
    {
        return $this->getResource('UserProdotto')->getUserByProdotto($prodotto);
    }

    /* inserisce l'associazione tra uno staffer e un prodotto */
    public function assUserProdotto($user,$prodotto)
    {
        return $this->getResource('UserProdotto')->assUserProdotto($user,$prodotto);
    }

    public function deleteAss($user, $prodotto)
    {
        return $this->getResource('UserProdotto')->deleteAss($user, $prodotto);
    }

}