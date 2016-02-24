<?php

class Application_Model_Sottocategorie extends App_Model_Abstract
{
    public function __construct()
    {

    }

    public function getSottoCategorie()
    {
        return $this->getResource('Sottocategorie')->getSottoCategorie();
    }

    public function getSottoCategoria($id)
    {
        return $this->getResource('Sottocategorie')->getSottoCategoria($id);
    }

    public function getSottoCategorieById($id)
    {
        return $this->getResource('Sottocategorie')->getSottoCategorieById($id);
    }

    //query di appoggio. Forse da sostituire.
    public function getSottocategoriaByCategoria($id)
    {
        return $this->getResource('Sottocategorie')->getSottocategoriaByCategoria($id);
    }


    public function insertSottoCategoria($data)
    {
        return $this->getResource('Sottocategorie')->insertSottoCategoria($data);
    }

    public function editSottocategoria($data, $id)
    {
        return $this->getResource('Sottocategorie')->editSottocategoria($data, $id);
    }

    public function deleteSubCat($id)
    {
        return $this->getResource('Sottocategorie')->deleteSubCat($id);
    }

//    public function getSottocategoriaByCategoria($id){
//        return $this->getResource('Sottocategorie')->getSottocategoriaByCategoria($id);
//    }
}