<?php

class Application_Resource_ProdottoComponente extends Zend_Db_Table
{
    protected $_name = 'prodotto_componente';
    protected $_primary = array('id_prodotto','id_componente');
    protected $_rowClass = 'Application_Resource_ProdottoComponente_Item';

    public function init()
    {

    }

    protected $_referenceMap = array(
        'Prodotto' => array(
            'columns' => 'id_prodotto',     //colonna in sottocategoria
            'refTableClass' => 'prodotto',  //nome tabella a cui fa riferimento
            'refColumns' => 'id_prodotto'   //chiave primaria della tabella di sopra
        )
        ,'Componente' => array(
            'columns' => 'id_componente',     //colonna in sottocategoria
            'refTableClass' => 'componente',  //nome tabella a cui fa riferimento
            'refColumns' => 'id_componente'
        )
    );


    public function getComponenteByProdotto($prodotto)
    {
        $select = $this->select()
            ->where('id_prodotto = ?', $prodotto);
        return $this->fetchAll($select);

    }

    public function getProdottoByComponente($idComponente)
    {
        $select = $this->select()
            ->where('id_componente = ?', $idComponente);
        return $this->fetchAll($select);

    }

    /* insert prodotto */

    public function assProdottoComp($prodotto,$comp)
    {
        return $this->insert(array(
            'id_prodotto'=>$prodotto,
            'id_componente'=>$comp
        ));
//        return $this->find($this->insert($data))->current();
        //return the primary key of the row inserted.
    }


    public function editProdotto($data, $id)
    {

        $where=$this->getAdapter()->quoteInto('id_prodotto=?', $id);
        $this->update($data,$where);
    }

    /* delete prodotto */

    public function deleteAss($prodotto,$comp)
    {
        $select=$this->select()
            ->where('id_prodotto', $prodotto)
            ->where('id_componente',$comp);
        $p=$this->fetchRow($select);
        $p->delete();
    }

}