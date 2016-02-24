<?php

class Application_Resource_Componente extends Zend_Db_Table
{
    protected $_name = 'componente';
    protected $_primary = 'id_componente';
    protected $_rowClass = 'Application_Resource_Componente_Item';

    /*
    protected $_referenceMap = array(
        'Sottocategoria' => array(
            'columns' => 'id_sottocategoria',     //colonna in sottocategoria
            'refTableClass' => 'sottocategoria',  //nome tabella a cui fa riferimento
            'refColumns' => 'id_sottocategoria'   //chiave primaria della tabella di sopra
        )
    );
    */

    public function init()
    {

    }

    public function getComponente($id)
    {
        $select = $this->select()
            ->where('id_componente = ?', $id);
        return $this->fetchAll($select);
    }

    /* insert prodotto */

    public function insertComponente($data) {

        $this->insert($data);
//        return $this->find($this->insert($data))->current();
        //return the primary key of the row inserted.
    }

    /* edit prodotto */

    public function editComponente($data, $id)
    {

        $where=$this->getAdapter()->quoteInto('id_componente=?', $id);
        $this->update($data,$where);
    }

    /* delete prodotto */

    public function deleteComponente($id)
    {
        return $this->find($id)->current()->delete();
    }

    /* ritorna tutti i prodotti */
    public function getAllComponenti()
    {
        $select = $this->select(); //si possono eventualmente ordinare con ->order('cognome ASC');
        return $this->fetchAll($select);
    }

    public function getComponenteBySottoCategoria($id){
        $select = $this->select()->where('id_sottocategoria = ?', $id);
        return $this->fetchAll($select);
    }


}