<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract{

    //$_name -> nome tabella
    protected $_name    = 'faq';
    //$_primary -> nome chiave primaria
    protected $_primary  = 'id_faq';
    //$_rowClass -> Classe Item corrispondente
    protected $_rowClass = 'Application_Resource_Faq_Item';

    public function init(){

    }

    public function getFaq($id)
    {
        $select = $this->select()->where('id_faq = ?', $id);
        return $this->fetchRow($select);
    }

    public function getFaqList()
    {
        $select = $this->select();
        return $this->fetchAll($select);
    }

    public function insertFaq($data){

        $this->insert($data);
        //return the primary key of the row inserted.
    }

    public function deleteFaq($id)
    {
        $this->find($id)->current()->delete();
    }

    public function editFaq($data, $id)
    {
        $where=$this->getAdapter()->quoteInto('id_faq=?', $id);
        $this->update($data,$where);
    }
}
