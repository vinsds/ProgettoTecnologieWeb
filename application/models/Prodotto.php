<?php

class Application_Model_Prodotto extends App_Model_Abstract
{
    public function __construct()
    {
        return $this->_logger = Zend_Registry::get('log');
    }


    public function getProdotto($id)
    {
        return $this->getResource('Prodotto')->getProdotto($id);
    }


    /**
     * @param $data
     * @return mixed. Inserisce un nuovo prodotto
     */
    public function insertProdotto($data) {

        return $this->getResource('Prodotto')->insertProdotto($data);
    }


    /**
     * @param $data
     * @param $id
     * @return mixed. Aggiorna un prodotto
     */
    public function editProdotto($data, $id)
    {
        return $this->getResource('Prodotto')->editProdotto($data,$id);
    }

    /**
     * @param $id
     * @return mixed elimina prodotto
     */
    public function deleteProdotto($id)
    {
        return $this->getResource('Prodotto')->deleteProdotto($id);
    }


    /**
     * @return mixed tutti i prodotti
     */
    public function getAllProdotti()
    {
        return $this->getResource('Prodotto')->getAllProdotti();
    }

    public function getProdottoBySottoCategoria($id){
        return $this->getResource('Prodotto')->getProdottoBySottoCategoria($id);
    }


    public function getProdottoByCategoria($id){
        return $this->getResource('Prodotto')->getProdottoByCategoria($id);
    }



}