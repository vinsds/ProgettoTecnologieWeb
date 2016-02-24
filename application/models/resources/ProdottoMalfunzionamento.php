<?php

class Application_Resource_ProdottoMalfunzionamento extends Zend_Db_Table
{
    protected $_name = 'prodotto_malfunzionamento';
    protected $_primary = array('id_malfunzionamento','id_prodotto');
    protected $_rowClass ='Application_Resource_ProdottoMalfunzionamento_Item';

    public function init()
    {

    }


    public function getProdottoProblemById($id)
    {
        $select = $this->select()->where('id_prodotto = ?', $id);
        return $this->fetchAll($select);
    }

    public function getProdottoByMalfunzionamento($id){
        $select = $this->select()->where('id_malfunzionamento = ?', $id);
        return $this->fetchAll($select);
    }

    public function assProdottoMalf($prodotto,$malf)
    {
        $this->insert(array(
            'id_prodotto'=>$prodotto,
            'id_malfunzionamento'=>$malf
        ));
    }

    public function deleteAss($prodotto,$malf)
    {
        $select=$this->select()
            ->where('id_prodotto', $prodotto)
            ->where('id_malfunzionamento',$malf);
        $p=$this->fetchRow($select);
        $p->delete();
    }
}