<?php

class Application_Resource_Prodotto extends Zend_Db_Table
{
    protected $_name = 'prodotto';
    protected $_primary = 'id_prodotto';
    protected $_rowClass = 'Application_Resource_Prodotto_Item';

    /*protected $_referenceMap = array(
        'Sottocategoria' => array(
            'columns' => 'id_sottocategoria',     //colonna in sottocategoria
            'refTableClass' => 'sottocategoria',  //nome tabella a cui fa riferimento
            'refColumns' => 'id_sottocategoria'   //chiave primaria della tabella di sopra
        )
    );*/


    public function init()
    {

    }

    public function getProdotto($id)
    {
        $select = $this->select()
            ->where('id_prodotto = ?', $id);
        return $this->fetchRow($select);
    }

    /* insert prodotto */

    public function insertProdotto($data) {

        return $this->insert($data);
//        return $this->find($this->insert($data))->current();
        //return the primary key of the row inserted.
    }

    /* edit prodotto */

    public function editProdotto($data, $id)
    {

        $where=$this->getAdapter()->quoteInto('id_prodotto = ?', $id);
        $this->update($data,$where);
    }

    /* delete prodotto */

    public function deleteProdotto($id)
    {
        return $this->find($id)->current()->delete();
    }

    /* ritorna tutti i prodotti */
    public function getAllProdotti()
    {
        $select = $this->select(); //si possono eventualmente ordinare con ->order('cognome ASC');
        return $this->fetchAll($select);
    }

    /* ricerca */
    public function cercaDesc($pattern)
    {
        $select = $this->select()
            ->where("desc_prod REGEXP ?","[[:<:]]".$pattern."[[:>:]]");
        return $this->fetchAll($select);
        //where("desc_prod LIKE ?","%".$pattern);
    }

    public function getProdottoBySottoCategoria($id){
        $select = $this->select()->where('id_sottocategoria = ?', $id);
        return $this->fetchAll($select);
    }

    public function getProdottoByCategoria($id){
        $select = $this->select()->where('id_categoria = ?', $id);
        return $this->fetchAll($select);
    }
}