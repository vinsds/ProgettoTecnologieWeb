<?php

class Application_Model_Componente extends App_Model_Abstract
{
    public function __construct()
    {
        return $this->_logger = Zend_Registry::get('log');
    }


    public function getComponente($id)
    {
        return $this->getResource('Componente')->getComponente($id);
    }


    /**
     * @param $data
     * @return mixed. Inserisce un nuovo prodotto
     */
    public function insertComponente($data) {

        return $this->getResource('Componente')->insertComponente($data);
    }


    /**
     * @param $data
     * @param $id
     * @return mixed. Aggiorna un prodotto
     */
    public function editComponente($data, $id)
    {
        return $this->getResource('Componente')->editComponente($data, $id);
    }

    /**
     * @param $id
     * @return mixed elimina prodotto
     */
    public function deleteComponente($id)
    {
        return $this->getResource('Componente')->deleteComponente($id);
    }


    /**
     * @return mixed tutti i prodotti
     */
    public function getAllComponenti()
    {
        return $this->getResource('Componente')->getAllComponenti();
    }

    public function getComponenteBySottoCategoria($id){
        return $this->getResource('Componente')->getComponenteBySottoCategoria($id);
    }

}