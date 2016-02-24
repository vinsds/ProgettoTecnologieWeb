<?php

class Application_Model_UserAssistenza extends App_Model_Abstract
{
    public function __construct()
    {
        $this->_logger = Zend_Registry::get('log');
    }

    //trova tutti gli id utenti associati ad un determinato centro
    public function getUserByCentro($centro)
    {
        return $this->getResource('UserAssistenza')->getUserByCentro($centro);
    }

    //inserisce l'associazione tra un tecnico e un centro
    public function assUserCentro($user,$centro)
    {
        return $this->getResource('UserAssistenza')->assUserCentro($user,$centro);
    }

    //cancella l'associazione tra un tecnico e il centro
    public function deleteAss($user, $centro)
    {
        return $this->getResource('UserAssistenza')->deleteAss($user,$centro);
    }
}