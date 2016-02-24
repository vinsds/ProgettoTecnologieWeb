<?php

class Application_Resource_Soluzione extends Zend_Db_Table
{
    protected $_name = 'soluzione';
    protected $_primary = 'id_soluzione';
    protected $_rowClass = 'Application_Resource_Soluzione_Item';

    public function init()
    {

    }

    /* lista tutte le soluzioni presenti */
    public function getSoluzioni($id)
    {
        $select = $this->select()->where('id_soluzione = ?', $id);
        return $this->fetchAll($select);
    }

    /* lista tutte le soluzioni presenti */
    public function getSoluzione($id)
    {
        $select = $this->select()->where('id_soluzione = ?', $id);
        return $this->fetchRow($select);
    }

    public function getAll()
    {
        $select = $this->select();
        return $this->fetchAll($select);
    }

    /* inserisce una nuova soluzione */
    public function insertSoluzione($data) {

        return $this->insert($data);
//        return $this->find($this->insert($data))->current();
        //return the primary key of the row inserted.
    }

    /* modifica una soluzione */
    public function editSoluzione($data, $id)
    {

        $where=$this->getAdapter()->quoteInto('id_soluzione=?', $id);
        $this->update($data,$where);
    }

    public function deleteSoluzione($id)
    {
        $this->find($id)->current()->delete();
    }

}