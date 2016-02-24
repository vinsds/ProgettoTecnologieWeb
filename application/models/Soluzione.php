<?php

class Application_Model_Soluzione extends App_Model_Abstract
{
    public function __construct()
    {
        return $this->_logger = Zend_Registry::get('log');
    }

    public function getSoluzioni($id)
    {
        return $this->getResource('Soluzione')->getSoluzioni($id);
    }

    public function getSoluzione($id)
    {
        return $this->getResource('Soluzione')->getSoluzione($id);
    }

    public function insertSoluzione($data)
    {
        return $this->getResource('Soluzione')->insertSoluzione($data);
    }

    public function getAll()
    {
        return $this->getResource('Soluzione')->getAll();
    }


    public function editSoluzione($data, $id)
    {
        return $this->getResource('Soluzione')->editSoluzione($data, $id);
    }


    public function deleteSoluzione($id)
    {
        return $this->getResource('Soluzione')->deleteSoluzione($id);
    }
}