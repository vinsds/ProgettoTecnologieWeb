<?php

class Application_Resource_Assistenza extends Zend_Db_Table_Abstract
{
    protected $_name = 'assistenza';
    protected $_primary = 'id_centro';
    protected $_rowClass = 'Application_Resource_Assistenza_Item';

    public function init()
    {

    }

    /**
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAllCentri()
    {
        $select = $this->select(); //si possono eventualmente ordinare con ->order('cognome ASC');
        return $this->fetchAll($select);
    }


    /**
     * @param $data
     * @return mixed The primary key of the row inserted.
     */
    public function insertCentro($data)
    {
        return $this->insert($data);
    }

    /**
     * @param $data
     * @param $id
     * @return int The number of rows updated.
     */
    public function editCentro($data, $id)
    {
        $where=$this->getAdapter()->quoteInto('id_centro=?', $id);
        return $this->update($data,$where);
    }


    /**
     * @param $id
     * @return int
     * @throws Zend_Db_Table_Exception
     * @throws Zend_Db_Table_Row_Exception
     */
    public function deleteCentro($id)
    {
        return $this->find($id)->current()->delete();
    }

    /**
     * @param $id
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getCentro($id)
    {
        $select = $this->select()->where('id_centro = ?',$id);
        return $this->fetchRow($select);
    }
}