<?php

class Application_Model_ProdottoComponente extends App_Model_Abstract
{
    public function __construct()
    {

    }

    public function getComponenteByProdotto($prodotto)
    {
        return $this->getResource('ProdottoComponente')->getComponenteByProdotto($prodotto);
    }

    public function getProdottoByComponente($idComponente)
    {
        return $this->getResource('ProdottoComponente')->getProdottoByComponente($idComponente);
    }


    public function assProdottoComp($prodotto,$comp)
    {
        return $this->getResource('ProdottoComponente')->assProdottoComp($prodotto,$comp);
    }

    public function editProdotto($data, $id)
    {
        return $this->getResource('ProdottoComponente')->editProdotto($data, $id);
    }

    public function deleteAss($prodotto,$comp)
    {
        return $this->getResource('ProdottoComponente')->deleteAss($prodotto,$comp);
    }
}