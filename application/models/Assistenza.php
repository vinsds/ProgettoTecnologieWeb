<?php

class Application_Model_Assistenza extends App_Model_Abstract
{
    public function init()
    {

    }

    //ritorna tutti i centri
    public function getAllCentri()
    {
        return $this->getResource('Assistenza')->getAllCentri();
    }

    //insert centro
    public function insertCentro($data)
    {
        return $this->getResource('Assistenza')->insertCentro($data);
    }

    //edit profilo centro
    public function editCentro($data, $id)
    {
        return $this->getResource('Assistenza')->editCentro($data, $id);
    }

    //delete centro
    public function deleteCentro($id)
    {
        return $this->getResource('Assistenza')->deleteCentro($id);
    }

    public function getCentro($id)
    {
        return $this->getResource('Assistenza')->getCentro($id);
    }

}