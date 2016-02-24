<?php

class Application_Resource_Sottocategorie extends Zend_Db_Table
{
    protected $_name = 'sottocategoria';
    protected $_primary = 'id_sottocategoria';
    protected $_rowClass = 'Application_Resource_Sottocategorie_Item';

    public function init()
    {

    }


    public function getSottoCategorie()
    {
        $select = $this->select();
        return $this->fetchAll($select);
    }

    public function getSottoCategoria($id)
    {
        $select = $this->select()->where('id_sottocategoria = ?', $id);
        return $this->fetchAll($select);
    }

    public function insertSottoCategoria($data){
        return $this->insert($data);
    }

    public function editSottocategoria($data, $id)
    {
        $where=$this->getAdapter()->quoteInto('id_sottocategoria = ?', $id);
        $this->update($data,$where);
    }


    public function getSottoCategorieById($id)
    {
        $select = $this->select()->where('id_categoria = ?', $id);
        return $this->fetchAll($select);
    }

    //query di appoggio. Forse da sostituire.
    public function getSottocategoriaByCategoria($id){
        $select = $this->select()->where('id_sottocategoria = ?', $id);
        return $this->fetchRow($select);
    }

    public function deleteSubCat($id)
    {
        return $this->find($id)->current()->delete();
    }
}