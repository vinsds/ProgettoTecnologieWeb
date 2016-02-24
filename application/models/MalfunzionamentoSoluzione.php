<?php

class Application_Model_MalfunzionamentoSoluzione extends App_Model_Abstract
{
    public function __construct()
    {
        return $this->_logger = Zend_Registry::get('log');
    }

    public function assMalfSoluzione($malf,$solu)
    {
        return $this->getResource('MalfunzionamentoSoluzione')->assMalfSoluzione($malf,$solu);
    }


    public function getSoluzioneByMalfunzionamento($id)
    {
        return $this->getResource('MalfunzionamentoSoluzione')->getSoluzioneByMalfunzionamento($id);
    }

    public function deleteAss($malf,$solu)
    {
        return $this->getResource('MalfunzionamentoSoluzione')->deleteAss($malf,$solu);
    }
//
//    public function deleteAss($id){
//        return $this->getResource('MalfunzionamentoSoluzione')->deleteAss($id);
//    }


    public function getMalfunzionamentoSoluzione($id){
        return $this->getResource('MalfunzionamentoSoluzione')->getMalfunzionamentoSoluzione($id);
    }

}