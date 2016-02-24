<?php

class Application_Model_User extends App_Model_Abstract
{
    public function  __construct()
    {
        $this->_logger = Zend_Registry::get('log');
    }


    //ritorna tutte le informazioni di un utente a partire dall'id
    public function getUser($id)
    {
        return $this->getResource('User')->getUser($id);
    }

    //insert utente
    public function insertUser($data)
    {
        return $this->getResource('User')->insertUser($data);
    }

    //edit profilo utente
    public function editUser($data, $id)
    {
        return $this->getResource('User')->editUser($data, $id);
    }

    //delete utente
    public function deleteUser($id)
    {
        return $this->getResource('User')->deleteUser($id);
    }

    //ritorna tutti gli utenti
    public function getAllUser()
    {
        return $this->getResource('User')->getAllUser();
    }

    //ritorna tutti i tecnici
    public function getTecnici()
    {
        return $this->getResource('User')->getTecnici();
    }

    public function getUserByName($info)
    {
        return $this->getResource('User')->getUserByName($info);
    }

    public function getAdmin()
    {
        return $this->getResource('User')->getAdmin();
    }

}