<?php

class Application_Model_Categorie extends App_Model_Abstract
{
    public function __construct()
    {

    }

    public function getCategorie()
    {
        return $this->getResource('Categorie')->getCategorie();
    }

    public function getCategoria($id)
    {
        return $this->getResource('Categorie')->getCategoria($id);
    }

    public function insertCategoria($data)
    {
        return $this->getResource('Categorie')->insertCategoria($data);
    }

    public function deleteCat($id)
    {
        return $this->getResource('Categorie')->deleteCat($id);
    }

    public function editCategoria($data,$id)
    {
        return $this->getResource('Categorie')->editCategoria($data,$id);
    }

    public function notPeriferiche($id)
    {
        return $this->getResource('Categorie')->notPeriferiche($id);
    }



}