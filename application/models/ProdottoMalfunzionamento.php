<?php

class Application_Model_ProdottoMalfunzionamento extends App_Model_Abstract
{
    public function __construct()
    {
        return $this->_logger = Zend_Registry::get('log');
    }


    public function getProdottoProblemById($id)
    {
        return $this->getResource('ProdottoMalfunzionamento')->getProdottoProblemById($id);
    }

    public function getProdottoByMalfunzionamento($id){
        return $this->getResource('ProdottoMalfunzionamento')->getProdottoByMalfunzionamento($id);
    }

    public function assProdottoMalf($prodotto,$malf)
    {
        return $this->getResource('ProdottoMalfunzionamento')->assProdottoMalf($prodotto,$malf);
    }

    public function deleteAss($prodotto,$malf)
    {
        return $this->getResource('ProdottoMalfunzionamento')->deleteAss($prodotto,$malf);
    }
}