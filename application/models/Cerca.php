<?php

class Application_Model_Cerca extends App_Model_Abstract
{
    public function __construct()
    {

    }

    public function cercaDesc($pattern)
    {
        return $this->getResource('Prodotto')->cercaDesc($pattern);
    }

    public function cercaMalf($pattern)
    {
        return $this->getResource('Malfunzionamento')->cercaMalf($pattern);
    }
}