<?php

class Application_Resource_Categorie extends Zend_Db_Table
{
    protected $_name = 'categoria';
    protected $_primary = 'id_categoria';
    protected $_rowClass = 'Application_Resource_Categorie_Item';

    public function init()
    {

    }


    public function getCategorie()
    {
        $select = $this->select();
        return $this->fetchAll($select);
    }

    public function getCategoria($id)
    {
        $select = $this->select()->where('id_categoria  = ?', $id);
        return $this->fetchRow($select);
    }

    public function insertCategoria($data){
        return $this->insert($data);
    }

    public function deleteCat($id)
    {
        return $this->find($id)->current()->delete();
    }

    public function editCategoria($data, $id)
    {
        $where=$this->getAdapter()->quoteInto('id_categoria=?', $id);
        return $this->update($data,$where);
    }

    public function notPeriferiche($id){
        $select=$this->select()->where('id_categoria !=? ', $id);
        return $this->fetchAll($select);
    }
}