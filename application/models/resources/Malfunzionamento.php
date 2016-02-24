<?php

class Application_Resource_Malfunzionamento extends Zend_Db_Table
{
    protected $_name = 'malfunzionamento';
    protected $_primary = 'id_malfunzionamento';
    protected $_rowClass = 'Application_Resource_Malfunzionamento_Item';

    public function init()
    {

    }

    public function getMalfunzionamenti($id)
    {
        $select = $this->select()->where('id_malfunzionamento = ?', $id);
        return $this->fetchAll($select);
    }

    public function getMalfunzionamento($id)
    {
        $select = $this->select()->where('id_malfunzionamento = ?', $id);
        return $this->fetchRow($select);
    }

    public function getAll()
    {
        $select = $this->select();
        return $this->fetchAll($select);
    }

    public function insertMalfunzionamento($data) {

       return $this->insert($data);
//        return $this->find($this->insert($data))->current();
        //return the primary key of the row inserted.
    }

    public function editMalfunzionamento($data, $id)
    {
        $where=$this->getAdapter()->quoteInto('id_malfunzionamento=?', $id);
        $this->update($data,$where);
    }

    public function deleteMalfunzionamento($id)
    {
        $this->find($id)->current()->delete();
    }

    /* ricerca */
    public function cercaMalf($pattern)
    {
        $select = $this->select()
            ->where("descrizione REGEXP ?","[[:<:]]".$pattern."[[:>:]]");
        return $this->fetchAll($select);
    }

//    public function getProdottoProblemById($id)
//    {
//        $this->select()->where(['id'=>$id]);
//    }

}