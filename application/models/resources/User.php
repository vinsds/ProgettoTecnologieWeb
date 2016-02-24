<?php

class Application_Resource_User extends Zend_Db_Table_Abstract
{
    protected $_name = 'user';
    protected $_primary = 'id_user';
    protected $_rowClass = 'Application_Resource_User_Item';

    public function init()
    {

    }

    /**
     * @param $id dell'utente
     * @return null|Zend_Db_Table_Row_Abstract tutte le informazioni di un utente a partire dall'id
     */
    public function getUser($id)
    {
        $select = $this->select()
                        ->where('id_user = ?', $id);
        return $this->fetchRow($select);
    }


    /**
     * @param $data
     * @return mixed The primary key of the row inserted.
     */
    public function insertUser($data) {

        return $this->insert($data);
//        return $this->find($this->insert($data))->current();
    }


    /**
     * @param $data
     * @param $id
     * @return int The number of rows updated.
     */
    public function editUser($data, $id)
    {

        $where=$this->getAdapter()->quoteInto('id_user=?', $id);
        return $this->update($data,$where);
    }

    /* delete utente */

    /**
     * @param $id
     * @return int
     * @throws Zend_Db_Table_Exception
     * @throws Zend_Db_Table_Row_Exception
     */
    public function deleteUser($id)
    {
       return $this->find($id)->current()->delete();
    }

    /* ritorna tutti gli utenti */
    public function getAllUser()
    {
        $select = $this->select(); //si possono eventualmente ordinare con ->order('cognome ASC');
        return $this->fetchAll($select);
    }

    /* ritorna tutti i tecnici a partire dal ruolo */
    public function getTecnici()
    {
        $role = 'tecnico';
        $select = $this->select()
            ->where('role = ?',$role);
        return $this->fetchAll($select);
    }

    public function getUserByName($info)
    {
        return $this->fetchRow($this->select()->where('user = ?',$info));
    }

    public function getAdmin()
    {
        $select = $this->select()->where('role  = ?',"admin");
        return $this->fetchAll($select);
    }




}