<?php

class Application_Model_Malfunzionamento extends App_Model_Abstract
{
    public function __construct()
    {
        return $this->_logger = Zend_Registry::get('log');
    }

    public function getMalfunzionamenti($id)
    {
        return $this->getResource('Malfunzionamento')->getMalfunzionamenti($id);
    }

    public function getMalfunzionamento($id)
    {
        return $this->getResource('Malfunzionamento')->getMalfunzionamento($id);
    }

    public function insertMalfunzionamento($data)
    {
        return $this->getResource('Malfunzionamento')->insertMalfunzionamento($data);
    }


    public function getAll()
    {
        return $this->getResource('Malfunzionamento')->getAll();
    }

    public function editMalfunzionamento($data, $id)
    {
        return $this->getResource('Malfunzionamento')->editMalfunzionamento($data, $id);
    }


    public function deleteMalfunzionamento($id)
    {
        return $this->getResource('Malfunzionamento')->deleteMalfunzionamento($id);
    }

//    public function getProdottoProblemById($id){
//        return $this->getResource('Malfunzionamento')->getProdottoProblemById($id);
//    }
}