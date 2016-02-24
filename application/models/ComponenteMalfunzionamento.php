<?php

class Application_Model_ComponenteMalfunzionamento extends App_Model_Abstract
{
    public function __construct()
    {
        return $this->_logger = Zend_Registry::get('log');
    }


    public function getComponenteProblemById($id)
    {
        return $this->getResource('ComponenteMalfunzionamento')->getComponenteProblemById($id);
    }

    public function getComponenteProblemByMalf($id)
    {
        return $this->getResource('ComponenteMalfunzionamento')->getComponenteProblemByMalf($id);
    }

    public function assComponenteMalf($comp,$malf)
    {
        return $this->getResource('ComponenteMalfunzionamento')->assComponenteMalf($comp,$malf);
    }

    public function deleteAss($comp,$malf)
    {
        return $this->getResource('ComponenteMalfunzionamento')->deleteAss($comp,$malf);
    }
}